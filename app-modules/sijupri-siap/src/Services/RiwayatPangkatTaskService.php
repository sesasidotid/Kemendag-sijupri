<?php

namespace Eyegil\SijupriSiap\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriMaintenance\Models\Pangkat;
use Eyegil\SijupriSiap\Dtos\RiwayatPangkatDto;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RiwayatPangkatTaskService
{
    private const workflow_name = "rw_pangkat_task";

    public function __construct(
        private RiwayatPangkatService $riwayatPangkatService,
        private StorageService $storageService,
        private WorkflowService $workflowService,
        private SendNotifyService $sendNotifyService,
    ) {}

    public function create(RiwayatPangkatDto $riwayatPangkatDto)
    {
        $userContext = user_context();
        $riwayatPangkatDto->nip = $userContext->id;

        $riwayatPangkatDto->sk_pangkat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sk_pangkat_" . Carbon::now()->format('YmdHis'), $riwayatPangkatDto->file_sk_pangkat);
        $riwayatPangkatDto->sk_pangkat_url = $this->storageService->getUrl("system", "jf", $riwayatPangkatDto->sk_pangkat);
        $riwayatPangkatDto->file_sk_pangkat = null;

        $pangkat = Pangkat::findOrThrowNotFound($riwayatPangkatDto->pangkat_code);
        $riwayatPangkatDto->pangkat_name = $pangkat->name;
        $pendingTask = $this->workflowService->startCreateTask(
            $this::workflow_name,
            $riwayatPangkatDto->id,
            $pangkat->name,
            [],
            $riwayatPangkatDto,
            $userContext->id
        );

        $notificationDto = new NotificationDto();
        $this->sendNotifyService->notifyVerifySIAP($notificationDto);

        return $pendingTask;
    }

    public function update(RiwayatPangkatDto $riwayatPangkatDto)
    {
        $userContext = user_context();
        $riwayatPangkatDto->nip = $userContext->id;

        $riwayatPangkat = $this->riwayatPangkatService->findById($riwayatPangkatDto->id);
        $riwayatPangkatDto_old = new RiwayatPangkatDto();
        $riwayatPangkatDto_old->fromArray($riwayatPangkat->toArray());

        if ($riwayatPangkatDto->file_sk_pangkat) {
            $riwayatPangkatDto->sk_pangkat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", $riwayatPangkatDto->sk_pangkat, $riwayatPangkatDto->file_sk_pangkat);
            $riwayatPangkatDto->sk_pangkat_url = $this->storageService->getUrl("system", "jf", $riwayatPangkatDto->sk_pangkat);
            $riwayatPangkatDto->file_sk_pangkat = null;
        }

        $pangkat = Pangkat::findOrThrowNotFound($riwayatPangkatDto->pangkat_code);
        $riwayatPangkatDto->pangkat_name = $pangkat->name;

        $riwayatPangkatDto_old->pangkat_name = $riwayatPangkat->pangkat->name;
        $pendingTask = $this->workflowService->startUpdateTask(
            $this::workflow_name,
            Str::uuid(),
            $pangkat->name,
            [],
            $riwayatPangkatDto,
            $riwayatPangkatDto_old,
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
                $riwayatPangkatDtoOld = new RiwayatPangkatDto();
                $riwayatPangkatDtoOld->fromArray((array) $pendingTask->objectTask->object);
                $riwayatPangkatDto = new RiwayatPangkatDto();
                $riwayatPangkatDto->fromArray((array) $taskDto->object);

                if ($riwayatPangkatDto->file_sk_pangkat) {
                    $riwayatPangkatDto->sk_pangkat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", $riwayatPangkatDto->sk_pangkat, $riwayatPangkatDto->file_sk_pangkat);
                    $riwayatPangkatDto->sk_pangkat_url = $this->storageService->getUrl("system", "jf", $riwayatPangkatDto->sk_pangkat);
                    $riwayatPangkatDto->file_sk_pangkat = null;
                }

                $pangkat = Pangkat::findOrThrowNotFound($riwayatPangkatDto->pangkat_code);
                $riwayatPangkatDto->pangkat_name = $pangkat->name;

                $taskDto->object = $riwayatPangkatDto;
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
                    "siap_type" => "Riwayat pangkat"
                ];
                $this->sendNotifyService->notifyRejectRwPangkat($notificationDto, $pendingTask->object_group);
            } else {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "siap_type" => "Riwayat pangkat"
                ];
                $this->sendNotifyService->notifyRwPangkat($notificationDto, $pendingTask->object_group);
            }

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                $riwayatPangkatDto = new RiwayatPangkatDto();
                $riwayatPangkatDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "create") {
                        return $this->riwayatPangkatService->save($riwayatPangkatDto);
                    } else if ($task->task_type == "update") {
                        return $this->riwayatPangkatService->update($riwayatPangkatDto);
                    } else if ($task->task_type == "delete") {
                        return $this->riwayatPangkatService->delete($task->objectId);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
