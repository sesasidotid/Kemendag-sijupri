<?php

namespace Eyegil\SijupriFormasi\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Pageable;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriFormasi\Dtos\FormasiDokumenDto;
use Eyegil\SijupriFormasi\Dtos\FormasiDto;
use Eyegil\SijupriFormasi\Dtos\FormasiPendingTaskDto;
use Eyegil\SijupriFormasi\Dtos\FormasiProsesVerifikasiDto;
use Eyegil\SijupriFormasi\Enums\FormasiFlow;
use Eyegil\SijupriMaintenance\Services\UnitKerjaService;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Converters\PendingTaskConverter;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\PendingTask;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FormasiTaskService
{
    const workflow_name = "formasi_task";

    public function __construct(
        private FormasiService $formasiService,
        private FormasiDetailService $formasiDetailService,
        private FormasiDokumenService $formasiDokumenService,
        private FormasiProsesVerifikasiService $formasiProsesVerifikasiService,
        private StorageService $storageService,
        private WorkflowService $workflowService,
        private UnitKerjaService $unitKerjaService,
        private SendNotifyService $sendNotifyService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $userContext = user_context();
        $pageable->addEqual("task_status", TaskStatus::PENDING);
        $pageable->addEqual("workflow_name", "formasi_task");

        if ($userContext->application_code == "sijupri-unit-kerja") {
            $pageable->addNotEqualIn("flow_id", [FormasiFlow::FLOW_1->value, FormasiFlow::FLOW_4->value]);
        }

        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PendingTask::class);
    }

    public function findByUnitKerjaId($unit_kerja_id)
    {
        $pendingTask = $this->workflowService->findTaskByWorkflowNameAndObjectGroup($this::workflow_name, $unit_kerja_id);
        $formasiDto = (new FormasiDto())->fromArray((array) $pendingTask->objectTask->object);
        $formasiPendingTaskDto = (new FormasiPendingTaskDto())->fromArray($formasiDto->toArray());
        $formasiPendingTaskDto->fromArray(PendingTaskConverter::withObjectTaskAndPendingTaskHistory($pendingTask)->toArray());
        $formasiPendingTaskDto->formasi_id = $formasiDto->id;

        return $formasiPendingTaskDto;
    }

    public function getDetailTask($pending_task_id)
    {
        $pendingTask = $this->workflowService->findTaskByWorkflowNameAndId($this::workflow_name, $pending_task_id);
        $formasiDto = (new FormasiDto())->fromArray((array) $pendingTask->objectTask->object);
        $formasiPendingTaskDto = (new FormasiPendingTaskDto())->fromArray($formasiDto->toArray());
        $formasiPendingTaskDto->fromArray(PendingTaskConverter::withObjectTaskAndPendingTaskHistory($pendingTask)->toArray());
        $formasiPendingTaskDto->formasi_id = $formasiDto->id;

        return $formasiPendingTaskDto;
    }

    public function create(FormasiDto $formasiDto)
    {
        return DB::transaction(function () use ($formasiDto) {
            $userContext = user_context();
            $unitKerja = $this->unitKerjaService->findById($userContext->getDetails("unit_kerja_id"));

            foreach ($formasiDto->formasi_dokumen_list as $key => $formasi_dokumen) {
                $formasiDokumenDto = new FormasiDokumenDto();
                $formasiDokumenDto->fromArray((array) $formasi_dokumen);

                $dokumenPersyaratan = $this->formasiDokumenService->findByDokumenPersyaratanId($formasiDokumenDto->dokumen_persyaratan_id);
                $formasiDokumenDto->dokumen = $this->storageService->putObjectFromBase64WithFilename("system", "formasi", "formasi_" . $formasiDokumenDto->dokumen_persyaratan_id . Carbon::now()->format('YmdHis'), $formasiDokumenDto->dokumen_file);
                $formasiDokumenDto->dokumen_url = $this->storageService->getUrl("system", "formasi", $formasiDokumenDto->dokumen);;
                $formasiDokumenDto->dokumen_file = null;
                $formasiDokumenDto->dokumen_status = "APPROVE";
                $formasiDokumenDto->dokumen_persyaratan_name = $dokumenPersyaratan->name;

                $formasiDto->formasi_dokumen_list[$key] = $formasiDokumenDto;
            }

            $formasiDto->unit_kerja_id = $unitKerja->id;
            $formasiDto->unit_kerja_name = $unitKerja->name;
            $formasi = $this->formasiService->save($formasiDto);

            $formasiDto->id = $formasi->id;
            $pendingTask = $this->workflowService->startCreateTask(
                $this::workflow_name,
                $formasiDto->id,
                $unitKerja->name,
                ['unit_kerja_id' => $formasiDto->unit_kerja_id],
                $formasiDto,
                $unitKerja->id
            );

            $notificationDto = new NotificationDto();
            $this->sendNotifyService->notifyVerifyFormasi($notificationDto);

            return $pendingTask;
        });
    }

    public function submit(TaskDto $taskDto)
    {
        return DB::transaction(function () use ($taskDto) {
            $pendingTask = $this->workflowService->findTaskById($taskDto->id);

            switch ($pendingTask->flow_id) {
                case FormasiFlow::FLOW_1->value:
                    $formasiDto = (new FormasiDto())->fromArray((array) $pendingTask->objectTask->object);
                    foreach (["JB11", "JB10", "JB8", "JB7", "JB4", "JB1"] as $jabatan_code) {
                        if (!$this->formasiDetailService->findByFormasiIdAndJabatanCode($formasiDto->id, $jabatan_code)) {
                            throw new BusinessException("For-00001", "Jabatan code " . $jabatan_code . " not found");
                        }
                    }
                    break;

                case FormasiFlow::FLOW_2->value:
                    $formasiDto = new FormasiDto();
                    $formasiDto->fromArray((array) $pendingTask->objectTask->object);

                    if ($taskDto->task_action == "reject") {
                        $formasiDtoReq = (new FormasiDto())->fromArray((array) $taskDto->object)->validateFlow2Reject();

                        $formasiDokumenLookup = [];
                        foreach ($formasiDtoReq->formasi_dokumen_list as $key => $formasi_dokumen) {
                            $formasiDokumenReqDto = (new FormasiDokumenDto())->fromArray((array) $formasi_dokumen)->validateFlow2Reject();
                            $formasiDokumenLookup[$formasiDokumenReqDto->dokumen_persyaratan_id] = [
                                'data' => $formasiDokumenReqDto,
                                'key' => $key
                            ];
                        }

                        foreach ($formasiDto->formasi_dokumen_list as $key => $formasi_dokumen_old) {
                            $formasiDokumenDto = new FormasiDokumenDto();
                            $formasiDokumenDto->fromArray((array) $formasi_dokumen_old);

                            if (isset($formasiDokumenLookup[$formasiDokumenDto->dokumen_persyaratan_id])) {
                                $formasiDokumenDto->dokumen_status = "REJECT";
                            }
                            $formasiDto->formasi_dokumen_list[$key] = $formasiDokumenDto;
                        }
                    } else if ($taskDto->task_action == "approve") {
                        $formasiProsesVerifikasiDto = (new FormasiProsesVerifikasiDto())->fromArray((array) $taskDto->object)->validateFlow2();

                        $formasiProsesVerifikasiDto->surat_undangan = $this->storageService->putObjectFromBase64WithFilename("system", "formasi", "surat_undangan_" . Carbon::now()->format('YmdHis'), $formasiProsesVerifikasiDto->file_surat_undangan);
                        $formasiProsesVerifikasiDto->surat_undangan_url = $this->storageService->getUrl("system", "formasi", $formasiProsesVerifikasiDto->surat_undangan);
                        $formasiProsesVerifikasiDto->file_surat_undangan = null;
                        $formasiProsesVerifikasiDto->formasi_id = $formasiDto->id;
                        $this->formasiProsesVerifikasiService->save($formasiProsesVerifikasiDto);
                    } else throw new RecordNotFoundException("could not find action : " . $taskDto->task_action);

                    $taskDto->object = $formasiDto;
                    break;

                case FormasiFlow::FLOW_3->value:
                    $formasiDto = (new FormasiDto())->fromArray((array) $taskDto->object)->validateFlow3();
                    $this->formasiDetailService->updateResult($formasiDto);

                    $taskDto->object = (new FormasiDto())->fromArray((array) $pendingTask->objectTask->object);
                    break;

                case FormasiFlow::FLOW_4->value:
                    $formasiDto = new FormasiDto();
                    $formasiDto->fromArray((array) $pendingTask->objectTask->object);
                    $formasiDtoReq = (new FormasiDto())->fromArray((array) $taskDto->object)->validateFlow2Reject();

                    $formasiDokumenLookup = [];
                    foreach ($formasiDtoReq->formasi_dokumen_list as $key => $formasi_dokumen) {
                        $formasiDokumenReqDto = (new FormasiDokumenDto())->fromArray((array) $formasi_dokumen)->validateFlow2Reject();
                        $formasiDokumenLookup[$formasiDokumenReqDto->dokumen_persyaratan_id] = [
                            'data' => $formasiDokumenReqDto,
                            'key' => $key
                        ];
                    }

                    foreach ($formasiDto->formasi_dokumen_list as $key => $formasi_dokumen_old) {
                        $formasiDokumenDto = new FormasiDokumenDto();
                        $formasiDokumenDto->fromArray((array) $formasi_dokumen_old);

                        if (isset($formasiDokumenLookup[$formasiDokumenDto->dokumen_persyaratan_id])) {
                            $formasiDokumenReqDto = $formasiDokumenLookup[$formasiDokumenDto->dokumen_persyaratan_id]["data"];

                            $formasiDokumenDto->dokumen = $this->storageService->putObjectFromBase64WithFilename("system",     "formasi",   "formasi_" . $formasiDokumenDto->dokumen_persyaratan_id . Carbon::now()->format('YmdHis'),   $formasiDokumenReqDto->dokumen_file);
                            $formasiDokumenDto->dokumen_url = $this->storageService->getUrl("system", "formasi", $formasiDokumenDto->dokumen);
                            $formasiDokumenDto->dokumen_status = "APPROVE";
                        }
                        if ($formasiDokumenDto->dokumen_status == "REJECT") {
                            throw new BusinessException("Please makesure to upload rejected documents", "");
                        }

                        $formasiDto->formasi_dokumen_list[$key] = $formasiDokumenDto;
                    }

                    $taskDto->object = $formasiDto;
                    break;

                case FormasiFlow::FLOW_5->value:
                    $formasiDto = new FormasiDto();
                    $formasiDto->fromArray((array) $pendingTask->objectTask->object);
                    $formasiDtoReq = (new FormasiDto())->fromArray((array) $taskDto->object)->validateFlow5();

                    $formasiDto->rekomendasi = $this->storageService->putObjectFromBase64WithFilename("system", "formasi", "rekomendasi_" . Carbon::now()->format('YmdHis'), $formasiDtoReq->file_rekomendasi);

                    $taskDto->object = $formasiDto;
                    break;
            }

            $task = $this->workflowService->submitTask(
                $taskDto->id,
                $taskDto->task_action,
                $taskDto->object,
                $taskDto->remark
            );

            if ($task->flow_code == FormasiFlow::FLOW_2->value) {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyVerifyFormasi($notificationDto);
            } else if ($task->flow_code == FormasiFlow::FLOW_4->value) {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyRejectFormasi($notificationDto);
            } else if ($task->flow_code == FormasiFlow::FLOW_3->value) {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyInviteFormasi($notificationDto);
            }

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                if ($taskDto->task_action == "approve") {
                    $formasiDto = new FormasiDto();
                    $formasiDto->fromArray((array) $task->objectTask->object);

                    if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                        if ($task->task_type == "create") {
                            return $this->formasiService->update($formasiDto);
                        }
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
