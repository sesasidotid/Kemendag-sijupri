<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SijupriUkom\Dtos\ExaminerUkomDto;
use Eyegil\SijupriUkom\Models\ExaminerRoomUkom;
use Eyegil\SijupriUkom\Models\ExaminerSchedule;
use Eyegil\SijupriUkom\Models\ExaminerUkom;
use Eyegil\SijupriUkom\Models\ExaminerUkomType;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Eyegil\SijupriUkom\Models\ExamScheduleSupervised;
use Eyegil\SijupriUkom\Models\ParticipantSchedule;
use Illuminate\Support\Facades\DB;

class ExaminerUkomService
{
    public function __construct(
        private UserAuthenticationService $userAuthenticationService,
    ) {
    }

    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual("delete_flag", false);
        $pageable->addEqual("inactive_flag", false);
        return $pageable->with(['user', 'examinerTypeList'])->searchHas(ExaminerUkom::class, ['user']);
    }

    public function findById($id): ExaminerUkom
    {
        return ExaminerUkom::with("examinerTypeList")->where("id", $id)->firstOrThrowNotFound();
    }

    public function findByNip($nip)
    {
        return ExaminerUkom::with("examinerTypeList")->where('nip', $nip)->first();
    }

    public function save(ExaminerUkomDto $examinerUkomDto)
    {
        DB::transaction(function () use ($examinerUkomDto) {
            $userContext = user_context();

            if ($this->findByNip($examinerUkomDto->nip)) {
                throw new RecordExistException("canot use existing nip");
            }

            $examinerUkomDto->id = "EU-" . $examinerUkomDto->nip;
            $examinerUkomDto->role_code_list = [];
            $examinerUkomDto->application_code = 'siukom-examiner';
            $examinerUkomDto->channel_code_list = ['WEB', 'MOBILE'];
            $this->userAuthenticationService->register($examinerUkomDto);
            $examinerUkomDto->id = null;

            $examinerUkom = new ExaminerUkom();
            $examinerUkom->fromArray($examinerUkomDto->toArray());
            $examinerUkom->created_by = $userContext->id;
            $examinerUkom->user_id = "EU-" . $examinerUkomDto->nip;
            $examinerUkom->saveWithUuid();

            if (!empty($examinerUkomDto->exam_type_list)) {
                foreach ($examinerUkomDto->exam_type_list as $key => $exam_type) {
                    $examinerType = new ExaminerUkomType();
                    $examinerType->examiner_id = $examinerUkom->id;
                    $examinerType->exam_type = $exam_type;
                    $examinerType->saveWithUUid();
                }
            }

            return $examinerUkom;
        });
    }

    public function update(ExaminerUkomDto $examinerUkomDto)
    {
        DB::transaction(function () use ($examinerUkomDto) {
            $userContext = user_context();

            ExaminerUkomType::where("examiner_id", $examinerUkomDto->id)->delete();

            if (!empty($examinerUkomDto->exam_type_list)) {
                foreach ($examinerUkomDto->exam_type_list as $key => $exam_type) {
                    $examinerType = new ExaminerUkomType();
                    $examinerType->examiner_id = $examinerUkomDto->id;
                    $examinerType->exam_type = $exam_type;
                    $examinerType->saveWithUUid();
                }
            }

            $examinerUkom = $this->findById($examinerUkomDto->id);
            $examinerUkom->updated_by = $userContext->id;
            $examinerUkom->jenis_kelamin_code = $examinerUkomDto->jenis_kelamin_code;
            $examinerUkom->last_updated = now();

            $examinerUkomDto->id = "EU-" . $examinerUkom->nip;
            $this->userAuthenticationService->update($examinerUkomDto);
            $examinerUkom->save();

            ExamSchedule::whereHas("examinerScheduleList", function ($query) use ($examinerUkom) {
                $query->where("examiner_id", $examinerUkom->id);
            })->whereHas("roomUkom", function ($query) {
                $query->where("delete_flag", false)->where("inactive_flag", false);
            })->each(function (ExamSchedule $examSchedule) {
                ParticipantSchedule::where('exam_schedule_id', $examSchedule->id)->update([
                    "personal_schedule" => null
                ]);
                ExaminerSchedule::where('exam_schedule_id', $examSchedule->id)->delete();
                ExamScheduleSupervised::whereHas("participantSchedule", function ($query) use ($examSchedule) {
                    $query->where('exam_schedule_id', $examSchedule->id);
                })->delete();
            });

            return $examinerUkom;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $userContext = user_context();

            ExaminerUkomType::where("examiner_id", $id)->delete();

            $examinerUkom = $this->findById($id);
            $examinerUkom->updated_by = $userContext->id;
            $examinerUkom->delete_flag = true;
            $examinerUkom->save();

            ExamSchedule::whereHas("examinerScheduleList", function ($query) use ($examinerUkom) {
                $query->where("examiner_id", $examinerUkom->id);
            })->whereHas("roomUkom", function ($query) {
                $query->where("delete_flag", false)->where("inactive_flag", false);
            })->each(function (ExamSchedule $examSchedule) {
                ParticipantSchedule::where('exam_schedule_id', $examSchedule->id)->update([
                    "personal_schedule" => null
                ]);
                ExaminerSchedule::where('exam_schedule_id', $examSchedule->id)->delete();
                ExamScheduleSupervised::whereHas("participantSchedule", function ($query) use ($examSchedule) {
                    $query->where('exam_schedule_id', $examSchedule->id);
                })->delete();
            });

            ExaminerRoomUkom::where("examiner_id", $id)->delete();

            return $examinerUkom;
        });
    }

    public function findByRoomId($room_id)
    {
        return ExaminerRoomUkom::with(["examinerUkom.user", "examinerUkom.examinerTypeList"])->where("room_id", $room_id)
            ->where("inactive_flag", false)
            ->where("delete_flag", false)
            ->get();
    }
}
