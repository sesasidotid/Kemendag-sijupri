<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\Base\UserContext;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Services\ParticipantUkomTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Models\PendingTask;
use Illuminate\Http\Request;

#[Controller("/api/v1/participant_ukom/task")]
class ParticipantUkomTaskController
{
    public function __construct(
        private ParticipantUkomTaskService $participantUkomTaskService,
    ) {
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $query = $request->query();
        unset($query['eq_jenis_ukom']);
        unset($query['like_jabatan_name']);
        unset($query['like_next_jabatan_name']);
        unset($query['eq_jabatan_name']);
        unset($query['eq_next_jabatan_name']);
        unset($query['like_jenjang_name']);
        unset($query['like_next_jenjang_name']);
        unset($query['eq_jenjang_name']);
        unset($query['eq_next_jenjang_name']);
        unset($query['eq_next_jabatan_code']);
        unset($query['eq_next_jenjang_code']);
        unset($query['eq_jenis_ukom']);
        unset($query['like_nip']);

        $pendingTaskSearch = $this->participantUkomTaskService->findSearch(new Pageable($query), $request->query());
        return $pendingTaskSearch->setCollection($pendingTaskSearch->getCollection()->map(function (PendingTask $pendingTask) {
            $pendingTaskArray = $pendingTask->toArray();
            $objectTask = $pendingTask->objectTask;
            if ($objectTask) {
                $object = (object) $objectTask->object;
                $pendingTaskArray['jenis_ukom'] = optional($object)->jenis_ukom ?? null;
                $pendingTaskArray['jabatan_name'] = optional($object)->jabatan_name ?? null;
                $pendingTaskArray['next_jabatan_name'] = optional($object)->next_jabatan_name ?? null;
                $pendingTaskArray['jenjang_name'] = optional($object)->jenjang_name ?? null;
                $pendingTaskArray['next_jenjang_name'] = optional($object)->next_jenjang_name ?? null;
            }
            return $pendingTaskArray;
        }));
    }

    #[Get("/failed/search")]
    public function findFailedSearch(Request $request)
    {
        $query = $request->query();
        unset($query['eq_jenis_ukom']);
        unset($query['like_jabatan_name']);
        unset($query['like_next_jabatan_name']);
        unset($query['eq_jabatan_name']);
        unset($query['eq_next_jabatan_name']);
        unset($query['like_jenjang_name']);
        unset($query['like_next_jenjang_name']);
        unset($query['eq_jenjang_name']);
        unset($query['eq_next_jenjang_name']);
        unset($query['eq_next_jabatan_code']);
        unset($query['eq_next_jenjang_code']);
        unset($query['eq_jenis_ukom']);
        unset($query['like_nip']);
        unset($query['like_name']);

        $pendingTaskSearch = $this->participantUkomTaskService->findFailedSearch(new Pageable($query), $request->query());
        return $pendingTaskSearch->setCollection($pendingTaskSearch->getCollection()->map(function (PendingTask $pendingTask) {
            $pendingTaskArray = $pendingTask->toArray();
            $objectTask = $pendingTask->objectTask;
            if ($objectTask) {
                $object = (object) $objectTask->object;
                $pendingTaskArray['jenis_ukom'] = optional($object)->jenis_ukom ?? null;
                $pendingTaskArray['jabatan_name'] = optional($object)->jabatan_name ?? null;
                $pendingTaskArray['next_jabatan_name'] = optional($object)->next_jabatan_name ?? null;
                $pendingTaskArray['jenjang_name'] = optional($object)->jenjang_name ?? null;
                $pendingTaskArray['next_jenjang_name'] = optional($object)->next_jenjang_name ?? null;
            }
            return $pendingTaskArray;
        }));
    }

    #[Get("/{pending_task_id}")]
    public function getDetailTask($pending_task_id)
    {
        return $this->participantUkomTaskService->getDetailTask($pending_task_id);
    }

    #[Get("/check_eligible/{jenis_ukom}/{nip}")]
    public function checkEligible($jenis_ukom, $nip)
    {
        return $this->participantUkomTaskService->checkEligible($nip, $jenis_ukom);
    }

    #[Get("/nip/{nip}")]
    public function findByNip($nip)
    {
        PendingTask::where("object_group", $nip)->firstOrThrowNotFound();
        return $this->participantUkomTaskService->findByNip($nip);
    }

    #[Post()]
    public function create(Request $request)
    {
        $userContext = new UserContext();
        $userContext->id = "non-user";
        $request->attributes->set("user_context", $userContext);

        $participantUkomDto = ParticipantUkomDto::fromRequest($request)->validateSaveParticipant();
        return $this->participantUkomTaskService->create($participantUkomDto);
    }

    #[Post("/jf")]
    public function createWithJf(Request $request)
    {
        $participantUkomDto = ParticipantUkomDto::fromRequest($request)->validateSaveWithJF();
        return $this->participantUkomTaskService->createWithJf($participantUkomDto);
    }

    #[Post("/non_jf/submit")]
    public function nonJfSubmit(Request $request)
    {
        $query = $request->query();
        $taskDto = TaskDto::fromRequest($request);
        return $this->participantUkomTaskService->nonJfSubmit($taskDto, $query['key']);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        return $this->participantUkomTaskService->submit($taskDto);
    }

    #[Post("/submit/all")]
    public function submitAll(Request $request)
    {
        return $this->participantUkomTaskService->submitAll();
    }

    #[Post("/failed_to_completed")]
    public function failedToCompleted(Request $request)
    {
        return $this->participantUkomTaskService->failedToCompleted($request->id);
    }
}
