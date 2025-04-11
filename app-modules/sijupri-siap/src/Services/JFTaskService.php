<?php

namespace Eyegil\SijupriSiap\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Models\JenisKelamin;
use Eyegil\SijupriSiap\Dtos\JFDto;
use Eyegil\SijupriSiap\Models\JF;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\PendingTask;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JFTaskService
{
    private const workflow_name = "jf_task";

    public function __construct(
        private JFService $jfService,
        private StorageService $storageService,
        private WorkflowService $workflowService
    ) {}

    public function findWithoutKinerjaSearch(Pageable $pageable)
    {
        $userContext = user_context();
        $pageable->addEqual("unit_kerja_id", $userContext->getDetails("unit_kerja_id"));
        $pageable->addNotEqual("pendingTask|workflow_name", "rw_kinerja_task");
        $pageable->addEqual("pendingTask|flow_id", 'siap_flow_1');
        $pageable->addEqual("pendingTask|workflow_template", 'approvalSiap');
        $pageable->addEqual("pendingTask|task_status", TaskStatus::PENDING->name);
        return $pageable->with(['user'])->searchHas(JF::class, ['pendingTask']);
    }

    public function findWithKinerjaSearch(Pageable $pageable)
    {
        $pageable->addEqual("pendingTask|workflow_name", "rw_kinerja_task");
        $pageable->addEqual("pendingTask|flow_id", 'siap_flow_1');
        $pageable->addEqual("pendingTask|workflow_template", 'approvalSiap');
        $pageable->addEqual("pendingTask|task_status", TaskStatus::PENDING->name);
        return $pageable->with(['user'])->searchHas(JF::class, ['pendingTask']);
    }

    public function detail($object_group)
    {
        return PendingTask::where("object_group", $object_group)->where("task_status", TaskStatus::PENDING->name)
            ->where("flow_id", 'siap_flow_1')
            ->where('workflow_name', '!=', 'rw_kinerja_task')
            ->get();
    }

    public function kinerjaDetail($object_group)
    {
        return PendingTask::where("object_group", $object_group)->where("task_status", TaskStatus::PENDING->name)
            ->where("flow_id", 'siap_flow_1')
            ->where('workflow_name', 'rw_kinerja_task')
            ->get();
    }

    public function update(JFDto $jfDto)
    {
        $userContext = user_context();
        $jfDto->nip = $userContext->id;

        $jf = $this->jfService->findByNip($jfDto->nip);
        $jfDto_old = new JFDto();
        $jfDto_old->fromArray($jf->toArray());

        if ($jfDto->file_ktp) {
            $jfDto->ktp = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "ktp_" . Carbon::now()->format('YmdHis'), $jfDto->file_ktp);
            $jfDto->ktp_url = $this->storageService->getUrl("system", "jf", $jfDto->ktp);
            $jfDto->file_ktp = null;
        }

        $jenisKelamin = JenisKelamin::findOrThrowNotFound($jfDto->jenis_kelamin_code);
        $jfDto->jenis_kelamin_name = $jenisKelamin->name;

        $jfDto_old->jenis_kelamin_name = $jf->jenisKelamin->name;
        return $this->workflowService->startUpdateTask(
            $this::workflow_name,
            $jfDto->nip,
            $userContext->name,
            [],
            $jfDto,
            $jfDto_old,
            $userContext->id
        );
    }

    public function submit(TaskDto $taskDto)
    {
        return DB::transaction(function () use ($taskDto) {
            $pendingTask = $this->workflowService->findTaskById($taskDto->id);

            if ($taskDto->object) {
                $jfDtoOld = new JFDto();
                $jfDtoOld->fromArray((array) $pendingTask->objectTask->object);
                $jfDto = new JFDto();
                $jfDto->fromArray((array) $taskDto->object);

                if ($jfDto->file_ktp) {
                    $jfDto->ktp = $this->storageService->putObjectFromBase64WithFilename("system", "jf", "ktp_" . Carbon::now()->format('YmdHis'), $jfDto->file_ktp);
                    $jfDto->ktp_url = $this->storageService->getUrl("system", "jf", $jfDto->ktp);
                    $jfDto->file_ktp = null;
                }

                $jenisKelamin = JenisKelamin::findOrThrowNotFound($jfDto->jenis_kelamin_code);
                $jfDto->jenis_kelamin_name = $jenisKelamin->name;

                $taskDto->object = $jfDto;
            }

            $task = $this->workflowService->submitTask(
                $taskDto->id,
                $taskDto->task_action,
                $taskDto->object,
                $taskDto->remark
            );

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                $jfDto = new JFDto();
                $jfDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "update") {
                        return $this->jfService->update($jfDto);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
