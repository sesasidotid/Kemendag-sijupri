<?php

namespace Eyegil\SijupriAkp\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\Base\Exceptions\ValidationException;
use Eyegil\Base\Pageable;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriAkp\Dtos\AkpDto;
use Eyegil\SijupriAkp\Dtos\AkpPendingTaskDto;
use Eyegil\SijupriAkp\Dtos\MatrixDto;
use Eyegil\SijupriAkp\Enums\AkpFlow;
use Eyegil\SijupriMaintenance\Services\JabatanJenjangService;
use Eyegil\SijupriSiap\Converters\JFConverter;
use Eyegil\SijupriSiap\Services\JFService;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\PendingTask;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AkpTaskService
{
    private const workflow_name = "akp_task";

    public function __construct(
        private AkpService $akpService,
        private WorkflowService $workflowService,
        private JFService $jFService,
        private JabatanJenjangService $jabatanJenjangService,
        private InstrumentService $instrumentService,
        private StorageService $storageService,
        private SendNotifyService $sendNotifyService
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual("workflow_name", $this::workflow_name);
        $pageable->addEqual("task_status", TaskStatus::PENDING);
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PendingTask::class);
    }

    public function findFailedSearch(Pageable $pageable)
    {
        $userContext = user_context();
        if (in_array($userContext->application_code, ["sijupri-internal", "sijupri-external"])) {
            $pageable->addEqual("object_group", $userContext->id);
        }
        $pageable->addEqual("workflow_name", $this::workflow_name);
        $pageable->addEqual("task_status", TaskStatus::FAILED);
        return $pageable->setOrderQueries(function (Pageable $instance, Builder $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PendingTask::class);
    }

    public function getDetailTask($id)
    {
        $akpPendingTaskDto = new AkpPendingTaskDto();
        $pendingTask = $this->workflowService->findTaskByWorkflowNameAndId($this::workflow_name, $id);

        try {
            $object = $pendingTask->objectTask->object;
            $akpDto = (new AkpDto())->fromArray((array) $object);
            $akpPendingTaskDto->fromArray($akpDto->toArray());
            $akpPendingTaskDto->akp_id = $akpDto->id;
            $akpPendingTaskDto->matrix1_dto_list = [];
            $akpPendingTaskDto->matrix2_dto_list = [];
            $akpPendingTaskDto->matrix3_dto_list = [];
            foreach ($akpDto->matrix_dto_list as $key => $matrix_dto) {
                if ($matrix_dto->matrix1_dto) {
                    $akpPendingTaskDto->matrix1_dto_list[] = $matrix_dto->matrix1_dto;
                }
                if ($matrix_dto->matrix2_dto) {
                    $akpPendingTaskDto->matrix2_dto_list[] = $matrix_dto->matrix2_dto;
                }
                if ($matrix_dto->matrix3_dto) {
                    $akpPendingTaskDto->matrix3_dto_list[] = $matrix_dto->matrix3_dto;
                }
                if ($matrix_dto->akp_rekap_dto) {
                    $akpPendingTaskDto->akp_rekap_dto_list[] = $matrix_dto->akp_rekap_dto;
                }
            }
        } catch (\Throwable $ignored) {
        }
        $akpPendingTaskDto->fromArray($pendingTask->toArray());
        $akpPendingTaskDto->pending_task_history = $pendingTask->pendingTaskHistory;

        return $akpPendingTaskDto;
    }

    public function findByNip($nip)
    {

        $akpPendingTaskDto = new AkpPendingTaskDto();
        $pendingTask = $this->workflowService->findTaskByWorkflowNameAndObjectGroup($this::workflow_name, $nip);

        try {
            $object = $pendingTask->objectTask->object;
            $akpDto = (new AkpDto())->fromArray((array) $object);
            $akpPendingTaskDto->fromArray($akpDto->toArray());
            $akpPendingTaskDto->akp_id = $akpDto->id;
            $akpPendingTaskDto->matrix1_dto_list = [];
            $akpPendingTaskDto->matrix2_dto_list = [];
            $akpPendingTaskDto->matrix3_dto_list = [];
            foreach ($akpDto->matrix_dto_list as $key => $matrix_dto) {
                if ($matrix_dto->matrix1_dto) {
                    $akpPendingTaskDto->matrix1_dto_list[] = $matrix_dto->matrix1_dto;
                }
                if ($matrix_dto->matrix2_dto) {
                    $akpPendingTaskDto->matrix2_dto_list[] = $matrix_dto->matrix2_dto;
                }
                if ($matrix_dto->matrix3_dto) {
                    $akpPendingTaskDto->matrix3_dto_list[] = $matrix_dto->matrix3_dto;
                }
                if ($matrix_dto->akp_rekap_dto) {
                    $akpPendingTaskDto->akp_rekap_dto_list[] = $matrix_dto->akp_rekap_dto;
                }
            }
        } catch (\Throwable $ignored) {
        }
        $akpPendingTaskDto->fromArray($pendingTask->toArray());
        $akpPendingTaskDto->pending_task_history = $pendingTask->pendingTaskHistory;

        return $akpPendingTaskDto;
    }

    public function create($nip)
    {
        $userContext = user_context();
        if ($userContext->id != $nip) throw new ValidationException("None", ["nip" => "not valid nip"]);

        $jf = $this->jFService->findByNip($nip);
        $riwayatJabatan = $jf->riwayatJabatan;
        $jabatan = $riwayatJabatan->jabatan;
        $jenjang = $riwayatJabatan->jenjang;

        $jabatanJenjang = null;
        $instrument = null;
        try {
            $jabatanJenjang = $this->jabatanJenjangService->findByJabatanCodeJenjangCode($jabatan->code, $jenjang->code);
            $instrument = $this->instrumentService->findByJabatanJenjangId($jabatanJenjang->id);
        } catch (BusinessException $th) {
            if ($th->getCode() == "RDC-00001") {
                Log::info("Not found");
            } else {
                Log::info($th->getMessage());
            }
            throw new BusinessException("JF has no Instument", "AKP-00002");
        }

        $akpDto = new AkpDto();
        $akpDto->fromArray(JFConverter::toDto($jf)->toArray());
        $akpDto->id = Str::uuid();
        $akpDto->nip = $nip;
        $akpDto->instrument_id = $instrument->id;
        $akpDto->instrument_name = $instrument->name;
        $akpDto->matrix_dto_list = [];

        $idx = 1;
        foreach ($instrument->kategoriInstrumentList as $kategoriInstrument) {
            foreach ($kategoriInstrument->pertanyaanList as $pertanyaan) {
                $matrixDto = new MatrixDto();
                $matrixDto->pertanyaan_id = $pertanyaan->id;
                $matrixDto->pertanyaan_name = $pertanyaan->name;
                $matrixDto->kategori_instrument_id = $kategoriInstrument->id;
                $matrixDto->idx = $idx;
                $matrixDto->akp_id = $akpDto->id;
                $akpDto->matrix_dto_list[] = $matrixDto;

                $idx = $idx + 1;
            }
        }

        $pendingTask = $this->workflowService->startCreateTask(
            $this::workflow_name,
            $akpDto->id,
            $instrument->name,
            ["nip" => $nip],
            $akpDto,
            $nip,
        );

        $notificationDto = new NotificationDto();
        $this->sendNotifyService->notifyVerifyAkp($notificationDto);

        return $pendingTask;
    }

    public function submit(TaskDto $taskDto)
    {
        return DB::transaction(function () use ($taskDto) {
            $pendingTask = $this->workflowService->findTaskByWorkflowNameAndId($this::workflow_name, $taskDto->id);

            switch ($pendingTask->flow_id) {
                case AkpFlow::FLOW_1->value:
                    if ($taskDto->task_action == "approve") {
                        $akpDto = new AkpDto();
                        $akpDto->fromArray((array) $pendingTask->objectTask->object);

                        $akpDtoRequest = (new AkpDto())->fromArray((array) $taskDto->object)->validateFlow1();
                        $akpDto->nama_atasan = $akpDtoRequest->nama_atasan;
                        $akpDto->email_atasan = $akpDtoRequest->email_atasan;

                        $taskDto->object = $akpDto;
                    } else if ($taskDto->task_action == "reject") {
                        $taskDto->object = null;
                    }
                    break;
                case AkpFlow::FLOW_2->value:
                    throw new RecordNotFoundException("task not found");
                case AkpFlow::FLOW_3->value:
                    throw new RecordNotFoundException("task not found");
            }

            $task = $this->workflowService->submitTask(
                $taskDto->id,
                $taskDto->task_action,
                $taskDto->object,
                $taskDto->remark
            );

            if ($taskDto->task_action == "reject") {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyRejectAkp($notificationDto, $pendingTask->object_group);
            }

            if ($taskDto->task_action == "approve" && $task->flow_id == AkpFlow::FLOW_2->value) {
                $akpDto = new AkpDto();
                $akpDto->fromArray((array) $task->objectTask->object);

                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "nama_atasan" => $akpDto->nama_atasan,
                    "atasan_url" => config("eyegil.client_url") . '/akp-grading/1/' . $akpDto->id,
                    "rekan_url" => config("eyegil.client_url") . '/akp-grading/2/' . $akpDto->id,
                ];
                $this->sendNotifyService->sendEmailAkpAtasan($notificationDto, $akpDto->email_atasan);
            }

            return $task;
        });
    }
}
