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
use Eyegil\SijupriMaintenance\Services\BidangJabatanService;
use Eyegil\SijupriMaintenance\Services\KabupatenKotaService;
use Eyegil\SijupriMaintenance\Services\PendidikanService;
use Eyegil\SijupriMaintenance\Services\PredikatKinerjaService;
use Eyegil\SijupriMaintenance\Services\ProvinsiService;
use Eyegil\SijupriSiap\Models\JF;
use Eyegil\SijupriSiap\Services\RiwayatKinerjaService;
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
use Eyegil\SijupriUkom\Models\UkomRegistrationRules;
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
use Eyegil\SijupriMaintenance\Services\JabatanJenjangService;
use Eyegil\SijupriMaintenance\Services\SystemConfigurationService;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
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
        private JabatanJenjangService $jabatanJenjangService,
        private RiwayatKinerjaService $riwayatKinerjaService,
        private BidangJabatanService $bidangJabatanService,
        private PredikatKinerjaService $predikatKinerjaService,
        private PendidikanService $pendidikanService,
        private ProvinsiService $provinsiService,
        private KabupatenKotaService $kabupatenKotaService,
        private UkomBanService $ukomBanService,
    ) {
    }

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
                if (isset($queryParam['like_next_jenjang_name'])) {
                    $join->where('wf_object_task.object->next_jenjang_name', 'ILIKE', '%' . $queryParam['like_next_jenjang_name'] . '%');
                }
                if (isset($queryParam['like_jenjang_name'])) {
                    $join->where('wf_object_task.object->jenjang_name', 'ILIKE', '%' . $queryParam['like_jenjang_name'] . '%');
                }

                if (isset($queryParam['eq_next_jabatan_code'])) {
                    $join->where('wf_object_task.object->next_jabatan_code', $queryParam['eq_next_jabatan_code']);
                }
                if (isset($queryParam['eq_next_jenjang_code'])) {
                    $join->where('wf_object_task.object->next_jenjang_code', $queryParam['eq_next_jenjang_code']);
                }
                if (isset($queryParam['eq_jenis_ukom'])) {
                    $join->where('wf_object_task.object->jenis_ukom', $queryParam['eq_jenis_ukom']);
                }
                if (isset($queryParam['like_nip'])) {
                    $join->where('object_group', 'ILIKE', '%' . $queryParam['like_nip'] . '%');
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
                if (isset($queryParam['like_next_jenjang_name'])) {
                    $join->where('wf_object_task.object->next_jenjang_name', 'ILIKE', '%' . $queryParam['like_next_jenjang_name'] . '%');
                }
                if (isset($queryParam['like_jenjang_name'])) {
                    $join->where('wf_object_task.object->jenjang_name', 'ILIKE', '%' . $queryParam['like_jenjang_name'] . '%');
                }

                if (isset($queryParam['eq_next_jabatan_code'])) {
                    $join->where('wf_object_task.object->next_jabatan_code', $queryParam['eq_next_jabatan_code']);
                }
                if (isset($queryParam['eq_next_jenjang_code'])) {
                    $join->where('wf_object_task.object->next_jenjang_code', $queryParam['eq_next_jenjang_code']);
                }
                if (isset($queryParam['eq_jenis_ukom'])) {
                    $join->where('wf_object_task.object->jenis_ukom', $queryParam['eq_jenis_ukom']);
                }
                if (isset($queryParam['like_nip'])) {
                    $join->where('object_group', 'ILIKE', '%' . $queryParam['like_nip'] . '%');
                }
                if (isset($queryParam['like_name'])) {
                    $join->where('object_group', 'ILIKE', '%' . $queryParam['like_name'] . '%');
                }
            });
        }, true)->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PendingTask::class);
    }

    public function findByParticipantUkomId($participant_ukom_id): ParticipantUkomPendingTaskDto
    {
        $pendingTask = PendingTask::where("object_id", $participant_ukom_id)->first();
        try {
            return $this->findByNip($pendingTask->object_group, $participant_ukom_id);
        } catch (\Throwable $th) {
            return $this->findByNipFailed($pendingTask->object_group, $participant_ukom_id);
        }
    }

    public function findByNip($nip, $participant_ukom_id = null): ParticipantUkomPendingTaskDto
    {
        if (!$participant_ukom_id) {
            $pendingTaskCurrent = PendingTask::where("object_group", $nip)
                ->latest('last_updated')
                ->firstOrThrowNotFound();
            $participant_ukom_id = $pendingTaskCurrent->object_id;
        }

        $pendingTask = $this->workflowService->findByWorkflowNameAndObjectGroupAndObjectId($this::workflow_name, $nip, $participant_ukom_id);
        $participantUkomDto = (new ParticipantUkomDto())->fromArray((array) $pendingTask->objectTask->object);
        $participantUkomPendingTaskDto = (new ParticipantUkomPendingTaskDto())->fromArray($participantUkomDto->toArray());
        $participantUkomPendingTaskDto->fromArray(PendingTaskConverter::withPendingTaskHistory($pendingTask)->toArray());
        $participantUkomPendingTaskDto->participant_ukom_id = $participantUkomDto->id;

        return $participantUkomPendingTaskDto;
    }

    public function findByNipFailed($nip, $participant_ukom_id)
    {
        $pendingTask = $this->workflowService->findByWorkflowNameAndObjectGroupObjectIdFailed($this::workflow_name, $nip, $participant_ukom_id);
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

        if ($participantUkomDto->participant_status = "jf") {
            $riwayatPendidikan = JF::find($participantUkomDto->nip)->riwayatPendidikan;
            $participantUkomPendingTaskDto->pendidikan_terakhir_code = $riwayatPendidikan->pendidikan_code;
            $participantUkomPendingTaskDto->pendidikan_terakhir_name = $riwayatPendidikan->pendidikan_name;
        }
        return $participantUkomPendingTaskDto;
    }

    public function checkEligible($nip, $jenis_ukom)
    {
        $jf = $this->jFService->findByNip($nip);

        $pendingTask = $jf->pendingTaskUkom;
        if ($pendingTask) {
            return [
                "eligible" => false,
                "message" => "Registration already exist",
                "code" => "UEL-00009",
            ];
        }

        if (
            PendingTask::where('object_group', $nip)
                ->whereIn('workflow_name', [
                    'jf_task',
                    'rw_jabatan_task',
                    'rw_pangkat_task',
                    'rw_jabatgan_task',
                    'rw_kompetensi_task',
                    'rw_pendidikan_task',
                ])
                ->where('task_status', TaskStatus::PENDING)
                ->exists()
        ) {
            return [
                "eligible" => false,
                "message" => "pending task exist",
                "code" => "UEL-00011",
            ];
        }

        $user = $jf->user;
        if (!$user->email || !$user->phone) {
            return [
                "eligible" => false,
                "message" => "Profile not filled (email and phone)",
                "code" => "UEL-00000",
            ];
        }

        $riwayatJabatan = $jf->riwayatJabatan;
        if (!$riwayatJabatan) {
            return [
                "eligible" => false,
                "message" => "Riwayat Jabatan Not Eligible",
                "code" => "UEL-00001",
            ];
        }

        $riwayatPangkat = $jf->riwayatPangkat;
        if (!$riwayatPangkat) {
            return [
                "eligible" => false,
                "message" => "Riwayat Pangkat Not Found",
                "code" => "UEL-00002",
            ];
        }
        $riwayatPendidikan = $jf->riwayatPendidikan;
        if (!$riwayatPendidikan) {
            return [
                "eligible" => false,
                "message" => "Riwayat Pendidikan Not Found",
                "code" => "UEL-00003",
            ];
        }

        $jenjang = $riwayatJabatan->jenjang;
        $ukomRegistrationRules = UkomRegistrationRules::where("jenjang_code", $jenjang->code)
            ->where("jenis_ukom", $jenis_ukom)
            ->first();
        if ($ukomRegistrationRules) {
            $riwayatKinerja = $jf->riwayatKinerja;
            if (!$riwayatKinerja) {
                return [
                    "eligible" => false,
                    "message" => "Riwayat Kinerja Not Found",
                    "code" => "UEL-00004",
                ];
            }

            if ($ukomRegistrationRules->angka_kredit_threshold > $riwayatKinerja->angka_kredit) {
                return [
                    "eligible" => false,
                    "message" => "Angka Kredit below threshold",
                    "code" => "UEL-00005",
                ];
            }

            $riwayatKinerjaLastNYearList = $this->riwayatKinerjaService->findByNipAndLastNYearList($nip, $ukomRegistrationRules->last_n_year);

            if (count($riwayatKinerjaLastNYearList) == $ukomRegistrationRules->last_n_year) {
                foreach ($riwayatKinerjaLastNYearList as $key => $riwayatKinerjaLastNYear) {
                    if ($ukomRegistrationRules->ratingHasil->value > $riwayatKinerjaLastNYear->ratingHasil->value) {
                        return [
                            "eligible" => false,
                            "message" => "Rating Hasil last $key year not eligible",
                            "code" => "UEL-00006",
                        ];
                    }

                    if ($ukomRegistrationRules->ratingKinerja->value > $riwayatKinerjaLastNYear->ratingKinerja->value) {
                        return [
                            "eligible" => false,
                            "message" => "Rating Kinerja last $key year not eligible",
                            "code" => "UEL-00007",
                        ];
                    }

                    if ($ukomRegistrationRules->predikatKinerja->value > $riwayatKinerjaLastNYear->predikatKinerja->value) {
                        return [
                            "eligible" => false,
                            "message" => "Predikat Kinerja last $key year not eligible",
                            "code" => "UEL-00008",
                        ];
                    }
                }
            } else {
                return [
                    "eligible" => false,
                    "message" => "only found " . count($riwayatKinerjaLastNYearList) . " record/s but expected " . $ukomRegistrationRules->last_n_year . " record/s",
                    "code" => "UEL-00010",
                ];
            }
        }

        return [
            "eligible" => true,
            "message" => "eligible",
        ];
    }

    public function createWithJf(ParticipantUkomDto $participantUkomDto)
    {
        DB::transaction(function () use ($participantUkomDto) {
            $userContext = user_context();
            $participantUkomDto->nip = $userContext->id;

            $systemConf = $this->systemConfigurationService->findByCode("UKM_REGISTRATION");
            if ($systemConf->value == "tidak") {
                throw new BusinessException("Ukom registration is closed", "UKM-00003");
            }

            if ($this->ukomBanService->findById($participantUkomDto->nip)) {
                throw new BusinessException("Banned from registering Ukom", "UKM-00004");
            }

            $jf = $this->jFService->findByNip($participantUkomDto->nip);
            $user = $jf->user;

            $eligible = $this->checkEligible($participantUkomDto->nip, $participantUkomDto->jenis_ukom);
            if (!$eligible['eligible']) {
                throw new BusinessException($eligible["message"], $eligible["code"]);
            }

            $unitKerja = $jf->unitKerja;

            $riwayatJabatan = $jf->riwayatJabatan;
            $riwayatPangkat = $jf->riwayatPangkat;

            $jabatan = $riwayatJabatan->jabatan;
            $jenjang = $riwayatJabatan->jenjang;
            $pangkat = $riwayatPangkat->pangkat;

            if (in_array($participantUkomDto->jenis_ukom, [JenisUkom::KENAIKAN_JENJANG->value, JenisUkom::PROMOSI_JF->value])) {
                $nextJabatan = $jabatan;
                $nextJenjang = $this->jenjangService->findNextBycode($jenjang->code);
                $nextPangkat = $pangkat;

                try {
                    //error thrown if jabatan - jenjang combination not correct
                    $this->jabatanJenjangService->findByJabatanCodeJenjangCode($nextJabatan->code, $nextJenjang->code);
                } catch (\Throwable $th) {
                    throw new BusinessException("Jabatan yang di tuju tidak dapat naik jenjang lagi", "PUKT-00001");
                }
            } else if ($participantUkomDto->jenis_ukom == JenisUkom::PERPINDAHAN_JABATAN->value) {
                $nextJabatan = $this->jabatanService->findByCode($participantUkomDto->next_jabatan_code);
                $nextJenjang = $this->jenjangService->findByCode($participantUkomDto->next_jenjang_code);
                $nextPangkat = $pangkat;

                try {
                    //error thrown if jabatan - jenjang combination not correct
                    $this->jabatanJenjangService->findByJabatanCodeJenjangCode($nextJabatan->code, $nextJenjang->code);
                } catch (\Throwable $th) {
                    throw new BusinessException("Jabatan yang di tuju tidak tidak memiliki jenjang yang dipilih", "PUKT-00001");
                }
            } else {
                throw new RecordNotFoundException("jenis_ukom not found", ['jenis_ukom' => $participantUkomDto->jenis_ukom]);
            }

            $participantUkomDto->name = $user->name;
            $participantUkomDto->email = $user->email;
            $participantUkomDto->phone = $user->phone;
            $participantUkomDto->tempat_lahir = $user->tempat_lahir;

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

            $participantUkomDto->pendidikan_terakhir_code = $jf->riwayatPendidikan->pendidikan->code;
            $participantUkomDto->pendidikan_terakhir_name = $jf->riwayatPendidikan->pendidikan->name;
            $riwayatKinerjaLastNYearList = $this->riwayatKinerjaService->findByNipAndLastNYearList($jf->nip, 2);
            foreach ($riwayatKinerjaLastNYearList as $key => $riwayatKinerjaLastNYear) {
                if ($key == 0) {
                    $participantUkomDto->predikat_kinerja1_id = $riwayatKinerjaLastNYear->predikatKinerja->id;
                    $participantUkomDto->predikat_kinerja1_name = $riwayatKinerjaLastNYear->predikatKinerja->name;
                } else if ($key == 1) {
                    $participantUkomDto->predikat_kinerja2_id = $riwayatKinerjaLastNYear->predikatKinerja->id;
                    $participantUkomDto->predikat_kinerja2_name = $riwayatKinerjaLastNYear->predikatKinerja->name;
                    break;
                }
            }

            $participantUkomDto->pangkat_code = $pangkat->code;
            $participantUkomDto->pangkat_name = $pangkat->name;
            $participantUkomDto->tmt_pangkat = $riwayatPangkat->tmt;
            $participantUkomDto->jabatan_name = $jabatan->name;
            $participantUkomDto->tmt_jabatan = $riwayatJabatan->tmt;
            $participantUkomDto->jenjang_name = $jenjang->name;
            $participantUkomDto->next_jabatan_code = $nextJabatan->code;
            $participantUkomDto->next_jabatan_name = $nextJabatan->name;
            $participantUkomDto->next_jenjang_code = $nextJenjang->code;
            $participantUkomDto->next_jenjang_name = $nextJenjang->name;

            $participantUkomDto->provinsi_id = $unitKerja->instansi->provinsi_id;
            if ($participantUkomDto->provinsi_id) {
                $participantUkomDto->provinsi_name = $unitKerja->instansi->provinsi->name;
            }
            if ($unitKerja->instansi->kabupaten_id) {
                $participantUkomDto->kabupaten_kota_id = $unitKerja->instansi->kabupaten_id;
                $participantUkomDto->kabupaten_kota_name = $unitKerja->instansi->kabupaten->name;
            } else if ($unitKerja->instansi->kota_id) {
                $participantUkomDto->kabupaten_kota_id = $unitKerja->instansi->kota_id;
                $participantUkomDto->kabupaten_kota_name = $unitKerja->instansi->kota->name;
            }

            $participantUkomDto->unit_kerja_id = $unitKerja->id;
            $participantUkomDto->unit_kerja_name = $unitKerja->name;

            foreach ($participantUkomDto->dokumen_ukom_list as $key => $dokumen_ukom) {
                $dokumenUkomDto = new DocumentUkomDto();
                $dokumenUkomDto->fromArray((array) $dokumen_ukom);

                $dokumenPersyaratan = $this->documentUkomService->findByDokumenPersyaratanId($dokumenUkomDto->dokumen_persyaratan_id);
                $dokumenUkomDto->dokumen = $this->storageService->putObjectFromBase64WithFilename("system", "ukom", "ukom_" . $dokumenUkomDto->dokumen_persyaratan_id . Carbon::now()->format('YmdHis'), $dokumenUkomDto->dokumen_file);
                $dokumenUkomDto->dokumen_url = $this->storageService->getUrl("system", "ukom", $dokumenUkomDto->dokumen);
                ;
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

            if ($this->ukomBanService->findById($participantUkomDto->nip)) {
                throw new BusinessException("Banned from registering Ukom", "UKM-00004");
            }

            $userCheck = $this->userService->findByIdv2($participantUkomDto->nip);
            if ($userCheck && !$userCheck->delete_flag) {
                throw new BusinessException("Nip Exist", "");
            }

            if ($participantUkomDto->jenis_ukom == JenisUkom::PERPINDAHAN_JABATAN->value) {
                $nextJabatan = $this->jabatanService->findByCode($participantUkomDto->next_jabatan_code);
                $nextJenjang = $this->jenjangService->findByCode($participantUkomDto->next_jenjang_code);
            } else if ($participantUkomDto->jenis_ukom == JenisUkom::PROMOSI->value) {
                $nextJabatan = $this->jabatanService->findByCode($participantUkomDto->next_jabatan_code);
                $nextJenjang = $this->jenjangService->findByCode($participantUkomDto->next_jenjang_code);
            } else if ($participantUkomDto->jenis_ukom == JenisUkom::KENAIKAN_JENJANG->value) {
                $nextJabatan = $this->jabatanService->findByCode($participantUkomDto->next_jabatan_code);
                $nextJenjang = $this->jenjangService->findByCode($participantUkomDto->next_jenjang_code);
            } else {
                throw new RecordNotFoundException("jenis_ukom not found", ['jenis_ukom' => $participantUkomDto->jenis_ukom]);
            }

            //error thrown if jabatan - jenjang combination not correct
            $this->jabatanJenjangService->findByJabatanCodeJenjangCode($nextJabatan->code, $nextJenjang->code);

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

            $participantUkomDto->predikat_kinerja_1_id = $participantUkomDto->predikat_kinerja_1_id ?? $participantUkomDto->predikat_kinerja1_id;
            $participantUkomDto->predikat_kinerja_2_id = $participantUkomDto->predikat_kinerja_2_id ?? $participantUkomDto->predikat_kinerja2_id;
            $predikatKinerja1 = $this->predikatKinerjaService->findById($participantUkomDto->predikat_kinerja_1_id);
            $predikatKinerja2 = $this->predikatKinerjaService->findById($participantUkomDto->predikat_kinerja_2_id);
            $participantUkomDto->predikat_kinerja_1_name = $predikatKinerja1->name;
            $participantUkomDto->predikat_kinerja2_name = $predikatKinerja2->name;

            foreach ($participantUkomDto->dokumen_ukom_list as $key => $dokumen_ukom) {
                $dokumenUkomDto = new DocumentUkomDto();
                $dokumenUkomDto->fromArray((array) $dokumen_ukom);

                $dokumenPersyaratan = $this->documentUkomService->findByDokumenPersyaratanId($dokumenUkomDto->dokumen_persyaratan_id);
                $dokumenUkomDto->dokumen = $this->storageService->putObjectFromBase64WithFilename("system", "ukom", "ukom_" . $dokumenUkomDto->dokumen_persyaratan_id . Carbon::now()->format('YmdHis'), $dokumenUkomDto->dokumen_file);
                $dokumenUkomDto->dokumen_url = $this->storageService->getUrl("system", "ukom", $dokumenUkomDto->dokumen);
                ;
                $dokumenUkomDto->dokumen_file = null;
                $dokumenUkomDto->dokumen_status = "APPROVE";
                $dokumenUkomDto->dokumen_persyaratan_name = $dokumenPersyaratan->name;

                $participantUkomDto->dokumen_ukom_list[$key] = $dokumenUkomDto;
            }

            $participantUkomDto->participant_status = "non-jf";

            $pendingTask = $this->workflowService->startCreateTask(
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
        if (!$key)
            throw new RecordNotFoundException("key notfound");
        return $this->submit($taskDto, $key);
    }

    public function submitAll()
    {
        PendingTask::where("workflow_name", $this::workflow_name)
            ->where("task_status", TaskStatus::PENDING)
            ->get()
            ->each(function ($pendingTask) {
                try {
                    $taskDto = new TaskDto();
                    $taskDto->id = $pendingTask->id;
                    $taskDto->task_action = $pendingTask->flow_id == UkomFlow::FLOW_3->value ? "reject" : "approve";
                    $taskDto->remark = $pendingTask->remark ?? null;

                    $this->submit($taskDto);
                } catch (\Throwable $th) {
                    Log::error("Failed to submit pending task id " . $pendingTask->id . " error " . $th->getMessage());
                }
            });
    }

    public function submit(TaskDto $taskDto, $key = null)
    {
        $userContext = user_context();
        if (($userContext === null || in_array($userContext->application_code, ["sijupri-internal", "sijupri-external"])) && $taskDto->task_action != 'ukom_flow_1') {
            throw new BusinessException("Not Accessible Task action", "");
        }


        return DB::transaction(function () use ($taskDto, $key) {
            $pendingTask = $this->workflowService->findTaskById($taskDto->id);
            if (!$pendingTask->task_status == TaskStatus::PENDING) {
                throw new RecordNotFoundException("Pending Task not found with id " . $taskDto->id);
            }

            if ($key && $key != $pendingTask->object_group) {
                if (!$key)
                    throw new RecordNotFoundException("key notfound");
            }

            $participantUkomDto = new ParticipantUkomDto();
            $participantUkomDto->fromArray((array) $pendingTask->objectTask->object);

            $jf = $this->jFService->findByNipV2($pendingTask->object_group);

            if ($pendingTask->flow_id == UkomFlow::FLOW_1->value && $taskDto->task_action == "ukom_flow_2") {

                $participantUkomDtoReq = (new ParticipantUkomDto())->fromArray((array) $taskDto->object);
                $participantUkomDtoReq->dokumen_ukom_list = $participantUkomDtoReq->dokumen_ukom_list ?? [];

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
                    } else {
                        $documentUkomDto->dokumen_status = "APPROVE";
                    }
                    $participantUkomDto->dokumen_ukom_list[$key] = $documentUkomDto;
                }

                $taskDto->object = $participantUkomDto;

                $task = $this->workflowService->submitTask(
                    $taskDto->id,
                    $taskDto->task_action,
                    $taskDto->object,
                    $taskDto->remark
                );

                if ($jf && $jf->delete_flag == false) {
                    $notificationDto = new NotificationDto();
                    $this->sendNotifyService->notifyAmendUkom($notificationDto, $jf->nip);
                }

            } else if ($pendingTask->flow_id == UkomFlow::FLOW_2->value && $taskDto->task_action == "ukom_flow_1") {
                $participantUkomDtoReq = (new ParticipantUkomDto())->fromArray((array) $taskDto->object);
                $participantUkomDtoReq->dokumen_ukom_list = $participantUkomDtoReq->dokumen_ukom_list ?? [];

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

                        $documentUkomDto->dokumen = $this->storageService->putObjectFromBase64WithFilename("system", "ukom", "ukom_" . $documentUkomDto->dokumen_persyaratan_id . Carbon::now()->format('YmdHis'), $documentUkomReqDto->dokumen_file);
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
                    $participantUkomDto->tempat_lahir = $participantUkomDtoReq->tempat_lahir ?? $participantUkomDto->tempat_lahir;
                    $participantUkomDto->tanggal_lahir = $participantUkomDtoReq->tanggal_lahir ?? $participantUkomDto->tanggal_lahir;
                    $participantUkomDto->phone = $participantUkomDtoReq->phone ?? $participantUkomDto->phone;
                    $participantUkomDto->jenis_instansi = $participantUkomDtoReq->jenis_instansi ?? $participantUkomDto->jenis_instansi;
                    $participantUkomDto->jabatan_name = $participantUkomDtoReq->jabatan_name ?? $participantUkomDto->jabatan_name;
                    $participantUkomDto->jenjang_name = $participantUkomDtoReq->jenjang_name ?? $participantUkomDto->jenjang_name;
                    $participantUkomDto->tmt_jabatan = $participantUkomDtoReq->tmt_jabatan ?? $participantUkomDto->tmt_jabatan;
                    $participantUkomDto->pangkat_name = $participantUkomDtoReq->pangkat_name ?? $participantUkomDto->pangkat_name;
                    $participantUkomDto->tmt_pangkat = $participantUkomDtoReq->tmt_pangkat ?? $participantUkomDto->tmt_pangkat;
                    $participantUkomDto->no_surat_usulan = $participantUkomDtoReq->no_surat_usulan ?? $participantUkomDto->no_surat_usulan;
                    $participantUkomDto->tgl_surat_usulan = $participantUkomDtoReq->tgl_surat_usulan ?? $participantUkomDto->tgl_surat_usulan;
                    $participantUkomDto->predikat_kinerja_1_id = $participantUkomDtoReq->predikat_kinerja_1_id ?? $participantUkomDtoReq->predikat_kinerja1_id ?? $participantUkomDto->predikat_kinerja_1_id;
                    $participantUkomDto->predikat_kinerja_2_id = $participantUkomDtoReq->predikat_kinerja_2_id ?? $participantUkomDtoReq->predikat_kinerja2_id ?? $participantUkomDto->predikat_kinerja_2_id;
                    $participantUkomDto->bidang_jabatan_code = $participantUkomDtoReq->bidang_jabatan_code ?? $participantUkomDto->bidang_jabatan_code;
                    $participantUkomDto->next_jabatan_code = $participantUkomDtoReq->next_jabatan_code ?? $participantUkomDto->next_jabatan_code;
                    $participantUkomDto->next_jenjang_code = $participantUkomDtoReq->next_jenjang_code ?? $participantUkomDto->next_jenjang_code;
                    $participantUkomDto->pendidikan_terakhir_code = $participantUkomDtoReq->pendidikan_terakhir_code ?? $participantUkomDto->pendidikan_terakhir_code;
                    $participantUkomDto->provinsi_id = $participantUkomDtoReq->provinsi_id ?? $participantUkomDto->provinsi_id;
                    $participantUkomDto->kabupaten_kota_id = $participantUkomDtoReq->kabupaten_kota_id ?? $participantUkomDto->kabupaten_kota_id;

                    $nextJabatan = $this->jabatanService->findByCode($participantUkomDto->next_jabatan_code);
                    $nextJenjang = $this->jenjangService->findByCode($participantUkomDto->next_jenjang_code);
                    $participantUkomDto->next_jabatan_code = $nextJabatan->code;
                    $participantUkomDto->next_jabatan_name = $nextJabatan->name;
                    $participantUkomDto->next_jenjang_code = $nextJenjang->code;
                    $participantUkomDto->next_jenjang_name = $nextJenjang->name;

                    $predikatKinerja1 = $this->predikatKinerjaService->findById($participantUkomDto->predikat_kinerja_1_id);
                    $predikatKinerja2 = $this->predikatKinerjaService->findById($participantUkomDto->predikat_kinerja_2_id);
                    $participantUkomDto->predikat_kinerja_1_name = $predikatKinerja1->name;
                    $participantUkomDto->predikat_kinerja2_name = $predikatKinerja2->name;

                    if ($participantUkomDto->pendidikan_terakhir_code) {
                        $pendidikan = $this->pendidikanService->findById($participantUkomDto->pendidikan_terakhir_code);
                        $participantUkomDto->pendidikan_terakhir_name = $pendidikan->name;
                    }
                    if ($participantUkomDto->bidang_jabatan_code) {
                        $bidangJabatan = $this->bidangJabatanService->findById($participantUkomDto->bidang_jabatan_code);
                        $participantUkomDto->bidang_jabatan_name = $bidangJabatan->name;
                    }
                    if ($participantUkomDto->provinsi_id) {
                        $provinsi = $this->provinsiService->findById($participantUkomDto->provinsi_id);
                        $participantUkomDto->provinsi_name = $provinsi->name;
                    }
                    if ($participantUkomDto->kabupaten_kota_id) {
                        $kabupatenKota = $this->kabupatenKotaService->findById($participantUkomDto->kabupaten_kota_id);
                        $participantUkomDto->kabupaten_kota_name = $kabupatenKota->name;
                    }
                } else {
                    $nextJabatan = $this->jabatanService->findByCode($participantUkomDtoReq->next_jabatan_code ?? $participantUkomDto->next_jabatan_code);
                    $nextJenjang = $this->jenjangService->findByCode($participantUkomDtoReq->next_jenjang_code ?? $participantUkomDto->next_jenjang_code);

                    $participantUkomDto->next_jabatan_code = $nextJabatan->code;
                    $participantUkomDto->next_jabatan_name = $nextJabatan->name;
                    $participantUkomDto->next_jenjang_code = $nextJenjang->code;
                    $participantUkomDto->next_jenjang_name = $nextJenjang->name;
                }

                $taskDto->object = $participantUkomDto;

                $task = $this->workflowService->submitTask(
                    $taskDto->id,
                    $taskDto->task_action,
                    $taskDto->object,
                    $taskDto->remark
                );

                if ($jf && $jf->delete_flag == false) {
                    if (
                        PendingTask::where('object_group', $jf->nip)
                            ->whereIn('workflow_name', [
                                'jf_task',
                                'rw_jabatan_task',
                                'rw_pangkat_task',
                                'rw_jabatgan_task',
                                'rw_kompetensi_task',
                                'rw_pendidikan_task',
                            ])
                            ->where('task_status', TaskStatus::PENDING)
                            ->exists()
                    ) {
                        throw new BusinessException("Pending profile exist", "UEL-00011");
                    }

                    $notificationDto = new NotificationDto();
                    $this->sendNotifyService->notifyVerifyUkom($notificationDto);
                }

            } else if ($taskDto->task_action == "ukom_flow_1" || $taskDto->task_action == "ukom_flow_3" || $taskDto->task_action == "ukom_flow_4") {
                $taskDto->object = $participantUkomDto;

                $task = $this->workflowService->submitTask(
                    $taskDto->id,
                    $taskDto->task_action,
                    $taskDto->object,
                    $taskDto->remark
                );
            } else if ($taskDto->task_action == "reject") {
                if ($jf && $jf->delete_flag == false) {
                    $participantUkomDto->pendidikan_terakhir_code = $jf->riwayatPendidikan->pendidikan->code;
                    $participantUkomDto->pendidikan_terakhir_name = $jf->riwayatPendidikan->pendidikan->name;
                }

                $taskDto->object = $participantUkomDto;

                $task = $this->workflowService->submitTask(
                    $taskDto->id,
                    $taskDto->task_action,
                    $taskDto->object,
                    $taskDto->remark
                );

                if ($jf && $jf->delete_flag == false) {
                    $notificationDto = new NotificationDto();
                    $this->sendNotifyService->notifyRejectUkom($notificationDto, $pendingTask->object_group);
                }

            } else if ($taskDto->task_action == "approve") {
                if ($jf && $jf->delete_flag == false) {
                    $participantUkomDto->pendidikan_terakhir_code = $jf->riwayatPendidikan->pendidikan->code;
                    $participantUkomDto->pendidikan_terakhir_name = $jf->riwayatPendidikan->pendidikan->name;
                }
                $taskDto->object = $participantUkomDto;

                $task = $this->workflowService->submitTask(
                    $taskDto->id,
                    $taskDto->task_action,
                    $taskDto->object,
                    $taskDto->remark
                );

                if ($jf) {
                    $notificationDto = new NotificationDto();
                    $this->sendNotifyService->notifyFinishUkom($notificationDto, $pendingTask->object_group);
                }
            } else {
                throw new RecordNotFoundException("could not find action : " . $taskDto->task_action);
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

    public function failedToCompleted($id)
    {
        return DB::transaction(function () use ($id) {
            $pendingTask = PendingTask::lockForUpdate()->findOrThrowNotFound($id);
            $pendingTask->task_action = 'approve';
            $pendingTask->task_status = TaskStatus::COMPLETED->name;
            $pendingTask->save();

            $pendingTaskList = PendingTask::where("object_group", $pendingTask->object_group)
                ->where("workflow_name", "participant_ukom_task")
                ->whereNotIn("task_status", ["FAILED", "COMPLETED"])
                ->whereNot("instance_id", $pendingTask->instance_id)->get();

            if ($pendingTaskList->isNotEmpty()) {
                throw new RecordExistException("participant already exist");
            }

            $participantList = ParticipantUkom::where("nip", $pendingTask->object_group)
                ->where("delete_flag", false)
                ->where("inactive_flag", false)
                ->get();

            if ($participantList->isNotEmpty()) {
                throw new RecordExistException("participant already exist");
            }

            $participantUkomDto = new ParticipantUkomDto();
            $participantUkomDto->fromArray((array) $pendingTask->objectTask->object);
            return $this->participantUkomService->save($participantUkomDto);
        });
    }
}
