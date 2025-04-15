<?php

namespace Eyegil\SijupriSiap\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriMaintenance\Models\PredikatKinerja;
use Eyegil\SijupriMaintenance\Models\RatingKinerja;
use Eyegil\SijupriSiap\Dtos\RiwayatKinerjaDto;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RiwayatKinerjaTaskService
{
    private const workflow_name = "rw_kinerja_task";

    public function __construct(
        private RiwayatKinerjaService $riwayatKinerjaService,
        private StorageService $storageService,
        private WorkflowService $workflowService,
        private SendNotifyService $sendNotifyService,
    ) {}

    public function create(RiwayatKinerjaDto $riwayatKinerjaDto)
    {
        return DB::transaction(function () use ($riwayatKinerjaDto) {
            $userContext = user_context();
            $riwayatKinerjaDto->nip = $userContext->id;

            $riwayatKinerjaDto->doc_evaluasi = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_evaluasi_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_evaluasi);
            $riwayatKinerjaDto->doc_evaluasi_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_evaluasi);
            $riwayatKinerjaDto->file_doc_evaluasi = null;

            $riwayatKinerjaDto->doc_predikat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_predikat_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_predikat);
            $riwayatKinerjaDto->doc_predikat_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_predikat);
            $riwayatKinerjaDto->file_doc_predikat = null;

            $riwayatKinerjaDto->doc_akumulasi_ak = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_akumulasi_ak_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_akumulasi_ak);
            $riwayatKinerjaDto->doc_akumulasi_ak_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_akumulasi_ak);
            $riwayatKinerjaDto->file_doc_akumulasi_ak = null;

            $riwayatKinerjaDto->doc_penetapan_ak = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_penetapan_ak_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_penetapan_ak);
            $riwayatKinerjaDto->doc_penetapan_ak_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_penetapan_ak);
            $riwayatKinerjaDto->file_doc_penetapan_ak = null;

            $ratinHasil = RatingKinerja::findOrThrowNotFound($riwayatKinerjaDto->rating_hasil_id);
            $riwayatKinerjaDto->rating_hasil_name = $ratinHasil->name;
            $riwayatKinerjaDto->rating_hasil_value = $ratinHasil->value;

            $ratinKinerja = RatingKinerja::findOrThrowNotFound($riwayatKinerjaDto->rating_kinerja_id);
            $riwayatKinerjaDto->rating_kinerja_name = $ratinKinerja->name;
            $riwayatKinerjaDto->rating_kinerja_value = $ratinKinerja->value;

            $predikatKinerja = PredikatKinerja::findOrThrowNotFound($riwayatKinerjaDto->predikat_kinerja_id);
            $riwayatKinerjaDto->predikat_kinerja_name = $predikatKinerja->name;
            $riwayatKinerjaDto->predikat_kinerja_value = $predikatKinerja->value;

            $pendingTask = $this->workflowService->startCreateTask(
                $this::workflow_name,
                Str::uuid(),
                $riwayatKinerjaDto->angka_kredit,
                [],
                $riwayatKinerjaDto,
                $userContext->id
            );

            $notificationDto = new NotificationDto();
            $this->sendNotifyService->notifyVerifySIAPKinerja($notificationDto);
    
            return $pendingTask;
        });
    }

    public function update(RiwayatKinerjaDto $riwayatKinerjaDto)
    {
        return DB::transaction(function () use ($riwayatKinerjaDto) {
            $userContext = user_context();
            $riwayatKinerjaDto->nip = $userContext->id;

            $riwayatKinerja = $this->riwayatKinerjaService->findById($riwayatKinerjaDto->id);
            $riwayatKinerjaDto_old = new RiwayatKinerjaDto();
            $riwayatKinerjaDto_old->fromArray($riwayatKinerja->toArray());

            if ($riwayatKinerjaDto->file_doc_evaluasi) {
                $riwayatKinerjaDto->doc_evaluasi = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_evaluasi_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_evaluasi);
                $riwayatKinerjaDto->doc_evaluasi_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_evaluasi);
                $riwayatKinerjaDto->file_doc_evaluasi = null;
            }
            if ($riwayatKinerjaDto->file_doc_predikat) {
                $riwayatKinerjaDto->doc_predikat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_predikat_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_predikat);
                $riwayatKinerjaDto->doc_predikat_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_predikat);
                $riwayatKinerjaDto->file_doc_predikat = null;
            }
            if ($riwayatKinerjaDto->file_doc_akumulasi_ak) {
                $riwayatKinerjaDto->doc_akumulasi_ak = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_akumulasi_ak_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_akumulasi_ak);
                $riwayatKinerjaDto->doc_penetapan_ak_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_penetapan_ak);
                $riwayatKinerjaDto->file_doc_akumulasi_ak = null;
            }
            if ($riwayatKinerjaDto->file_doc_penetapan_ak) {
                $riwayatKinerjaDto->doc_penetapan_ak = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_penetapan_ak_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_penetapan_ak);
                $riwayatKinerjaDto->doc_penetapan_ak_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_penetapan_ak);
                $riwayatKinerjaDto->file_doc_penetapan_ak = null;
            }

            $ratinHasil = RatingKinerja::findOrThrowNotFound($riwayatKinerjaDto->rating_hasil_id);
            $riwayatKinerjaDto->rating_hasil_name = $ratinHasil->name;
            $riwayatKinerjaDto->rating_hasil_value = $ratinHasil->value;

            $riwayatKinerjaDto_old->rating_hasil_name = $riwayatKinerja->ratinHasil->name;
            $riwayatKinerjaDto_old->rating_hasil_value = $riwayatKinerja->ratinHasil->value;

            $ratinKinerja = RatingKinerja::findOrThrowNotFound($riwayatKinerjaDto->rating_kinerja_id);
            $riwayatKinerjaDto->rating_kinerja_name = $ratinKinerja->name;
            $riwayatKinerjaDto->rating_kinerja_value = $ratinKinerja->value;

            $riwayatKinerjaDto_old->rating_kinerja_name = $riwayatKinerja->ratinKinerja->name;
            $riwayatKinerjaDto_old->rating_kinerja_value = $riwayatKinerja->ratinKinerja->value;

            $predikatKinerja = PredikatKinerja::findOrThrowNotFound($riwayatKinerjaDto->predikat_kinerja_id);
            $riwayatKinerjaDto->predikat_kinerja_name = $predikatKinerja->name;
            $riwayatKinerjaDto->predikat_kinerja_value = $predikatKinerja->value;

            $riwayatKinerjaDto_old->predikat_kinerja_name = $riwayatKinerja->predikatKinerja->name;
            $riwayatKinerjaDto_old->predikat_kinerja_value = $riwayatKinerja->predikatKinerja->value;

            $pendingTask = $this->workflowService->startUpdateTask(
                $this::workflow_name,
                $riwayatKinerjaDto->id,
                null,
                [],
                $riwayatKinerjaDto,
                $riwayatKinerjaDto_old,
                $userContext->id
            );

            $notificationDto = new NotificationDto();
            $this->sendNotifyService->notifyVerifySIAPKinerja($notificationDto);
    
            return $pendingTask;
        });
    }

    public function submit(TaskDto $taskDto)
    {
        return DB::transaction(function () use ($taskDto) {
            $pendingTask = $this->workflowService->findTaskById($taskDto->id);

            if ($taskDto->object) {
                $riwayatKinerjaDtoOld = new RiwayatKinerjaDto();
                $riwayatKinerjaDtoOld->fromArray((array) $pendingTask->objectTask->object);
                $riwayatKinerjaDto = new RiwayatKinerjaDto();
                $riwayatKinerjaDto->fromArray((array) $taskDto->object);

                if ($riwayatKinerjaDto->file_doc_evaluasi) {
                    $riwayatKinerjaDto->doc_evaluasi = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_evaluasi_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_evaluasi);
                    $riwayatKinerjaDto->doc_evaluasi_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_evaluasi);
                    $riwayatKinerjaDto->file_doc_evaluasi = null;
                }
                if ($riwayatKinerjaDto->file_doc_predikat) {
                    $riwayatKinerjaDto->doc_predikat = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_predikat_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_predikat);
                    $riwayatKinerjaDto->doc_predikat_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_predikat);
                    $riwayatKinerjaDto->file_doc_predikat = null;
                }
                if ($riwayatKinerjaDto->file_doc_akumulasi_ak) {
                    $riwayatKinerjaDto->doc_akumulasi_ak = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_akumulasi_ak_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_akumulasi_ak);
                    $riwayatKinerjaDto->doc_akumulasi_ak_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_penetapan_ak);
                    $riwayatKinerjaDto->file_doc_akumulasi_ak = null;
                }
                if ($riwayatKinerjaDto->file_doc_penetapan_ak) {
                    $riwayatKinerjaDto->doc_penetapan_ak = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "doc_penetapan_ak_" . Carbon::now()->format('YmdHis'), $riwayatKinerjaDto->file_doc_penetapan_ak);
                    $riwayatKinerjaDto->doc_penetapan_ak_url = $this->storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_penetapan_ak);
                    $riwayatKinerjaDto->file_doc_penetapan_ak = null;
                }

                $ratinHasil = RatingKinerja::findOrThrowNotFound($riwayatKinerjaDto->rating_hasil_id);
                $riwayatKinerjaDto->rating_hasil_name = $ratinHasil->name;
                $riwayatKinerjaDto->rating_hasil_value = $ratinHasil->value;

                $ratinKinerja = RatingKinerja::findOrThrowNotFound($riwayatKinerjaDto->rating_kinerja_id);
                $riwayatKinerjaDto->rating_kinerja_name = $ratinKinerja->name;
                $riwayatKinerjaDto->rating_kinerja_value = $ratinKinerja->value;

                $predikatKinerja = PredikatKinerja::findOrThrowNotFound($riwayatKinerjaDto->predikat_kinerja_id);
                $riwayatKinerjaDto->predikat_kinerja_name = $predikatKinerja->name;
                $riwayatKinerjaDto->predikat_kinerja_value = $predikatKinerja->value;

                $taskDto->object = $riwayatKinerjaDto;
            }

            $task = $this->workflowService->submitTask(
                $taskDto->id,
                $taskDto->task_action,
                $taskDto->object,
                $taskDto->remark
            );

            if ($task->flow == "siap_flow_1") {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyVerifySIAPKinerja($notificationDto);
            } else if ($task->flow == "siap_flow_2") {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "siap_type" => "Riwayat kinerja"
                ];
                $this->sendNotifyService->notifyRejectRwKinerja($notificationDto, $pendingTask->object_group);
            } else {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    "siap_type" => "Riwayat kinerja"
                ];
                $this->sendNotifyService->notifyRwKinerja($notificationDto, $pendingTask->object_group);
            }

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                $riwayatKinerjaDto = new RiwayatKinerjaDto();
                $riwayatKinerjaDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "create") {
                        return $this->riwayatKinerjaService->save($riwayatKinerjaDto);
                    } else if ($task->task_type == "update") {
                        return $this->riwayatKinerjaService->update($riwayatKinerjaDto);
                    } else if ($task->task_type == "delete") {
                        return $this->riwayatKinerjaService->delete($task->objectId);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
