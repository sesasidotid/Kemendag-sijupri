<?php

namespace Eyegil\SijupriSiap\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriMaintenance\Models\KategoriSertifikasi;
use Eyegil\SijupriSiap\Dtos\RiwayatSertifikasiDto;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;

class RiwayatSertifikasiTaskService
{
    private const workflow_name = "rw_sertifikasi_task";

    public function __construct(
        private RiwayatSertifikasiService $riwayatSertifikasiService,
        private StorageService $storageService,
        private WorkflowService $workflowService,
        private SendNotifyService $sendNotifyService,
    ) {}

    public function create(RiwayatSertifikasiDto $riwayatSertifikasiDto)
    {
        $userContext = user_context();
        $riwayatSertifikasiDto->nip = $userContext->id;

        $riwayatSertifikasiDto->sk_pengangkatan = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sk_pengangkatan_" . Carbon::now()->format('YmdHis'), $riwayatSertifikasiDto->file_sk_pengangkatan);
        $riwayatSertifikasiDto->sk_pengangkatan_url = $this->storageService->getUrl("system", "jf", $riwayatSertifikasiDto->sk_pengangkatan);
        $riwayatSertifikasiDto->file_sk_pengangkatan = null;

        if ($riwayatSertifikasiDto->file_ktp_ppns) {
            $riwayatSertifikasiDto->ktp_ppns = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "ktp_ppns_" . Carbon::now()->format('YmdHis'), $riwayatSertifikasiDto->file_ktp_ppns);
            $riwayatSertifikasiDto->ktp_ppns_url = $this->storageService->getUrl("system", "jf", $riwayatSertifikasiDto->ktp_ppns);
            $riwayatSertifikasiDto->file_ktp_ppns = null;
        }

        $kategoriSertifikasi = KategoriSertifikasi::findOrThrowNotFound($riwayatSertifikasiDto->kategori_sertifikasi_id);
        $riwayatSertifikasiDto->kategori_sertifikasi_name = $kategoriSertifikasi->name;
        $riwayatSertifikasiDto->kategori_sertifikasi_value = $kategoriSertifikasi->value;
        $pendingTask = $this->workflowService->startCreateTask(
            $this::workflow_name,
            $riwayatSertifikasiDto->id,
            $kategoriSertifikasi->name,
            [],
            $riwayatSertifikasiDto,
            $userContext->id
        );

        $notificationDto = new NotificationDto();
        $this->sendNotifyService->notifyVerifySIAP($notificationDto);

        return $pendingTask;
    }

    public function update(RiwayatSertifikasiDto $riwayatSertifikasiDto)
    {
        $userContext = user_context();
        $riwayatSertifikasiDto->nip = $userContext->id;

        $riwayatSertifikasi = $this->riwayatSertifikasiService->findById($riwayatSertifikasiDto->id);
        $riwayatSertifikasiDto_old = new RiwayatSertifikasiDto();
        $riwayatSertifikasiDto_old->fromArray($riwayatSertifikasi->toArray());

        if ($riwayatSertifikasiDto->file_sk_pengangkatan) {
            $riwayatSertifikasiDto->sk_pengangkatan = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sk_pengangkatan_" . Carbon::now()->format('YmdHis'), $riwayatSertifikasiDto->file_sk_pengangkatan);
            $riwayatSertifikasiDto->sk_pengangkatan_url = $this->storageService->getUrl("system", "jf", $riwayatSertifikasiDto->sk_pengangkatan);
            $riwayatSertifikasiDto->file_sk_pengangkatan = null;
        }
        if ($riwayatSertifikasiDto->file_ktp_ppns) {
            $riwayatSertifikasiDto->ktp_ppns = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "ktp_ppns_" . Carbon::now()->format('YmdHis'), $riwayatSertifikasiDto->file_ktp_ppns);
            $riwayatSertifikasiDto->ktp_ppns_url = $this->storageService->getUrl("system", "jf", $riwayatSertifikasiDto->ktp_ppns);
            $riwayatSertifikasiDto->file_ktp_ppns = null;
        }

        $kategoriSertifikasi = KategoriSertifikasi::findOrThrowNotFound($riwayatSertifikasiDto->kategori_sertifikasi_id);
        $riwayatSertifikasiDto->kategori_sertifikasi_name = $kategoriSertifikasi->name;
        $riwayatSertifikasiDto->kategori_sertifikasi_value = $kategoriSertifikasi->value;

        $riwayatSertifikasiDto_old->kategori_sertifikasi_name = $riwayatSertifikasi->kategoriSertifikasi->name;
        $riwayatSertifikasiDto_old->kategori_sertifikasi_value = $riwayatSertifikasi->kategoriSertifikasi->value;
        $pendingTask = $this->workflowService->startUpdateTask(
            $this::workflow_name,
            $riwayatSertifikasiDto->id,
            $kategoriSertifikasi->name,
            [],
            $riwayatSertifikasiDto,
            $riwayatSertifikasiDto_old,
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
                $riwayatSertifikasiDtoOld = new RiwayatSertifikasiDto();
                $riwayatSertifikasiDtoOld->fromArray((array) $pendingTask->objectTask->object);
                $riwayatSertifikasiDto = new RiwayatSertifikasiDto();
                $riwayatSertifikasiDto->fromArray((array) $taskDto->object);

                if ($riwayatSertifikasiDto->file_sk_pengangkatan) {
                    $riwayatSertifikasiDto->sk_pengangkatan = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "sk_pengangkatan_" . Carbon::now()->format('YmdHis'), $riwayatSertifikasiDto->file_sk_pengangkatan);
                    $riwayatSertifikasiDto->sk_pengangkatan_url = $this->storageService->getUrl("system", "jf", $riwayatSertifikasiDto->sk_pengangkatan);
                    $riwayatSertifikasiDto->file_sk_pengangkatan = null;
                }
                if ($riwayatSertifikasiDto->file_ktp_ppns) {
                    $riwayatSertifikasiDto->ktp_ppns = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "ktp_ppns_" . Carbon::now()->format('YmdHis'), $riwayatSertifikasiDto->file_ktp_ppns);
                    $riwayatSertifikasiDto->ktp_ppns_url = $this->storageService->getUrl("system", "jf", $riwayatSertifikasiDto->ktp_ppns);
                    $riwayatSertifikasiDto->file_ktp_ppns = null;
                }

                $kategoriSertifikasi = KategoriSertifikasi::findOrThrowNotFound($riwayatSertifikasiDto->kategori_sertifikasi_id);
                $riwayatSertifikasiDto->kategori_sertifikasi_name = $kategoriSertifikasi->name;
                $riwayatSertifikasiDto->kategori_sertifikasi_value = $kategoriSertifikasi->value;

                $taskDto->object = $riwayatSertifikasiDto;
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
                    "siap_type" => "Riwayat sertifikasi"
                ];
                $this->sendNotifyService->notifyRejectRwSertifikasi($notificationDto, $pendingTask->object_group);
            } else {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "siap_type" => "Riwayat sertifikasi"
                ];
                $this->sendNotifyService->notifyRwSertifikasi($notificationDto, $pendingTask->object_group);
            }

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                $riwayatSertifikasiDto = new RiwayatSertifikasiDto();
                $riwayatSertifikasiDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "create") {
                        return $this->riwayatSertifikasiService->save($riwayatSertifikasiDto);
                    } else if ($task->task_type == "update") {
                        return $this->riwayatSertifikasiService->update($riwayatSertifikasiDto);
                    } else if ($task->task_type == "delete") {
                        return $this->riwayatSertifikasiService->delete($task->objectId);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
