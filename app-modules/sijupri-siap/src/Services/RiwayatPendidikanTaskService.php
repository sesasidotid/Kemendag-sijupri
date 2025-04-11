<?php

namespace Eyegil\SijupriSiap\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriMaintenance\Models\Pendidikan;
use Eyegil\SijupriSiap\Dtos\RiwayatPendidikanDto;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RiwayatPendidikanTaskService
{
    private const workflow_name = "rw_pendidikan_task";

    public function __construct(
        private RiwayatPendidikanService $riwayatPendidikanService,
        private StorageService $storageService,
        private WorkflowService $workflowService,
        private SendNotifyService $sendNotifyService,
    ) {}

    public function create(RiwayatPendidikanDto $riwayatPendidikanDto)
    {
        $userContext = user_context();
        $riwayatPendidikanDto->nip = $userContext->id;

        $riwayatPendidikanDto->ijazah = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "ijazah_" . Carbon::now()->format('YmdHis'), $riwayatPendidikanDto->file_ijazah);
        $riwayatPendidikanDto->ijazah_url = $this->storageService->getUrl("system", "jf", $riwayatPendidikanDto->ijazah);
        $riwayatPendidikanDto->file_ijazah = null;

        $pendidikan = Pendidikan::findOrThrowNotFound($riwayatPendidikanDto->pendidikan_code);
        $riwayatPendidikanDto->pendidikan_name = $pendidikan->name;
        $pendingTask = $this->workflowService->startCreateTask(
            $this::workflow_name,
            Str::uuid(),
            $pendidikan->name,
            [],
            $riwayatPendidikanDto,
            $userContext->id
        );

        $notificationDto = new NotificationDto();
        $this->sendNotifyService->notifyVerifySIAP($notificationDto);

        return $pendingTask;
    }

    public function update(RiwayatPendidikanDto $riwayatPendidikanDto)
    {
        $userContext = user_context();
        $riwayatPendidikanDto->nip = $userContext->id;

        $riwayatPendidikan = $this->riwayatPendidikanService->findById($riwayatPendidikanDto->id);
        $riwayatPendidikanDto_old = new RiwayatPendidikanDto();
        $riwayatPendidikanDto_old->fromArray($riwayatPendidikan->toArray());

        if ($riwayatPendidikanDto->file_ijazah) {
            $riwayatPendidikanDto->ijazah =  $this->storageService->putObjectFromBase64WithFilename("system", "jf", "ijazah_" . Carbon::now()->format('YmdHis'), $riwayatPendidikanDto->file_ijazah);
            $riwayatPendidikanDto->ijazah_url = $this->storageService->getUrl("system", "jf", $riwayatPendidikanDto->ijazah);
            $riwayatPendidikanDto->file_ijazah = null;
        }

        $pendidikan = Pendidikan::findOrThrowNotFound($riwayatPendidikanDto->pendidikan_code);
        $riwayatPendidikanDto->pendidikan_name = $pendidikan->name;

        $riwayatPendidikanDto_old->pendidikan_name = $riwayatPendidikan->pendidikan->name;
        $pendingTask = $this->workflowService->startUpdateTask(
            $this::workflow_name,
            $riwayatPendidikanDto->id,
            $pendidikan->name,
            [],
            $riwayatPendidikanDto,
            $riwayatPendidikanDto_old,
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
                $riwayatPendidikanDtoOld = new RiwayatPendidikanDto();
                $riwayatPendidikanDtoOld->fromArray((array) $pendingTask->objectTask->object);
                $riwayatPendidikanDto = new RiwayatPendidikanDto();
                $riwayatPendidikanDto->fromArray((array) $taskDto->object);

                if ($riwayatPendidikanDto->file_ijazah) {
                    $riwayatPendidikanDto->ijazah =  $this->storageService->putObjectFromBase64WithFilename("system", "jf", "ijazah_" . Carbon::now()->format('YmdHis'), $riwayatPendidikanDto->file_ijazah);
                    $riwayatPendidikanDto->ijazah_url = $this->storageService->getUrl("system", "jf", $riwayatPendidikanDto->ijazah);
                    $riwayatPendidikanDto->file_ijazah = null;
                }

                $pendidikan = Pendidikan::findOrThrowNotFound($riwayatPendidikanDto->pendidikan_code);
                $riwayatPendidikanDto->pendidikan_name = $pendidikan->name;

                $taskDto->object = $riwayatPendidikanDto;
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
                    "siap_type" => "Riwayat pendidikan"
                ];
                $this->sendNotifyService->notifyRejectRwPendidikan($notificationDto, $pendingTask->object_group);
            } else {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "siap_type" => "Riwayat pendidikan"
                ];
                $this->sendNotifyService->notifyRwPendidikan($notificationDto, $pendingTask->object_group);
            }

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                $riwayatPendidikanDto = new RiwayatPendidikanDto();
                $riwayatPendidikanDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "create") {
                        return $this->riwayatPendidikanService->save($riwayatPendidikanDto);
                    } else if ($task->task_type == "update") {
                        return $this->riwayatPendidikanService->update($riwayatPendidikanDto);
                    } else if ($task->task_type == "delete") {
                        return $this->riwayatPendidikanService->delete($task->objectId);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
