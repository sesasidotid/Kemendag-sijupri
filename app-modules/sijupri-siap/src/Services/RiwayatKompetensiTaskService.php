<?php

namespace Eyegil\SijupriSiap\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriMaintenance\Models\KategoriPengembangan;
use Eyegil\SijupriSiap\Dtos\RiwayatKompetensiDto;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RiwayatKompetensiTaskService
{
    private const workflow_name = "rw_kompetensi_task";

    public function __construct(
        private RiwayatKompetensiService $riwayatKompetensiService,
        private StorageService $storageService,
        private WorkflowService $workflowService,
        private SendNotifyService $sendNotifyService,
    ) {}

    public function create(RiwayatKompetensiDto $riwayatKompetensiDto)
    {
        $userContext = user_context();
        $riwayatKompetensiDto->nip = $userContext->id;

        $riwayatKompetensiDto->sertifikat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sertifikat_" . Carbon::now()->format('YmdHis'), $riwayatKompetensiDto->file_sertifikat);
        $riwayatKompetensiDto->sertifikat_url = $this->storageService->getUrl("system", "jf", $riwayatKompetensiDto->sertifikat);
        $riwayatKompetensiDto->file_sertifikat = null;

        $kategoriPengemban = KategoriPengembangan::findOrThrowNotFound($riwayatKompetensiDto->kategori_pengembangan_id);
        $riwayatKompetensiDto->kategori_pengembangan_name = $kategoriPengemban->name;
        $riwayatKompetensiDto->kategori_pengembangan_value = $kategoriPengemban->value;

        $pendingTask = $this->workflowService->startCreateTask(
            $this::workflow_name,
            Str::uuid(),
            $riwayatKompetensiDto->name,
            [],
            $riwayatKompetensiDto,
            $userContext->id
        );

        $notificationDto = new NotificationDto();
        $this->sendNotifyService->notifyVerifySIAP($notificationDto);

        return $pendingTask;
    }

    public function update(RiwayatKompetensiDto $riwayatKompetensiDto)
    {
        $userContext = user_context();
        $riwayatKompetensiDto->nip = $userContext->id;

        $riwayatKompetensi = $this->riwayatKompetensiService->findById($riwayatKompetensiDto->id);
        $riwayatKompetensiDto_old = new RiwayatKompetensiDto();
        $riwayatKompetensiDto_old->fromArray($riwayatKompetensi->toArray());

        if ($riwayatKompetensiDto->file_sertifikat) {
            $riwayatKompetensiDto->sertifikat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sertifikat_" . Carbon::now()->format('YmdHis'), $riwayatKompetensiDto->file_sertifikat);
            $riwayatKompetensiDto->sertifikat_url = $this->storageService->getUrl("system", "jf", $riwayatKompetensiDto->sertifikat);
            $riwayatKompetensiDto->file_sertifikat = null;
        }

        $kategoriPengemban = KategoriPengembangan::findOrThrowNotFound($riwayatKompetensiDto->kategori_pengembangan_id);
        $riwayatKompetensiDto->kategori_pengembangan_name = $kategoriPengemban->name;
        $riwayatKompetensiDto->kategori_pengembangan_value = $kategoriPengemban->value;

        $riwayatKompetensiDto_old->kategori_pengembangan_name = $riwayatKompetensi->kategoriPengemban->name;
        $riwayatKompetensiDto_old->kategori_pengembangan_value = $riwayatKompetensi->kategoriPengemban->value;
        $pendingTask = $this->workflowService->startUpdateTask(
            $this::workflow_name,
            $riwayatKompetensiDto->id,
            $riwayatKompetensiDto->name,
            [],
            $riwayatKompetensiDto,
            $riwayatKompetensiDto_old,
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
                $riwayatKompetensiDtoOld = new RiwayatKompetensiDto();
                $riwayatKompetensiDtoOld->fromArray((array) $pendingTask->objectTask->object);
                $riwayatKompetensiDto = new RiwayatKompetensiDto();
                $riwayatKompetensiDto->fromArray((array) $taskDto->object);

                if ($riwayatKompetensiDto->file_sertifikat) {
                    $riwayatKompetensiDto->sertifikat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sertifikat_" . Carbon::now()->format('YmdHis'), $riwayatKompetensiDto->file_sertifikat);
                    $riwayatKompetensiDto->sertifikat_url = $this->storageService->getUrl("system", "jf", $riwayatKompetensiDto->sertifikat);
                    $riwayatKompetensiDto->file_sertifikat = null;
                }

                $kategoriPengemban = KategoriPengembangan::findOrThrowNotFound($riwayatKompetensiDto->kategori_pengembangan_id);
                $riwayatKompetensiDto->kategori_pengembangan_name = $kategoriPengemban->name;
                $riwayatKompetensiDto->kategori_pengembangan_value = $kategoriPengemban->value;

                $taskDto->object = $riwayatKompetensiDto;
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
                    "siap_type" => "Riwayat kompetensi"
                ];
                $this->sendNotifyService->notifyRejectRwPendidikan($notificationDto, $pendingTask->object_group);
            } else {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "siap_type" => "Riwayat kompetensi"
                ];
                $this->sendNotifyService->notifyRwPendidikan($notificationDto, $pendingTask->object_group);
            }

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                $riwayatKompetensiDto = new RiwayatKompetensiDto();
                $riwayatKompetensiDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "create") {
                        return $this->riwayatKompetensiService->save($riwayatKompetensiDto);
                    } else if ($task->task_type == "update") {
                        return $this->riwayatKompetensiService->update($riwayatKompetensiDto);
                    } else if ($task->task_type == "delete") {
                        return $this->riwayatKompetensiService->delete($task->objectId);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
