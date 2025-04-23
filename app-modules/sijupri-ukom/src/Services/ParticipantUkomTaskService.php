<?php

namespace Eyegil\SijupriUkom\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\Base\Commons\EncriptionKey;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\Base\Pageable;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriUkom\Enums\UkomFlow;
use Eyegil\SijupriMaintenance\Services\InstansiService;
use Eyegil\SijupriMaintenance\Services\JabatanService;
use Eyegil\SijupriMaintenance\Services\JenisKelaminService;
use Eyegil\SijupriMaintenance\Services\JenjangService;
use Eyegil\SijupriMaintenance\Services\PangkatService;
use Eyegil\SijupriMaintenance\Services\UnitKerjaService;
use Eyegil\SijupriSiap\Services\JFService;
use Eyegil\SijupriUkom\Dtos\DocumentUkomDto;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomPendingTaskDto;
use Eyegil\SijupriUkom\Enums\JenisUkom;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Converters\PendingTaskConverter;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\PendingTask;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Eyegil\SecurityBase\Services\UserService;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SecurityPassword\Dtos\PasswordDto;
use Eyegil\SecurityPassword\Services\PasswordService;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Eyegil\SijupriMaintenance\Services\SystemConfigurationService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ParticipantUkomTaskService
{
    private const workflow_name = "participant_ukom_task";

    public function __construct(
        private ParticipantUkomService $participantUkomService,
        private InstansiService $instansiService,
        private UnitKerjaService $unitKerjaService,
        private JFService $jFService,
        private JenisKelaminService $jenisKelaminService,
        private JabatanService $jabatanService,
        private JenjangService $jenjangService,
        private PangkatService $pangkatService,
        private StorageService $storageService,
        private DocumentUkomService $documentUkomService,
        private WorkflowService $workflowService,
        private UserService $userService,
        private UserAuthenticationService $userAuthenticationService,
        private PasswordService $passwordService,
        private SendNotifyService $sendNotifyService,
        private SystemConfigurationService $systemConfigurationService,
        private StorageSystemService $storageSystemService,
    ) {}

    public function findSearch(Pageable $pageable, array $queryParam = [])
    {
        $userContext = user_context();
        $pageable->addEqual("task_status", TaskStatus::PENDING);
        $pageable->addEqual("workflow_name", $this::workflow_name);

        if (in_array($userContext->application_code, ["sijupri-internal", "sijupri-external"])) {
            $pageable->addNotEqualIn("flow_id", [UkomFlow::FLOW_2->value]);
            $pageable->addEqual("object_group", $userContext->id);
        }

        return $pageable->setJoinQueries(function (Pageable $instance, Builder $query) use ($queryParam) {
            $query->join('wf_object_task', function (JoinClause $join) use ($instance, $queryParam) {
                $join->on('wf_pending_task.object_task_id', '=', 'wf_object_task.id');
                if (isset($queryParam['eq_jenis_ukom'])) {
                    $join->where('wf_object_task.object->jenis_ukom', $queryParam['eq_jenis_ukom']);
                }
                if (isset($queryParam['like_next_jabatan_name'])) {
                    $join->where('wf_object_task.object->next_jabatan_name', 'ILIKE', '%' . $queryParam['like_next_jabatan_name'] . '%');
                }
                if (isset($queryParam['like_jabatan_name'])) {
                    $join->where('wf_object_task.object->jabatan_name', 'ILIKE', '%' . $queryParam['like_jabatan_name'] . '%');
                }
            });
        }, true)->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PendingTask::class);
    }

    public function findFailedSearch(Pageable $pageable, array $queryParam)
    {
        $userContext = user_context();
        $pageable->addEqual("task_status", TaskStatus::FAILED);
        $pageable->addEqual("workflow_name", $this::workflow_name);

        if (in_array($userContext->application_code, ["sijupri-internal", "sijupri-external"])) {
            $pageable->addEqual("object_group", $userContext->id);
        }

        return $pageable->setJoinQueries(function (Pageable $instance, Builder $query) use ($queryParam) {
            $query->join('wf_object_task', function (JoinClause $join) use ($instance, $queryParam) {
                $join->on('wf_pending_task.object_task_id', '=', 'wf_object_task.id');
                if (isset($queryParam['eq_jenis_ukom'])) {
                    $join->where('wf_object_task.object->jenis_ukom', $queryParam['eq_jenis_ukom']);
                }
                if (isset($queryParam['like_next_jabatan_name'])) {
                    $join->where('wf_object_task.object->next_jabatan_name', 'ILIKE', '%' . $queryParam['like_next_jabatan_name'] . '%');
                }
                if (isset($queryParam['like_jabatan_name'])) {
                    $join->where('wf_object_task.object->jabatan_name', 'ILIKE', '%' . $queryParam['like_jabatan_name'] . '%');
                }
            });
        }, true)->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PendingTask::class);
    }

    public function findByParticipantUkomId($participant_ukom_id)
    {
        $pendingTask = PendingTask::where("object_id", $participant_ukom_id)->first();
        return $this->findByNip($pendingTask->object_group);
    }

    public function findByNip($nip)
    {
        $pendingTask = $this->workflowService->findTaskByWorkflowNameAndObjectGroup($this::workflow_name, $nip);
        $participantUkomDto = (new ParticipantUkomDto())->fromArray((array) $pendingTask->objectTask->object);
        $participantUkomPendingTaskDto = (new ParticipantUkomPendingTaskDto())->fromArray($participantUkomDto->toArray());
        $participantUkomPendingTaskDto->fromArray(PendingTaskConverter::withPendingTaskHistory($pendingTask)->toArray());
        $participantUkomPendingTaskDto->participant_ukom_id = $participantUkomDto->id;

        return $participantUkomPendingTaskDto;
    }

    public function getDetailTask($pending_task_id)
    {
        $pendingTask = $this->workflowService->findTaskByWorkflowNameAndId($this::workflow_name, $pending_task_id);
        $participantUkomDto = (new ParticipantUkomDto())->fromArray((array) $pendingTask->objectTask->object);
        $participantUkomPendingTaskDto = (new ParticipantUkomPendingTaskDto())->fromArray($participantUkomDto->toArray());
        $participantUkomPendingTaskDto->fromArray(PendingTaskConverter::withPendingTaskHistory($pendingTask)->toArray());
        $participantUkomPendingTaskDto->participant_ukom_id = $participantUkomDto->id;

        return $participantUkomPendingTaskDto;
    }

    public function createWithJf(ParticipantUkomDto $participantUkomDto)
    {
        DB::transaction(function () use ($participantUkomDto) {
            $systemConf = $this->systemConfigurationService->findByCode("UKM_REGISTRATION");
            if ($systemConf->value == "tidak") {
                throw new BusinessException("Ukom registration is closed", "UKM-00003");
            }

            $jf = $this->jFService->findByNip($participantUkomDto->nip);
            $user = $jf->user;
            if (!$user->email || !$user->phone) {
                throw new BusinessException("Please finish your profile (email and phone)", "UKM-00002");
            }

            $unitKerja = $jf->unitKerja;

            $riwayatJabatan = $jf->riwayatJabatan;
            $riwayatPangkat = $jf->riwayatPangkat;

            $jabatan = $riwayatJabatan->jabatan;
            $jenjang = $riwayatJabatan->jenjang;
            $pangkat = $riwayatPangkat->pangkat;

            if ($participantUkomDto->jenis_ukom == JenisUkom::KENAIKAN_JENJANG->value) {
                $nextJabatan = $jabatan;
                $nextJenjang = $this->jenjangService->findNextBycode($jenjang->code);
                $nextPangkat = $pangkat;
            } else if ($participantUkomDto->jenis_ukom == JenisUkom::PERPINDAHAN_JABATAN->value) {
                $nextJabatan = $this->jabatanService->findByCode($participantUkomDto->next_jabatan_code);
                $nextJenjang = $jenjang;
                $nextPangkat = $pangkat;
            } else {
                throw new RecordNotFoundException("jenis_ukom not found", ['jenis_ukom' => $participantUkomDto->jenis_ukom]);
            }

            $participantUkomDto->name = $user->name;
            $participantUkomDto->email = $user->email;
            $participantUkomDto->phone = $user->phone;

            $participantUser = $this->userService->findByIdv2("PU-" . $participantUkomDto->nip);
            if (!$participantUser) {
                $participantUkomDto->id = "PU-" . $participantUkomDto->nip;
                $participantUkomDto->role_code_list = [];
                $participantUkomDto->application_code = 'siukom-participant';
                $participantUkomDto->channel_code_list = ['WEB', 'MOBILE'];

                $this->userAuthenticationService->register($participantUkomDto);

                $participantUkomDto->user_id = $participantUkomDto->id;
            } else {
                if ($this->participantUkomService->findByUserId("PU-" . $participantUkomDto->nip)) {
                    throw new RecordExistException("participant with nip " . $participantUkomDto->nip . " already exist");
                }

                $participantUkomDto->id = "PU-" . $participantUkomDto->nip;
                $participantUkomDto->role_code_list = [];
                $participantUkomDto->application_code = 'siukom-participant';
                $participantUkomDto->channel_code_list = ['WEB', 'MOBILE'];
                $this->userService->update($participantUkomDto);

                $passwordDto = new PasswordDto();
                $passwordDto->user_id = $participantUser->id;
                $passwordDto->password = $participantUkomDto->password;
                $this->passwordService->forceUpdate($passwordDto);

                $participantUkomDto->user_id = $participantUser->id;
            }
            $participantUkomDto->password = null;

            $participantUkomDto->id = Str::uuid();

            $participantUkomDto->pangkat_code = $pangkat->code;
            $participantUkomDto->pangkat_name = $pangkat->name;
            $participantUkomDto->jabatan_name = $jabatan->name;
            $participantUkomDto->jenjang_name = $jenjang->name;
            $participantUkomDto->next_jabatan_code = $nextJabatan->code;
            $participantUkomDto->next_jabatan_name = $nextJabatan->name;
            $participantUkomDto->next_jenjang_code = $nextJenjang->code;
            $participantUkomDto->next_jenjang_name = $nextJenjang->name;

            $participantUkomDto->unit_kerja_id = $unitKerja->id;
            $participantUkomDto->unit_kerja_name = $unitKerja->name;

            foreach ($participantUkomDto->dokumen_ukom_list as $key => $dokumen_ukom) {
                $dokumenUkomDto = new DocumentUkomDto();
                $dokumenUkomDto->fromArray((array) $dokumen_ukom);

                $dokumenPersyaratan = $this->documentUkomService->findByDokumenPersyaratanId($dokumenUkomDto->dokumen_persyaratan_id);
                $dokumenUkomDto->dokumen = $this->storageService->putObjectFromBase64WithFilename("system", "ukom", "ukom_" . $dokumenUkomDto->dokumen_persyaratan_id . Carbon::now()->format('YmdHis'), $dokumenUkomDto->dokumen_file);
                $dokumenUkomDto->dokumen_url = $this->storageService->getUrl("system", "ukom", $dokumenUkomDto->dokumen);;
                $dokumenUkomDto->dokumen_file = null;
                $dokumenUkomDto->dokumen_status = "APPROVE";
                $dokumenUkomDto->dokumen_persyaratan_name = $dokumenPersyaratan->name;

                $participantUkomDto->dokumen_ukom_list[$key] = $dokumenUkomDto;
            }

            $participantUkomDto->participant_status = "jf";

            $pendingTask = $this->workflowService->startCreateTask(
                $this::workflow_name,
                $participantUkomDto->id,
                $participantUkomDto->name,
                ["nip" => $participantUkomDto->nip],
                $participantUkomDto,
                $participantUkomDto->nip
            );

            $notificationDto = new NotificationDto();
            $this->sendNotifyService->notifyVerifyUkom($notificationDto);

            return $pendingTask;
        });
    }

    public function create(ParticipantUkomDto $participantUkomDto)
    {
        return DB::transaction(function () use ($participantUkomDto) {
            $systemConf = $this->systemConfigurationService->findByCode("UKM_REGISTRATION");
            if ($systemConf->value == "tidak") {
                throw new BusinessException("Ukom registration is closed", "UKM-00003");
            }

            $userCheck = $this->userService->findByIdv2($participantUkomDto->nip);
            if ($userCheck && !$userCheck->deleted_flag) {
                throw new BusinessException("Nip Exist", "");
            }

            if ($participantUkomDto->jenis_ukom == JenisUkom::PERPINDAHAN_JABATAN->value) {
                $nextJabatan = $this->jabatanService->findByCode($participantUkomDto->next_jabatan_code);
                $nextJenjang = $this->jenjangService->findByCode($participantUkomDto->next_jenjang_code);
            } else if ($participantUkomDto->jenis_ukom == JenisUkom::PROMOSI->value) {
                $nextJabatan = $this->jabatanService->findByCode($participantUkomDto->next_jabatan_code);
                $nextJenjang = $this->jenjangService->findByCode($participantUkomDto->next_jenjang_code);
            } else {
                throw new RecordNotFoundException("jenis_ukom not found", ['jenis_ukom' => $participantUkomDto->jenis_ukom]);
            }

            $participantUser = $this->userService->findByIdv2("PU-" . $participantUkomDto->nip);
            if (!$participantUser) {
                $participantUkomDto->id = "PU-" . $participantUkomDto->nip;
                $participantUkomDto->role_code_list = [];
                $participantUkomDto->application_code = 'siukom-participant';
                $participantUkomDto->channel_code_list = ['WEB', 'MOBILE'];

                $this->userAuthenticationService->register($participantUkomDto);

                $participantUkomDto->user_id = $participantUkomDto->id;
            } else {
                if ($this->participantUkomService->findByUserId("PU-" . $participantUkomDto->nip)) {
                    throw new RecordExistException("participant with nip " . $participantUkomDto->nip . " already exist");
                }

                $participantUkomDto->id = "PU-" . $participantUkomDto->nip;
                $participantUkomDto->role_code_list = [];
                $participantUkomDto->application_code = 'siukom-participant';
                $participantUkomDto->channel_code_list = ['WEB', 'MOBILE'];
                $this->userService->update($participantUkomDto);

                $passwordDto = new PasswordDto();
                $passwordDto->user_id = $participantUser->id;
                $passwordDto->password = $participantUkomDto->password;
                $this->passwordService->forceUpdate($passwordDto);

                $participantUkomDto->user_id = $participantUser->id;
            }
            $participantUkomDto->password = null;

            $participantUkomDto->id = Str::uuid();

            $pangkat = $this->pangkatService->findById($participantUkomDto->pangkat_code);

            $participantUkomDto->pangkat_name = $pangkat->name;
            $participantUkomDto->next_jabatan_code = $nextJabatan->code;
            $participantUkomDto->next_jabatan_name = $nextJabatan->name;
            $participantUkomDto->next_jenjang_code = $nextJenjang->code;
            $participantUkomDto->next_jenjang_name = $nextJenjang->name;

            foreach ($participantUkomDto->dokumen_ukom_list as $key => $dokumen_ukom) {
                $dokumenUkomDto = new DocumentUkomDto();
                $dokumenUkomDto->fromArray((array) $dokumen_ukom);

                $dokumenPersyaratan = $this->documentUkomService->findByDokumenPersyaratanId($dokumenUkomDto->dokumen_persyaratan_id);
                $dokumenUkomDto->dokumen = $this->storageService->putObjectFromBase64WithFilename("system", "ukom", "ukom_" . $dokumenUkomDto->dokumen_persyaratan_id . Carbon::now()->format('YmdHis'), $dokumenUkomDto->dokumen_file);
                $dokumenUkomDto->dokumen_url = $this->storageService->getUrl("system", "ukom", $dokumenUkomDto->dokumen);;
                $dokumenUkomDto->dokumen_file = null;
                $dokumenUkomDto->dokumen_status = "APPROVE";
                $dokumenUkomDto->dokumen_persyaratan_name = $dokumenPersyaratan->name;

                $participantUkomDto->dokumen_ukom_list[$key] = $dokumenUkomDto;
            }

            $participantUkomDto->participant_status = "non-jf";

            $pendingTask =  $this->workflowService->startCreateTask(
                $this::workflow_name,
                $participantUkomDto->id,
                $participantUkomDto->name,
                ["nip" => $participantUkomDto->nip],
                $participantUkomDto,
                $participantUkomDto->nip
            );

            $sysConfig = SystemConfiguration::find("URL_NON_JF_UKOM");
            $expiredTime = (int) optional($sysConfig)->value ?? 3650;

            $currentDate = Carbon::now();
            if ($expiredTime > 0) {
                $encriptionKey = EncriptionKey::builder(["participant_ukom_id" => $participantUkomDto->id])
                    ->validFrom($currentDate->toString())
                    ->validTo($currentDate->copy()->addDays($expiredTime)->toString())
                    ->generate();
            } else {
                $encriptionKey = EncriptionKey::builder(["participant_ukom_id" => $participantUkomDto->id])
                    ->validFrom($currentDate->toString())
                    ->generate();
            }

            $page_url = config("eyegil.client_url") . '/ukom/external/status?key=' . $encriptionKey->getKey();
            $filePath = 'buckets/ukom/' . $participantUkomDto->id . '_qr.png';
            Storage::put($filePath, QrCode::format('png')->size(300)->generate($page_url));

            $image_url = $this->storageSystemService->getUrl("ukom", $participantUkomDto->id . '_qr.png');

            $notificationDto = new NotificationDto();
            $notificationDto->objectMap = [
                "name" => $participantUkomDto->name,
                "year" => Carbon::now()->year,
                "page_url" => $page_url,
                "image_url" => $image_url
            ];
            $this->sendNotifyService->sendEmailUkomRegistration($notificationDto, $participantUkomDto->email);

            return [
                "key" => $encriptionKey->getKey(),
                "image_url" => $image_url
            ];
        });
    }

    public function nonJfSubmit(TaskDto $taskDto, $key)
    {
        if (!$key) throw new RecordNotFoundException("key notfound");
        return $this->submit($taskDto, $key);
    }

    public function submit(TaskDto $taskDto, $key = null)
    {
        return DB::transaction(function () use ($taskDto, $key) {
            $pendingTask = $this->workflowService->findTaskById($taskDto->id);
            if ($key && $key != $pendingTask->object_group) {
                if (!$key) throw new RecordNotFoundException("key notfound");
            }

            switch ($pendingTask->flow_id) {
                case UkomFlow::FLOW_1->value:
                    $participantUkomDto = new ParticipantUkomDto();
                    $participantUkomDto->fromArray((array) $pendingTask->objectTask->object);

                    if ($taskDto->task_action == "amend") {
                        $participantUkomDtoReq = (new ParticipantUkomDto())->fromArray((array) $taskDto->object)->validateFlow1Reject();

                        $documentUkomLookup = [];
                        foreach ($participantUkomDtoReq->dokumen_ukom_list as $key => $dokumen_ukom) {
                            $documentUkomReqDto = (new DocumentUkomDto())->fromArray((array) $dokumen_ukom)->validateFlow1Reject();
                            $documentUkomLookup[$documentUkomReqDto->dokumen_persyaratan_id] = [
                                'data' => $documentUkomReqDto,
                                'key' => $key
                            ];
                        }

                        foreach ($participantUkomDto->dokumen_ukom_list as $key => $dokumen_ukom_old) {
                            $documentUkomDto = new DocumentUkomDto();
                            $documentUkomDto->fromArray((array) $dokumen_ukom_old);

                            if (isset($documentUkomLookup[$documentUkomDto->dokumen_persyaratan_id])) {
                                $documentUkomDto->dokumen_status = "REJECT";
                                $documentUkomDto->remark = $documentUkomLookup[$documentUkomDto->dokumen_persyaratan_id]['data']->remark;
                            }
                            $participantUkomDto->dokumen_ukom_list[$key] = $documentUkomDto;
                        }
                    } else if ($taskDto->task_action == "approve") {
                    } else if ($taskDto->task_action == "reject") {
                    } else throw new RecordNotFoundException("could not find action : " . $taskDto->task_action);

                    $taskDto->object = $participantUkomDto;
                    break;

                case UkomFlow::FLOW_2->value:
                    $participantUkomDto = new ParticipantUkomDto();
                    $participantUkomDto->fromArray((array) $pendingTask->objectTask->object);
                    $participantUkomDtoReq = (new ParticipantUkomDto())->fromArray((array) $taskDto->object)->validateFlow1Reject();

                    $documentUkomLookup = [];
                    foreach ($participantUkomDtoReq->dokumen_ukom_list as $key => $dokumen_ukom) {
                        $documentUkomReqDto = (new DocumentUkomDto())->fromArray((array) $dokumen_ukom)->validateFlow1Reject();
                        $documentUkomLookup[$documentUkomReqDto->dokumen_persyaratan_id] = [
                            'data' => $documentUkomReqDto,
                            'key' => $key
                        ];
                    }

                    foreach ($participantUkomDto->dokumen_ukom_list as $key => $dokumen_ukom_old) {
                        $documentUkomDto = new DocumentUkomDto();
                        $documentUkomDto->fromArray((array) $dokumen_ukom_old);

                        if (isset($documentUkomLookup[$documentUkomDto->dokumen_persyaratan_id])) {
                            $documentUkomReqDto = $documentUkomLookup[$documentUkomDto->dokumen_persyaratan_id]["data"];

                            $documentUkomDto->dokumen = $this->storageService->putObjectFromBase64WithFilename("system",     "ukom",   "ukom_" . $documentUkomDto->dokumen_persyaratan_id . Carbon::now()->format('YmdHis'),   $documentUkomReqDto->dokumen_file);
                            $documentUkomDto->dokumen_url = $this->storageService->getUrl("system", "ukom", $documentUkomDto->dokumen);
                            $documentUkomDto->dokumen_status = "APPROVE";
                            $documentUkomDto->remark = null;
                        }
                        if ($documentUkomDto->dokumen_status == "REJECT") {
                            throw new BusinessException("Please makesure to upload amended documents", "");
                        }
                        $participantUkomDto->dokumen_ukom_list[$key] = $documentUkomDto;
                    }

                    $participantUkomDto->name = $participantUkomDtoReq->name ?? $participantUkomDto->name;
                    $participantUkomDto->email = $participantUkomDtoReq->email ?? $participantUkomDto->email;
                    if ($participantUkomDto->participant_status == "non-jf") {
                        $participantUkomDto->unit_kerja_name = $participantUkomDtoReq->unit_kerja_name ?? $participantUkomDto->unit_kerja_name;

                        $nextJabatan = $this->jabatanService->findByCode($participantUkomDtoReq->next_jabatan_code ?? $participantUkomDto->next_jabatan_code);
                        $nextJenjang = $this->jenjangService->findByCode($participantUkomDtoReq->next_jenjang_code ?? $participantUkomDto->next_jenjang_code);

                        $participantUkomDto->next_jabatan_code = $nextJabatan->code;
                        $participantUkomDto->next_jabatan_name = $nextJabatan->name;
                        $participantUkomDto->next_jenjang_code = $nextJenjang->code;
                        $participantUkomDto->next_jenjang_name = $nextJenjang->name;
                    } else {
                        $nextJabatan = $this->jabatanService->findByCode($participantUkomDtoReq->next_jabatan_code ?? $participantUkomDto->next_jabatan_code);
                        $nextJenjang = $this->jenjangService->findByCode($participantUkomDtoReq->next_jenjang_code ?? $participantUkomDto->next_jenjang_code);

                        $participantUkomDto->next_jabatan_code = $nextJabatan->code;
                        $participantUkomDto->next_jabatan_name = $nextJabatan->name;
                        $participantUkomDto->next_jenjang_code = $nextJenjang->code;
                        $participantUkomDto->next_jenjang_name = $nextJenjang->name;
                    }

                    $taskDto->object = $participantUkomDto;
                    break;
            }

            $task = $this->workflowService->submitTask(
                $taskDto->id,
                $taskDto->task_action,
                $taskDto->object,
                $taskDto->remark
            );

            if ($task->flow_code == UkomFlow::FLOW_1->value) {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyVerifyUkom($notificationDto);
            } else if ($task->flow_code == UkomFlow::FLOW_2->value) {
                if ($this->jFService->findByNipV2($pendingTask->object_group)) {
                    $notificationDto = new NotificationDto();
                    $this->sendNotifyService->notifyRejectUkom($notificationDto, $pendingTask->object_group);
                }
            }

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                if ($taskDto->task_action == "approve") {
                    $participantUkomDto = new ParticipantUkomDto();
                    $participantUkomDto->fromArray((array) $task->objectTask->object);

                    if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                        if ($task->task_type == "create") {
                            return $this->participantUkomService->save($participantUkomDto);
                        }
                    }
                }
            }

            return $task;
        });
    }
}
