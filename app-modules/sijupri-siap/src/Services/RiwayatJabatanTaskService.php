<?php

namespace Eyegil\SijupriSiap\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Eyegil\SijupriSiap\Dtos\RiwayatJabatanDto;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RiwayatJabatanTaskService
{
    private const workflow_name = "rw_jabatan_task";

    public function __construct(
        private RiwayatJabatanService $riwayatJabatanService,
        private StorageService $storageService,
        private WorkflowService $workflowService,
        private SendNotifyService $sendNotifyService,
    ) {}

    public function create(RiwayatJabatanDto $riwayatJabatanDto)
    {
        $userContext = user_context();
        $riwayatJabatanDto->nip = $userContext->id;

        $riwayatJabatanDto->sk_jabatan = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sk_jabatan_" . Carbon::now()->format('YmdHis'), $riwayatJabatanDto->file_sk_jabatan);
        $riwayatJabatanDto->sk_jabatan_url = $this->storageService->getUrl("system", "jf", $riwayatJabatanDto->sk_jabatan);
        $riwayatJabatanDto->file_sk_jabatan = null;

        $jabatan = Jabatan::findOrThrowNotFound($riwayatJabatanDto->jabatan_code);
        $jenjang = Jenjang::findOrThrowNotFound($riwayatJabatanDto->jenjang_code);
        $riwayatJabatanDto->jenjang_name = $jenjang->name;
        $riwayatJabatanDto->jabatan_name = $jabatan->name;

        $pendingTask = $this->workflowService->startCreateTask(
            $this::workflow_name,
            Str::uuid(),
            $jabatan->name . " | " . $jenjang->name,
            [],
            $riwayatJabatanDto,
            $userContext->id
        );

        $notificationDto = new NotificationDto();
        $this->sendNotifyService->notifyVerifySIAP($notificationDto);

        return $pendingTask;
    }

    public function update(RiwayatJabatanDto $riwayatJabatanDto)
    {
        $userContext = user_context();
        $riwayatJabatanDto->nip = $userContext->id;

        $riwayatJabatan = $this->riwayatJabatanService->findById($riwayatJabatanDto->id);
        $riwayatJabatanDto_old = new RiwayatJabatanDto();
        $riwayatJabatanDto_old->fromArray($riwayatJabatan->toArray());

        if ($riwayatJabatanDto->file_sk_jabatan) {
            $riwayatJabatanDto->sk_jabatan = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sk_jabatan_" . Carbon::now()->format('YmdHis'), $riwayatJabatanDto->file_sk_jabatan);
            $riwayatJabatanDto->sk_jabatan_url = $this->storageService->getUrl("system", "jf", $riwayatJabatanDto->sk_jabatan);
            $riwayatJabatanDto->file_sk_jabatan = null;
        }

        $jabatan = Jabatan::findOrThrowNotFound($riwayatJabatanDto->jabatan_code);
        $jenjang = Jenjang::findOrThrowNotFound($riwayatJabatanDto->jenjang_code);
        $riwayatJabatanDto->jenjang_name = $jenjang->name;
        $riwayatJabatanDto->jabatan_name = $jabatan->name;

        $riwayatJabatanDto->jenjang_name = $riwayatJabatan->jenjang->name;
        $riwayatJabatanDto->jabatan_name = $riwayatJabatan->jabatan->name;
        $pendingTask = $this->workflowService->startUpdateTask(
            $this::workflow_name,
            $riwayatJabatanDto->id,
            $jabatan->name . " | " . $jenjang->name,
            [],
            $riwayatJabatanDto,
            $riwayatJabatanDto_old,
            $userContext->id
        );

        $notificationDto = new NotificationDto();
        $this->sendNotifyService->notifyVerifySIAP($notificationDto);

        return $pendingTask;
    }

    public function submit(TaskDto $taskDto)
    {
        return DB::transaction(function () use ($taskDto) {
            $pendingTask = $this->workflowService->findTaskById($taskDto->id);

            if ($taskDto->object) {
                $riwayatJabatanDtoOld = new RiwayatJabatanDto();
                $riwayatJabatanDtoOld->fromArray((array) $pendingTask->objectTask->object);
                $riwayatJabatanDto = new RiwayatJabatanDto();
                $riwayatJabatanDto->fromArray((array) $taskDto->object);

                if ($riwayatJabatanDto->file_sk_jabatan) {
                    $riwayatJabatanDto->sk_jabatan = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sk_jabatan_" . Carbon::now()->format('YmdHis'), $riwayatJabatanDto->file_sk_jabatan);
                    $riwayatJabatanDto->sk_jabatan_url = $this->storageService->getUrl("system", "jf", $riwayatJabatanDto->sk_jabatan);
                    $riwayatJabatanDto->file_sk_jabatan = null;
                }

                $jabatan = Jabatan::findOrThrowNotFound($riwayatJabatanDto->jabatan_code);
                $jenjang = Jenjang::findOrThrowNotFound($riwayatJabatanDto->jenjang_code);
                $riwayatJabatanDto->jenjang_name = $jenjang->name;
                $riwayatJabatanDto->jabatan_name = $jabatan->name;

                $taskDto->object = $riwayatJabatanDto;
            }

            $task = $this->workflowService->submitTask(
                $taskDto->id,
                $taskDto->task_action,
                $taskDto->object,
                $taskDto->remark
            );

            if ($task->flow == "siap_flow_1") {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyVerifySIAP($notificationDto);
            } else if ($task->flow == "siap_flow_2") {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "siap_type" => "Riwayat jabatan"
                ];
                $this->sendNotifyService->notifyRejectRwJabatan($notificationDto, $pendingTask->object_group);
            } else {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "siap_type" => "Riwayat jabatan"
                ];
                $this->sendNotifyService->notifyRwJabatan($notificationDto, $pendingTask->object_group);
            }

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                $riwayatJabatanDto = new RiwayatJabatanDto();
                $riwayatJabatanDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "create") {
                        return $this->riwayatJabatanService->save($riwayatJabatanDto);
                    } else if ($task->task_type == "update") {
                        return $this->riwayatJabatanService->update($riwayatJabatanDto);
                    } else if ($task->task_type == "delete") {
                        return $this->riwayatJabatanService->delete($task->objectId);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
