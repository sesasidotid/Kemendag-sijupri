<?php

namespace Eyegil\SijupriUkom\Services;

use App\Enums\NotificationTemplateCode;
use App\Services\SendNotifyService;
use Eyegil\Base\Exceptions\BusinessException;
use Carbon\Carbon;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Eyegil\SijupriUkom\Dtos\ExamScheduleCatDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleDto;
use Eyegil\SijupriUkom\Dtos\ExamSchedulePortofolioDto;
use Eyegil\SijupriUkom\Dtos\ExamSchedulePraktikDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleSeminarMakalahDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleStudiKasusDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleUpdateDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleWawancaraDto;
use Eyegil\SijupriUkom\Dtos\RoomUkomDto;
use Eyegil\SijupriUkom\Dtos\UpdateAssignerExaminer;
use Eyegil\SijupriUkom\Dtos\UpdateAssignerParticipant;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Models\ExamConfiguration;
use Eyegil\SijupriUkom\Models\ExamGrade;
use Eyegil\SijupriUkom\Models\ExaminerRoomUkom;
use Eyegil\SijupriUkom\Models\ExaminerSchedule;
use Eyegil\SijupriUkom\Models\ExaminerUkom;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Eyegil\SijupriUkom\Models\ExamScheduleSupervised;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\SijupriUkom\Models\ParticipantSchedule;
use Eyegil\SijupriUkom\Models\RoomUkom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ExamScheduleService
{

    private $inmemoryCacheScheduleSysConf = [];

    public function __construct(
        private SendNotifyService $sendNotifyService,
        private ExamGradeService $examGradeService
    ) {
    }

    public function calendar(array $queryParams)
    {
        $query = ParticipantSchedule::with(['examSchedule.roomUkom', 'participantUkom.user', 'examScheduleSupervised.examinerSchedule.examinerUkom.user']);

        if (isset($queryParams['participant_id'])) {
            $query->where('participant_id', $queryParams['participant_id']);
        }

        if (isset($queryParams['start_date']) && isset($queryParams['end_date'])) {
            $startDate = Carbon::parse($queryParams['start_date'])->startOfDay();
            $endDate = Carbon::parse($queryParams['end_date'])->endOfDay();
            $query->whereHas('examSchedule', function ($q) use ($startDate, $endDate) {
                $q->where('start_time', '>=', $startDate)
                    ->where('end_time', '<=', $endDate);
            });
        }

        return $query->get();
    }

    public function findAllByRoomUkomId($room_ukom_id)
    {
        return ExamSchedule::with("examScheduleChild")
            ->where('room_ukom_id', $room_ukom_id)
            ->where("exam_schedule_parent_id", null)
            ->get()->map(function (ExamSchedule $examSchedule) use ($room_ukom_id) {
                $examiners = ExamScheduleSupervised::with([
                    "examinerSchedule.examinerUkom",
                    "examinerSchedule.examSchedule"
                ])
                    ->whereHas("examinerSchedule.examSchedule", function ($query) use ($examSchedule, $room_ukom_id) {
                        $query->where("exam_schedule_id", $examSchedule->id)
                            ->where("room_ukom_id", $room_ukom_id);
                    })
                    ->get()
                    ->unique(fn($item) => optional($item->examinerSchedule->examinerUkom)->id);

                $examSchedule->examiners = $examiners
                    ->map(fn($item) => optional($item->examinerSchedule->examinerUkom)->id)
                    ->filter()
                    ->implode(',');

                $examSchedule->examiner_names = $examiners
                    ->map(fn($item) => optional($item->examinerSchedule->examinerUkom)->name)
                    ->filter()
                    ->implode(',');


                $examScheduleChild = $examSchedule->examScheduleChild;
                if ($examScheduleChild) {
                    $examiners = ExamScheduleSupervised::with([
                        "examinerSchedule.examinerUkom",
                        "examinerSchedule.examSchedule"
                    ])
                        ->whereHas("examinerSchedule.examSchedule", function ($query) use ($examScheduleChild, $room_ukom_id) {
                            $query->where("exam_schedule_id", $examScheduleChild->id)
                                ->where("room_ukom_id", $room_ukom_id);
                        })
                        ->get()
                        ->unique(fn($item) => optional($item->examinerSchedule->examinerUkom)->id);

                    $examScheduleChild->examiners = $examiners
                        ->map(fn($item) => optional($item->examinerSchedule->examinerUkom)->id)
                        ->filter()
                        ->implode(',');

                    $examScheduleChild->examiner_names = $examiners
                        ->map(fn($item) => optional($item->examinerSchedule->examinerUkom)->name)
                        ->filter()
                        ->implode(',');
                }

                return $examSchedule;
            });
    }

    public function findById($id)
    {
        return ExamSchedule::with("examScheduleChild")->findOrThrowNotFound($id);
    }

    public function findByParticipantId($participant_id)
    {
        return ExamSchedule::whereHas('participantScheduleList', function ($query) use ($participant_id) {
            $query->where('participant_id', $participant_id);
        })->get();
    }

    public function replace(RoomUkomDto $roomUkomDto)
    {
        DB::transaction(function () use ($roomUkomDto) {
            $userContext = user_context();
            $this->deleteAllByRoomUkomId($roomUkomDto->id);

            $childObjectMapList = [];
            foreach ($roomUkomDto->exam_schedule_dto_list as $key => $exam_schedule_dto) {
                $examScheduleDto = (new ExamScheduleDto())->fromArray((array) $exam_schedule_dto)->validateSave();

                $examSchedule = new ExamSchedule();
                $examSchedule->fromArray($examScheduleDto->toArray());
                $start_time = Carbon::parse($examScheduleDto->start_time);
                $end_time = Carbon::parse($examScheduleDto->end_time);

                if (!$examScheduleDto->duration) {
                    $examSchedule->duration = $start_time->diffInHours($end_time);
                }
                $examSchedule->created_by = $userContext->id;
                $examSchedule->room_ukom_id = $roomUkomDto->id;
                $examSchedule->start_time = $start_time;
                $examSchedule->end_time = $end_time;
                $examSchedule->saveWithUuid();

                $childObjectMapList[] = [
                    "exam_type" => Str::camel($examScheduleDto->exam_type_code),
                    "start_time" => $start_time->toDateTimeString(),
                    "end_time" => $end_time->toDateTimeString()
                ];
            }

            $participantRoomUkomList = ParticipantRoomUkom::where('room_id', $roomUkomDto->id)->get();
            if ($participantRoomUkomList->isEmpty()) {
                return;
            }

            try {
                $notificationDto = new NotificationDto();
                $notificationDto->objectMap = [
                    NotificationTemplateCode::NOTIFY_UKOM_SCHEDULE->value => $childObjectMapList
                ];
                $this->sendNotifyService->sendEmailExamSchedule(
                    $notificationDto,
                    $participantRoomUkomList->pluck('participantUkom.email')->filter()->values()->all()
                );
            } catch (\Throwable $ignored) {
                Log::error('Failed to send exam schedule notification', [
                    'room_ukom_id' => $roomUkomDto->id,
                    'error' => $ignored->getTrace()
                ]);
            }

        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $examSchedule = $this->findById($id);
            if (Carbon::now()->isAfter(Carbon::parse($examSchedule->end_time))) {
                throw new BusinessException("cannot delete this record", "");
            }

            $examScheduleChild = $examSchedule->examScheduleChild;
            if ($examScheduleChild) {
                ExamConfiguration::where('exam_schedule_id', $examScheduleChild->id)->delete();
                ExamScheduleSupervised::whereHas("participantSchedule", function ($query) use ($examScheduleChild) {
                    $query->where('exam_schedule_id', $examScheduleChild->id);
                })->delete();
                ParticipantSchedule::where('exam_schedule_id', $examScheduleChild->id)->delete();
                ExaminerSchedule::where('exam_schedule_id', $examScheduleChild->id)->delete();
                ExamGrade::where('exam_schedule_id', $examScheduleChild->id)->each(function (ExamGrade $examGrade) {
                    $this->examGradeService->delete($examGrade->id);
                });
                $examScheduleChild->delete();
            }

            ExamConfiguration::where('exam_schedule_id', $examSchedule->id)->delete();
            ExamScheduleSupervised::whereHas("participantSchedule", function ($query) use ($examSchedule) {
                $query->where('exam_schedule_id', $examSchedule->id);
            })->delete();
            ParticipantSchedule::where('exam_schedule_id', $examSchedule->id)->delete();
            ExaminerSchedule::where('exam_schedule_id', $examSchedule->id)->delete();
            ExamGrade::where('exam_schedule_id', $examSchedule->id)->each(function (ExamGrade $examGrade) {
                $this->examGradeService->delete($examGrade->id);
            });
            $examSchedule->delete();
        });
    }

    public function deleteAllByRoomUkomId($room_ukom_id)
    {
        DB::transaction(function () use ($room_ukom_id) {
            ExamSchedule::where('room_ukom_id', $room_ukom_id)->delete();
        });
    }

    //-----------------------------------------------

    public function findDetailById($id)
    {
        return ExamSchedule::with("examScheduleChild")->where("id", $id)->firstOrThrowNotFound();
    }

    public function findParticipantScheduleByExamScheduleId($exam_schedule_id)
    {
        return ParticipantSchedule::with(["participantUkom.user", "examScheduleSupervised"])->where("exam_schedule_id", $exam_schedule_id)->get();
    }

    public function findExaminerScheduleByExamScheduleId($exam_schedule_id)
    {
        return ExaminerSchedule::with("examinerUkom.user")->where("exam_schedule_id", $exam_schedule_id)->get();
    }

    public function findByExaminerId($examiner_id)
    {
        return ExamSchedule::with([
            'roomUkom',
            'participantScheduleList' => function ($query) use ($examiner_id) {
                $query->where(function ($q) use ($examiner_id) {
                    $q->whereHas(
                        'examScheduleSupervised.examinerSchedule',
                        function ($qq) use ($examiner_id) {
                            $qq->where('examiner_id', $examiner_id);
                        }
                    );
                })->whereDoesntHave('participantUkom.examGradeList', function ($q) {
                    $q->whereColumn(
                        'ukm_exam_grade.exam_schedule_id',
                        'ukm_participant_schedule.exam_schedule_id'
                    );
                })->with('participantUkom');
            },
        ])
            ->whereHas('examinerScheduleList', function ($query) use ($examiner_id) {
                $query->whereHas("examScheduleSupervised")
                    ->where('examiner_id', $examiner_id);
            })
            ->whereHas('participantScheduleList')
            ->get();
    }

    public function updateAssignedExaminerSchedule(UpdateAssignerExaminer $updateAssignerExaminer)
    {
        return DB::transaction(function () use ($updateAssignerExaminer) {
            ExamScheduleSupervised::where("participant_schedule_id", $updateAssignerExaminer->participant_schedule_id)->delete();
            $participantSchedule = ParticipantSchedule::find($updateAssignerExaminer->participant_schedule_id);
            $examSchedule = $participantSchedule->examSchedule;

            foreach ($updateAssignerExaminer->examiner_schedule_id_list as $key => $examinerScheduleId) {
                $examinerSchedule = ExaminerSchedule::find($examinerScheduleId);

                if (!in_array($examSchedule->exam_type_code, [ExamTypes::STUDI_KASUS->name, ExamTypes::PORTOFOLIO])) {
                    if ($this->isExaminerBusy($examinerSchedule->examiner_id, Carbon::parse($participantSchedule->personal_schedule), Carbon::parse($participantSchedule->personal_schedule_end))) {
                        throw new RecordExistException("examiner with id $examinerScheduleId is buzy");
                    }
                }

                $examScheduleSupervised = new ExamScheduleSupervised();
                $examScheduleSupervised->participant_schedule_id = $updateAssignerExaminer->participant_schedule_id;
                $examScheduleSupervised->examiner_schedule_id = $examinerScheduleId;
                $examScheduleSupervised->saveWithUUid();
            }
        });
    }

    public function updateAssignerParticipantSchedule(UpdateAssignerParticipant $updateAssignerParticipant)
    {
        $data = DB::transaction(function () use ($updateAssignerParticipant) {
            $participantSchedule = ParticipantSchedule::find($updateAssignerParticipant->participant_schedule_id);
            $examSchedule = $participantSchedule->examSchedule;

            $schedule = Carbon::parse($updateAssignerParticipant->personal_schedule);
            $scheduleEnd = $schedule->copy()->addHours((float) $examSchedule->duration);

            $isExist = $this->isParticipantBusy($participantSchedule->participant_id, $schedule, $scheduleEnd);

            if ($isExist) {
                throw new RecordExistException("participants with id $participantSchedule->participant_id is buzy");
            }

            $participantSchedule->personal_schedule = $schedule;
            $participantSchedule->personal_schedule_end = $scheduleEnd;
            $participantSchedule->save();

            return [
                "participantSchedule" => $participantSchedule,
                "schedule" => $schedule,
                "scheduleEnd" => $scheduleEnd,
            ];
        });

        DB::transaction(function () use ($data) {
            $examScheduleSupervised = $data["participantSchedule"]->examScheduleSupervised;

            if ($examScheduleSupervised) {
                $examinerSchedule = $examScheduleSupervised->examinerSchedule;
                if ($examinerSchedule) {
                    if ($this->isExaminerBusy($examinerSchedule->examiner_id, $data["schedule"], $data["scheduleEnd"], $examScheduleSupervised->id)) {
                        $examScheduleSupervised->delete();
                    }
                }
            }
        });
    }

    public function saveCat(ExamScheduleCatDto $examScheduleCatDto)
    {
        return DB::transaction(function () use ($examScheduleCatDto) {
            $userContext = user_context();

            $examSchedule = new ExamSchedule();
            $examSchedule->fromArray($examScheduleCatDto->toArray());
            $start_time = Carbon::parse($examScheduleCatDto->start_time);
            $end_time = Carbon::parse($examScheduleCatDto->end_time);
            $examSchedule->duration = $examScheduleCatDto->duration;

            $examSchedule->created_by = $userContext->id;
            $examSchedule->room_ukom_id = $examScheduleCatDto->room_ukom_id;
            $examSchedule->start_time = $start_time;
            $examSchedule->end_time = $end_time;
            $examSchedule->exam_type_code = ExamTypes::CAT->value;
            $examSchedule->saveWithUuid();

            $examConfiguration = new ExamConfiguration();
            $examConfiguration->exam_schedule_id = $examSchedule->id;
            $examConfiguration->created_by = $userContext->id;
            $examConfiguration->saveWithUuid();

            if (empty($examScheduleCatDto->participant_id_list)) {
                $participantRoomUkomList = ParticipantRoomUkom::where("room_id", $examScheduleCatDto->room_ukom_id)->get();
                if ($participantRoomUkomList->isEmpty()) {
                    throw new RecordNotFoundException("participant not exist in a room");
                }

                foreach ($participantRoomUkomList as $key => $participantRoomUkom) {
                    $participantSchedule = new ParticipantSchedule();
                    $participantSchedule->participant_id = $participantRoomUkom->participant_id;
                    $participantSchedule->exam_schedule_id = $examSchedule->id;
                    $participantSchedule->saveWithUUid();
                }
            } else {
                foreach ($examScheduleCatDto->participant_id_list as $key => $participantId) {
                    $participantSchedule = new ParticipantSchedule();
                    $participantSchedule->participant_id = $participantId;
                    $participantSchedule->exam_schedule_id = $examSchedule->id;
                    $participantSchedule->saveWithUUid();
                }
            }
        });
    }

    public function saveSeminarMakalah(ExamScheduleSeminarMakalahDto $examScheduleSeminarMakalahDto)
    {
        return DB::transaction(function () use ($examScheduleSeminarMakalahDto) {
            $userContext = user_context();

            $participantIdList = null;
            if (empty($examScheduleSeminarMakalahDto->participant_id_list)) {
                $participantIdList = ParticipantRoomUkom::where('room_id', $examScheduleSeminarMakalahDto->room_ukom_id)
                    ->pluck('participant_id')->values()->toArray();

                if (empty($participantIdList)) {
                    throw new RecordNotFoundException("participant not exist in a room");
                }
            } else {
                $participantIdList = $examScheduleSeminarMakalahDto->participant_id_list;
            }

            $examScheduleMakalah = new ExamSchedule();
            $examScheduleMakalah->fromArray($examScheduleSeminarMakalahDto->toArray());
            $start_time = Carbon::parse($examScheduleSeminarMakalahDto->makalah_start_time);
            $end_time = Carbon::parse($examScheduleSeminarMakalahDto->makalah_end_time);
            $examScheduleMakalah->duration = $start_time->diffInHours($end_time);

            $examScheduleMakalah->created_by = $userContext->id;
            $examScheduleMakalah->room_ukom_id = $examScheduleSeminarMakalahDto->room_ukom_id;
            $examScheduleMakalah->start_time = $start_time;
            $examScheduleMakalah->end_time = $end_time;
            $examScheduleMakalah->exam_type_code = ExamTypes::MAKALAH->value;
            $examScheduleMakalah->saveWithUuid();

            $examScheduleSeminar = new ExamSchedule();
            $examScheduleSeminar->fromArray($examScheduleSeminarMakalahDto->toArray());
            $start_time = Carbon::parse($examScheduleSeminarMakalahDto->seminar_start_time);
            $end_time = Carbon::parse($examScheduleSeminarMakalahDto->seminar_end_time);

            $examScheduleSeminar->created_by = $userContext->id;
            $examScheduleSeminar->room_ukom_id = $examScheduleSeminarMakalahDto->room_ukom_id;
            $examScheduleSeminar->start_time = $start_time;
            $examScheduleSeminar->end_time = $end_time;
            $examScheduleSeminar->duration = $examScheduleSeminarMakalahDto->duration;
            $examScheduleSeminar->exam_type_code = ExamTypes::SEMINAR->value;
            $examScheduleSeminar->exam_schedule_parent_id = $examScheduleMakalah->id;
            $examScheduleSeminar->saveWithUuid();

            $schedules = $this->generatePersonalSchedules($start_time, $end_time, $examScheduleSeminar->duration, count($participantIdList));
            foreach ($participantIdList as $key => $participantId) {
                $isParticipantExist = ParticipantSchedule::with("participantUkom")
                    ->where("participant_id", $participantId)
                    ->whereHas("examSchedule", function ($query) {
                        $query->where("exam_type_code", ExamTypes::MAKALAH->value);
                    })->first();
                if ($isParticipantExist) {
                    throw new RecordExistException("participant already have a shcedule", [
                        "nip" => $isParticipantExist->participantUkom->nip,
                        "name" => $isParticipantExist->participantUkom->name
                    ]);
                }

                // Makalah schedule
                $participantScheduleMakalah = new ParticipantSchedule();
                $participantScheduleMakalah->participant_id = $participantId;
                $participantScheduleMakalah->exam_schedule_id = $examScheduleMakalah->id;
                $participantScheduleMakalah->saveWithUUid();

                // Seminar schedule
                $participantScheduleSeminar = new ParticipantSchedule();
                $participantScheduleSeminar->participant_id = $participantId;
                $participantScheduleSeminar->exam_schedule_id = $examScheduleSeminar->id;
                $participantScheduleSeminar->saveWithUUid();
            }
        });
    }

    public function saveWawancara(ExamScheduleWawancaraDto $examScheduleWawancaraDto)
    {
        return DB::transaction(function () use ($examScheduleWawancaraDto) {
            $userContext = user_context();

            $examSchedule = new ExamSchedule();
            $examSchedule->fromArray($examScheduleWawancaraDto->toArray());
            $start_time = Carbon::parse($examScheduleWawancaraDto->start_time);
            $end_time = Carbon::parse($examScheduleWawancaraDto->end_time);

            $participantIdList = null;
            if (empty($examScheduleWawancaraDto->participant_id_list)) {
                $participantIdList = ParticipantRoomUkom::where('room_id', $examScheduleWawancaraDto->room_ukom_id)
                    ->pluck('participant_id')->values()->toArray();

                if (empty($participantIdList)) {
                    throw new RecordNotFoundException("participant not exist in a room");
                }
            } else {
                $participantIdList = $examScheduleWawancaraDto->participant_id_list;
            }

            $examSchedule->created_by = $userContext->id;
            $examSchedule->room_ukom_id = $examScheduleWawancaraDto->room_ukom_id;
            $examSchedule->start_time = $start_time;
            $examSchedule->end_time = $end_time;
            $examSchedule->exam_type_code = ExamTypes::WAWANCARA->value;
            $examSchedule->saveWithUuid();

            $this->generatePersonalSchedules($start_time, $end_time, $examSchedule->duration, count($participantIdList));
            foreach ($participantIdList as $participantId) {
                $isParticipantExist = ParticipantSchedule::with("participantUkom")
                    ->where("participant_id", $participantId)
                    ->whereHas("examSchedule", function ($query) {
                        $query->where("exam_type_code", ExamTypes::WAWANCARA->value);
                    })->first();
                if ($isParticipantExist) {
                    throw new RecordExistException("participant already have a shcedule", [
                        "nip" => $isParticipantExist->participantUkom->nip,
                        "name" => $isParticipantExist->participantUkom->name
                    ]);
                }

                $participantSchedule = new ParticipantSchedule();
                $participantSchedule->participant_id = $participantId;
                $participantSchedule->exam_schedule_id = $examSchedule->id;
                $participantSchedule->saveWithUUid();
            }
        });
    }

    public function savePraktik(ExamSchedulePraktikDto $examSchedulePraktikDto)
    {
        return DB::transaction(function () use ($examSchedulePraktikDto) {
            $userContext = user_context();

            $examSchedule = new ExamSchedule();
            $examSchedule->fromArray($examSchedulePraktikDto->toArray());
            $start_time = Carbon::parse($examSchedulePraktikDto->start_time);
            $end_time = Carbon::parse($examSchedulePraktikDto->end_time);

            $examSchedule->created_by = $userContext->id;
            $examSchedule->room_ukom_id = $examSchedulePraktikDto->room_ukom_id;
            $examSchedule->start_time = $start_time;
            $examSchedule->end_time = $end_time;
            $examSchedule->exam_type_code = ExamTypes::PRAKTIK->value;
            $examSchedule->saveWithUuid();

            $participantIdList = null;
            if (empty($examSchedulePraktikDto->participant_id_list)) {
                $participantIdList = ParticipantRoomUkom::where('room_id', $examSchedulePraktikDto->room_ukom_id)
                    ->pluck('participant_id')->values()->toArray();

                if (empty($participantIdList)) {
                    throw new RecordNotFoundException("participant not exist in a room");
                }
            } else {
                $participantIdList = $examSchedulePraktikDto->participant_id_list;
            }

            $this->generatePersonalSchedules($start_time, $end_time, $examSchedule->duration, count($participantIdList));
            foreach ($participantIdList as $participantId) {
                $isParticipantExist = ParticipantSchedule::with("participantUkom")
                    ->where("participant_id", $participantId)
                    ->whereHas("examSchedule", function ($query) {
                        $query->where("exam_type_code", ExamTypes::PRAKTIK->value);
                    })->first();
                if ($isParticipantExist) {
                    throw new RecordExistException("participant already have a shcedule", [
                        "nip" => $isParticipantExist->participantUkom->nip,
                        "name" => $isParticipantExist->participantUkom->name
                    ]);
                }

                $participantSchedule = new ParticipantSchedule();
                $participantSchedule->participant_id = $participantId;
                $participantSchedule->exam_schedule_id = $examSchedule->id;
                $participantSchedule->saveWithUUid();
            }
        });
    }

    public function savePortofolio(ExamSchedulePortofolioDto $examSchedulePortofolioDto)
    {
        return DB::transaction(function () use ($examSchedulePortofolioDto) {
            $userContext = user_context();

            $examSchedule = new ExamSchedule();
            $examSchedule->fromArray($examSchedulePortofolioDto->toArray());
            $start_time = Carbon::parse($examSchedulePortofolioDto->start_time);
            $end_time = Carbon::parse($examSchedulePortofolioDto->end_time);
            $examSchedule->duration = $start_time->diffInHours($end_time);

            $examSchedule->created_by = $userContext->id;
            $examSchedule->room_ukom_id = $examSchedulePortofolioDto->room_ukom_id;
            $examSchedule->start_time = $start_time;
            $examSchedule->end_time = $end_time;
            $examSchedule->exam_type_code = ExamTypes::PORTOFOLIO->value;
            $examSchedule->saveWithUuid();

            if (empty($examSchedulePortofolioDto->participant_id_list)) {
                $participantRoomUkomList = ParticipantRoomUkom::where("room_id", $examSchedulePortofolioDto->room_ukom_id)->get();
                if ($participantRoomUkomList->isEmpty()) {
                    throw new RecordNotFoundException("participant not exist in a room");
                }

                foreach ($participantRoomUkomList as $key => $participantRoomUkom) {
                    $isParticipantExist = ParticipantSchedule::with("participantUkom")
                        ->where("participant_id", $participantRoomUkom->participant_id)
                        ->whereHas("examSchedule", function ($query) {
                            $query->where("exam_type_code", ExamTypes::PORTOFOLIO->value);
                        })->first();
                    if ($isParticipantExist) {
                        throw new RecordExistException("participant already have a shcedule", [
                            "nip" => $isParticipantExist->participantUkom->nip,
                            "name" => $isParticipantExist->participantUkom->name
                        ]);
                    }

                    $participantSchedule = new ParticipantSchedule();
                    $participantSchedule->participant_id = $participantRoomUkom->participant_id;
                    $participantSchedule->exam_schedule_id = $examSchedule->id;
                    $participantSchedule->saveWithUUid();
                }
            } else {
                foreach ($examSchedulePortofolioDto->participant_id_list as $key => $participantId) {
                    $isParticipantExist = ParticipantSchedule::with("participantUkom")
                        ->where("participant_id", $participantId)
                        ->whereHas("examSchedule", function ($query) {
                            $query->where("exam_type_code", ExamTypes::PORTOFOLIO->value);
                        })->first();
                    if ($isParticipantExist) {
                        throw new RecordExistException("participant already have a shcedule", [
                            "nip" => $isParticipantExist->participantUkom->nip,
                            "name" => $isParticipantExist->participantUkom->name
                        ]);
                    }

                    $participantSchedule = new ParticipantSchedule();
                    $participantSchedule->participant_id = $participantId;
                    $participantSchedule->exam_schedule_id = $examSchedule->id;
                    $participantSchedule->saveWithUUid();
                }
            }
        });
    }

    public function saveStudiKasus(ExamScheduleStudiKasusDto $examScheduleStudiKasusDto)
    {
        return DB::transaction(function () use ($examScheduleStudiKasusDto) {
            $userContext = user_context();

            $examSchedule = new ExamSchedule();
            $examSchedule->fromArray($examScheduleStudiKasusDto->toArray());
            $start_time = Carbon::parse($examScheduleStudiKasusDto->start_time);
            $end_time = Carbon::parse($examScheduleStudiKasusDto->end_time);
            $examSchedule->duration = $start_time->diffInHours($end_time);

            $examSchedule->created_by = $userContext->id;
            $examSchedule->room_ukom_id = $examScheduleStudiKasusDto->room_ukom_id;
            $examSchedule->start_time = $start_time;
            $examSchedule->end_time = $end_time;
            $examSchedule->exam_type_code = ExamTypes::STUDI_KASUS->value;
            $examSchedule->saveWithUuid();


            if (empty($examScheduleStudiKasusDto->participant_id_list)) {
                $participantRoomUkomList = ParticipantRoomUkom::where("room_id", $examScheduleStudiKasusDto->room_ukom_id)->get();
                if ($participantRoomUkomList->isEmpty()) {
                    throw new RecordNotFoundException("participant not exist in a room");
                }

                foreach ($participantRoomUkomList as $key => $participantRoomUkom) {
                    $isParticipantExist = ParticipantSchedule::with("participantUkom")
                        ->where("participant_id", $participantRoomUkom->participant_id)
                        ->whereHas("examSchedule", function ($query) {
                            $query->where("exam_type_code", ExamTypes::STUDI_KASUS->value);
                        })->first();
                    if ($isParticipantExist) {
                        throw new RecordExistException("participant already have a shcedule", [
                            "nip" => $isParticipantExist->participantUkom->nip,
                            "name" => $isParticipantExist->participantUkom->name
                        ]);
                    }

                    $participantSchedule = new ParticipantSchedule();
                    $participantSchedule->participant_id = $participantRoomUkom->participant_id;
                    $participantSchedule->exam_schedule_id = $examSchedule->id;
                    $participantSchedule->saveWithUUid();
                }
            } else {
                foreach ($examScheduleStudiKasusDto->participant_id_list as $key => $participantId) {
                    $isParticipantExist = ParticipantSchedule::with("participantUkom")
                        ->where("participant_id", $participantId)
                        ->whereHas("examSchedule", function ($query) {
                            $query->where("exam_type_code", ExamTypes::STUDI_KASUS->value);
                        })->first();
                    if ($isParticipantExist) {
                        throw new RecordExistException("participant already have a shcedule", [
                            "nip" => $isParticipantExist->participantUkom->nip,
                            "name" => $isParticipantExist->participantUkom->name
                        ]);
                    }

                    $participantSchedule = new ParticipantSchedule();
                    $participantSchedule->participant_id = $participantId;
                    $participantSchedule->exam_schedule_id = $examSchedule->id;
                    $participantSchedule->saveWithUUid();
                }
            }
        });
    }

    public function update(ExamScheduleUpdateDto $examScheduleUpdateDto)
    {
        return DB::transaction(function () use ($examScheduleUpdateDto) {
            $userContext = user_context();

            $examSchedule = $this->findById($examScheduleUpdateDto->id);
            $start_time = Carbon::parse($examScheduleUpdateDto->start_time);
            $end_time = Carbon::parse($examScheduleUpdateDto->end_time);
            if (Carbon::now()->isAfter($end_time)) {
                throw new BusinessException("cannot update this record", "");
            }

            if (!$examScheduleUpdateDto->duration) {
                $examSchedule->duration = $start_time->diffInHours($end_time);
            } else {
                $examSchedule->duration = $examScheduleUpdateDto->duration;
            }

            $examSchedule->secret_key = $examScheduleUpdateDto->secret_key;
            $examSchedule->start_time = $start_time;
            $examSchedule->end_time = $end_time;
            $examSchedule->save();

            ParticipantSchedule::where('exam_schedule_id', $examSchedule->id)->update([
                "personal_schedule" => null
            ]);
            ExaminerSchedule::where('exam_schedule_id', $examSchedule->id)->delete();
            ExamScheduleSupervised::whereHas("participantSchedule", function ($query) use ($examSchedule) {
                $query->where('exam_schedule_id', $examSchedule->id);
            })->delete();
        });
    }

    private function updateSchedule(ExamSchedule $examSchedule)
    {
        DB::transaction(function () use ($examSchedule) {
            $participantScheduleList = $examSchedule->participantScheduleList;
            $schedules = $this->generatePersonalSchedules(Carbon::parse($examSchedule->start_time), Carbon::parse($examSchedule->end_time), $examSchedule->duration, count($participantScheduleList));


            foreach ($participantScheduleList as $key => $participantSchedule) {
                $schedule = null;
                $scheduleEnd = null;
                for ($i = 0; $i < count($schedules); $i++) {
                    $schedule = $schedules[$i];
                    $scheduleEnd = $schedule->copy()->addHours((float) $examSchedule->duration);

                    $isExist = ParticipantSchedule::where("participant_id", $participantSchedule->participant_id)
                        ->where(function ($query) use ($schedule, $scheduleEnd) {
                            $query->whereBetween("personal_schedule", [$schedule, $scheduleEnd])
                                ->whereBetween("personal_schedule_end", [$schedule, $scheduleEnd]);
                        })->exists();

                    if (!$isExist) {
                        unset($schedules[$i]);
                        $schedules = array_values($schedules);
                        break;
                    }
                }

                $participantSchedule->personal_schedule = $schedule;
                $participantSchedule->save();
            }
        });
    }

    public function generateSchedule()
    {
        $roomList = RoomUkom::with([
            "examScheduleList" => function ($query) {
                $query->whereIn("exam_type_code", [
                    ExamTypes::PRAKTIK->value,
                    ExamTypes::MAKALAH->value,
                    ExamTypes::WAWANCARA->value,
                    ExamTypes::STUDI_KASUS->value,
                    ExamTypes::PORTOFOLIO->value
                ]);
            },
            "examScheduleList.participantScheduleList.examScheduleSupervised.examinerSchedule",
            "examinerRoomUkomList.examinerUkom"
        ])
            ->whereHas("examScheduleList", function ($query) {
                $query->whereIn("exam_type_code", [
                    ExamTypes::PRAKTIK->value,
                    ExamTypes::MAKALAH->value,
                    ExamTypes::WAWANCARA->value,
                    ExamTypes::STUDI_KASUS->value,
                    ExamTypes::PORTOFOLIO->value
                ]);
            })
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->get();

        foreach ($roomList as $room) {
            Log::info("room " . $room->id);
            $examinerRoomList = $room->examinerRoomUkomList;

            if ($examinerRoomList->isEmpty()) {
                continue;
            }

            foreach ($room->examScheduleList as $examSchedule) {
                Log::info("examSchedule " . $examSchedule->exam_type_code);

                try {
                    DB::transaction(function () use ($examSchedule, $examinerRoomList, $room) {
                        $startTime = Carbon::parse($examSchedule->start_time);
                        $endTime = Carbon::parse($examSchedule->end_time);
                        $duration = (float) $examSchedule->duration;

                        $examinerScheduleList = [];
                        $examinerScheduleSeminarList = [];

                        if ($examSchedule->examinerScheduleList->isEmpty()) {
                            foreach ($examinerRoomList as $key => $examinerRoom) {
                                $types = optional($examinerRoom->examinerUkom)->examinerTypeList?->pluck("exam_type")->toArray() ?? [];

                                if ($examSchedule->exam_type_code != ExamTypes::MAKALAH->value) {
                                    if (!in_array($examSchedule->exam_type_code, $types)) {
                                        continue;
                                    }

                                    $examinerSchedule = ExaminerSchedule::where([
                                        'examiner_id' => $examinerRoom->examiner_id,
                                        'exam_schedule_id' => $examSchedule->id,
                                    ])->first();

                                    if (!$examinerSchedule) {
                                        $examinerSchedule = new ExaminerSchedule();
                                        $examinerSchedule->examiner_id = $examinerRoom->examiner_id;
                                        $examinerSchedule->exam_schedule_id = $examSchedule->id;
                                        $examinerSchedule->saveWithUUid();
                                    }

                                    $examinerScheduleList[] = $examinerSchedule;

                                } else {
                                    $seminarExamSchedule = $examSchedule->examScheduleChild;
                                    if (!$seminarExamSchedule) {
                                        throw new BusinessException("no seminar exam schedule on makalah", "");
                                    }

                                    if (in_array($examSchedule->exam_type_code, $types)) {
                                        $examinerSchedule = ExaminerSchedule::where([
                                            'examiner_id' => $examinerRoom->examiner_id,
                                            'exam_schedule_id' => $examSchedule->id,
                                        ])->first();

                                        if (!$examinerSchedule) {
                                            $examinerSchedule = new ExaminerSchedule();
                                            $examinerSchedule->examiner_id = $examinerRoom->examiner_id;
                                            $examinerSchedule->exam_schedule_id = $examSchedule->id;
                                            $examinerSchedule->saveWithUUid();
                                        }

                                        $examinerScheduleList[] = $examinerSchedule;
                                    }
                                    if (in_array($seminarExamSchedule->exam_type_code, $types)) {
                                        $startTime = Carbon::parse($seminarExamSchedule->start_time);
                                        $endTime = Carbon::parse($seminarExamSchedule->end_time);
                                        $duration = (float) $seminarExamSchedule->duration;

                                        $examinerScheduleSeminar = ExaminerSchedule::where([
                                            'examiner_id' => $examinerRoom->examiner_id,
                                            'exam_schedule_id' => $seminarExamSchedule->id,
                                        ])->first();

                                        if (!$examinerScheduleSeminar) {
                                            $examinerScheduleSeminar = new ExaminerSchedule();
                                            $examinerScheduleSeminar->examiner_id = $examinerRoom->examiner_id;
                                            $examinerScheduleSeminar->exam_schedule_id = $seminarExamSchedule->id;
                                            $examinerScheduleSeminar->saveWithUUid();
                                        }

                                        $examinerScheduleSeminarList[] = $examinerScheduleSeminar;
                                    }
                                }
                            }
                        } else {
                            $excludedIds = $examSchedule->examinerScheduleList->pluck('examiner_id');

                            if ($examSchedule->examScheduleChild) {
                                $excludedIds = $excludedIds->merge(
                                    $examSchedule->examScheduleChild->examinerScheduleList->pluck('examiner_id')
                                );
                            }

                            $restExaminerRoomList = ExaminerRoomUkom::with('examinerUkom')
                                ->where('room_id', $room->id)
                                ->whereNotIn('examiner_id', $excludedIds->unique()->toArray())
                                ->get();


                            if ($examSchedule->exam_type_code != ExamTypes::MAKALAH->value) {

                                $examinerScheduleList = $examSchedule->examinerScheduleList()
                                    ->get()
                                    ->map(fn($item) => (object) $item->getAttributes())
                                    ->all();
                            } else {
                                $seminarExamSchedule = $examSchedule->examScheduleChild;
                                if (!$seminarExamSchedule) {
                                    throw new BusinessException("no seminar exam schedule on makalah", "");
                                }
                                $startTime = Carbon::parse($seminarExamSchedule->start_time);
                                $endTime = Carbon::parse($seminarExamSchedule->end_time);
                                $duration = (float) $seminarExamSchedule->duration;

                                $examinerScheduleList = $examSchedule->examinerScheduleList()
                                    ->get()
                                    ->map(fn($item) => (object) $item->getAttributes())
                                    ->all();
                                $examinerScheduleSeminarList = $seminarExamSchedule->examinerScheduleList()
                                    ->get()
                                    ->map(fn($item) => (object) $item->getAttributes())
                                    ->all();
                            }

                            foreach ($restExaminerRoomList as $key => $examinerRoom) {
                                $types = optional($examinerRoom->examinerUkom)->examinerTypeList?->pluck("exam_type")->toArray() ?? [];

                                if ($examSchedule->exam_type_code != ExamTypes::MAKALAH->value) {
                                    if (!in_array($examSchedule->exam_type_code, $types)) {
                                        continue;
                                    }

                                    $examinerSchedule = ExaminerSchedule::where([
                                        'examiner_id' => $examinerRoom->examiner_id,
                                        'exam_schedule_id' => $examSchedule->id,
                                    ])->first();

                                    if (!$examinerSchedule) {
                                        $examinerSchedule = new ExaminerSchedule();
                                        $examinerSchedule->examiner_id = $examinerRoom->examiner_id;
                                        $examinerSchedule->exam_schedule_id = $examSchedule->id;
                                        $examinerSchedule->saveWithUUid();
                                    }

                                    $examinerScheduleList[] = $examinerSchedule;

                                } else {
                                    $seminarExamSchedule = $examSchedule->examScheduleChild;
                                    if (!$seminarExamSchedule) {
                                        throw new BusinessException("no seminar exam schedule on makalah", "");
                                    }

                                    if (in_array($examSchedule->exam_type_code, $types)) {
                                        $examinerSchedule = ExaminerSchedule::where([
                                            'examiner_id' => $examinerRoom->examiner_id,
                                            'exam_schedule_id' => $examSchedule->id,
                                        ])->first();

                                        if (!$examinerSchedule) {
                                            $examinerSchedule = new ExaminerSchedule();
                                            $examinerSchedule->examiner_id = $examinerRoom->examiner_id;
                                            $examinerSchedule->exam_schedule_id = $examSchedule->id;
                                            $examinerSchedule->saveWithUUid();
                                        }

                                        $examinerScheduleList[] = $examinerSchedule;
                                    }
                                    if (in_array($seminarExamSchedule->exam_type_code, $types)) {

                                        $startTime = Carbon::parse($seminarExamSchedule->start_time);
                                        $endTime = Carbon::parse($seminarExamSchedule->end_time);
                                        $duration = (float) $seminarExamSchedule->duration;

                                        $examinerScheduleSeminar = ExaminerSchedule::where([
                                            'examiner_id' => $examinerRoom->examiner_id,
                                            'exam_schedule_id' => $seminarExamSchedule->id,
                                        ])->first();

                                        if (!$examinerScheduleSeminar) {
                                            $examinerScheduleSeminar = new ExaminerSchedule();
                                            $examinerScheduleSeminar->examiner_id = $examinerRoom->examiner_id;
                                            $examinerScheduleSeminar->exam_schedule_id = $seminarExamSchedule->id;
                                            $examinerScheduleSeminar->saveWithUUid();
                                        }

                                        $examinerScheduleSeminarList[] = $examinerScheduleSeminar;
                                    }
                                }
                            }
                        }
                        if (empty($examinerScheduleList)) {
                            throw new BusinessException("examiner not found for a match", "");
                        }
                        if ($examSchedule->exam_type_code == ExamTypes::MAKALAH->value && empty($examinerScheduleSeminarList)) {
                            throw new BusinessException("examiner not found for a match", "");
                        }

                        $schedules = null;
                        if (in_array($examSchedule->exam_type_code, [ExamTypes::MAKALAH->value, ExamTypes::WAWANCARA->value, ExamTypes::PRAKTIK->value])) {

                            $schedules = $this->generatePersonalSchedulesWithoutLimit($startTime, $endTime, $duration, true);
                            if (empty($schedules)) {
                                throw new BusinessException("schedules is empty", "", $schedules);
                            }
                        }

                        foreach ($examSchedule->participantScheduleList as $participantSchedule) {
                            if ($participantSchedule->examScheduleSupervised?->examinerSchedule) {
                                continue;
                            }
                            Log::info("participantSchedule " . $participantSchedule->id);

                            $selectedSchedule = null;
                            $selectedScheduleEnd = null;
                            $selectedScheduleIndex = null;

                            if ($examSchedule->exam_type_code == ExamTypes::MAKALAH->value) {
                                $seminarParticipantSchedule = ParticipantSchedule::where("participant_id", $participantSchedule->participant_id)->where("exam_schedule_id", $examSchedule->examScheduleChild->id)->first();
                                if ($seminarParticipantSchedule->examScheduleSupervised?->examinerSchedule) {
                                    continue;
                                }

                                $examinerIdMakalah = null;
                                $examinerMakalahId = null;
                                $examinerSeminarId = null;

                                if ($seminarParticipantSchedule->personal_schedule) {
                                    $currentSchedule = Carbon::parse($seminarParticipantSchedule->personal_schedule);

                                    foreach ($schedules as $index => $schedule) {
                                        $examinerIdMakalah = null;
                                        $examinerMakalahId = null;
                                        $examinerSeminarId = null;
                                        if (!$currentSchedule->equalTo($schedule)) {
                                            continue;
                                        }
                                        $scheduleEnd = $schedule->copy()->addHours($duration);
                                        if ($this->checkIfScheduleTaken($seminarParticipantSchedule->participant_id, $examSchedule->id, $schedule, $scheduleEnd)) {
                                            continue;
                                        }

                                        foreach ($examinerScheduleList as $key => $examinerSchedule) {
                                            $examinerMakalahExist = $this->isExaminerBusy($examinerSchedule->examiner_id, $schedule, $scheduleEnd);

                                            if (!$examinerMakalahExist) {
                                                $examinerIdMakalah = $examinerSchedule->examiner_id;
                                                $examinerMakalahId = $examinerSchedule->id;
                                                Log::info("selected examiner makalah : " . $examinerSchedule->examiner_id);
                                                break;
                                            }
                                        }

                                        if ($examinerMakalahId) {
                                            foreach ($examinerScheduleSeminarList as $key => $examinerSchedule) {
                                                if ($examSchedule->examiner_amount > 1) {
                                                    if ($examinerIdMakalah == $examinerSchedule->examiner_id) {
                                                        continue;
                                                    }
                                                } else {
                                                    if ($examinerIdMakalah != $examinerSchedule->examiner_id) {
                                                        continue;
                                                    }
                                                }

                                                $examinerSeminarExist = $this->isExaminerBusy($examinerSchedule->examiner_id, $schedule, $scheduleEnd);
                                                if (!$examinerSeminarExist) {
                                                    $examinerSeminarId = $examinerSchedule->id;
                                                    Log::info("selected examiner seminar : " . $examinerSchedule->examiner_id);
                                                    break;
                                                }
                                            }
                                        } else {
                                            continue;
                                        }

                                        if (!$examinerSeminarId || !$examinerMakalahId) {
                                            continue;
                                        }

                                        if (!$this->isParticipantBusy($seminarParticipantSchedule->participant_id, $schedule, $scheduleEnd)) {
                                            $selectedSchedule = $schedule;
                                            $selectedScheduleEnd = $scheduleEnd;
                                            $selectedScheduleIndex = $index;
                                            break;
                                        }
                                    }
                                }

                                if (!$examinerMakalahId || !$examinerSeminarId) {
                                    foreach ($schedules as $index => $schedule) {
                                        $examinerIdMakalah = null;
                                        $examinerMakalahId = null;
                                        $examinerSeminarId = null;
                                        $scheduleEnd = $schedule->copy()->addHours($duration);
                                        if ($this->checkIfScheduleTaken($seminarParticipantSchedule->participant_id, $examSchedule->id, $schedule, $scheduleEnd)) {
                                            continue;
                                        }

                                        foreach ($examinerScheduleList as $key => $examinerSchedule) {
                                            $examinerMakalahExist = $this->isExaminerBusy($examinerSchedule->examiner_id, $schedule, $scheduleEnd);

                                            if (!$examinerMakalahExist) {
                                                $examinerIdMakalah = $examinerSchedule->examiner_id;
                                                $examinerMakalahId = $examinerSchedule->id;
                                                Log::info("selected examiner makalah : " . $examinerSchedule->examiner_id);
                                                break;
                                            }
                                        }

                                        if ($examinerMakalahId) {
                                            foreach ($examinerScheduleSeminarList as $key => $examinerSchedule) {
                                                if ($examSchedule->examiner_amount > 1) {
                                                    if ($examinerIdMakalah == $examinerSchedule->examiner_id) {
                                                        continue;
                                                    }
                                                } else {
                                                    if ($examinerIdMakalah != $examinerSchedule->examiner_id) {
                                                        continue;
                                                    }
                                                }

                                                $examinerSeminarExist = $this->isExaminerBusy($examinerSchedule->examiner_id, $schedule, $scheduleEnd);
                                                if (!$examinerSeminarExist) {
                                                    $examinerSeminarId = $examinerSchedule->id;
                                                    Log::info("selected examiner seminar : " . $examinerSchedule->examiner_id);
                                                    break;
                                                }
                                            }
                                        } else {
                                            continue;
                                        }

                                        if (!$examinerSeminarId || !$examinerMakalahId) {
                                            continue;
                                        }

                                        if (!$this->isParticipantBusy($seminarParticipantSchedule->participant_id, $schedule, $scheduleEnd)) {
                                            $selectedSchedule = $schedule;
                                            $selectedScheduleEnd = $scheduleEnd;
                                            $selectedScheduleIndex = $index;
                                            break;
                                        }
                                    }
                                }

                                if (!$examinerMakalahId || !$examinerSeminarId) {
                                    Log::info("no available examiner for makalah and seminar");
                                    continue;
                                }

                                if (!$selectedSchedule) {
                                    Log::info("no available schedule for participant seminar");
                                    continue;
                                }

                                unset($schedules[$selectedScheduleIndex]);
                                $schedules = array_values($schedules);

                                $examScheduleSupervised = new ExamScheduleSupervised();
                                $examScheduleSupervised->participant_schedule_id = $participantSchedule->id;
                                $examScheduleSupervised->examiner_schedule_id = $examinerMakalahId;
                                $examScheduleSupervised->saveWithUUid();

                                $seminarParticipantSchedule->personal_schedule = $selectedSchedule;
                                $seminarParticipantSchedule->personal_schedule_end = $selectedScheduleEnd;
                                $seminarParticipantSchedule->save();

                                $examScheduleSupervised = new ExamScheduleSupervised();
                                $examScheduleSupervised->participant_schedule_id = $seminarParticipantSchedule->id;
                                $examScheduleSupervised->examiner_schedule_id = $examinerSeminarId;
                                $examScheduleSupervised->saveWithUUid();

                                Log::info("saving makalah/seminar schedule for participant_schedule_id " . $examScheduleSupervised->participant_schedule_id);
                                continue;

                            } else if ($examSchedule->exam_type_code == ExamTypes::WAWANCARA->value) {
                                $examinerScheduleId = null;

                                if ($participantSchedule->personal_schedule) {
                                    $currentSchedule = Carbon::parse($participantSchedule->personal_schedule);

                                    foreach ($schedules as $index => $schedule) {
                                        $examinerScheduleId = null;
                                        if (!$currentSchedule->equalTo($schedule)) {
                                            continue;
                                        }

                                        $scheduleEnd = $schedule->copy()->addHours($duration);
                                        if ($this->checkIfScheduleTaken($participantSchedule->participant_id, $examSchedule->id, $schedule, $scheduleEnd)) {
                                            continue;
                                        }

                                        foreach ($examinerScheduleList as $key => $examinerSchedule) {
                                            $examinerExist = $this->isExaminerBusy($examinerSchedule->examiner_id, $schedule, $scheduleEnd);

                                            if (!$examinerExist) {
                                                $examinerScheduleId = $examinerSchedule->id;
                                                Log::info("selected examiner praktik : " . $examinerSchedule->examiner_id);
                                                break;
                                            }
                                        }

                                        if (!$examinerScheduleId) {
                                            continue;
                                        }

                                        if (!$this->isParticipantBusy($participantSchedule->participant_id, $schedule, $scheduleEnd)) {
                                            $selectedSchedule = $schedule;
                                            $selectedScheduleEnd = $scheduleEnd;
                                            $selectedScheduleIndex = $index;
                                            break;
                                        }
                                    }
                                }

                                if (!$examinerScheduleId) {
                                    foreach ($schedules as $index => $schedule) {
                                        $examinerScheduleId = null;
                                        $scheduleEnd = $schedule->copy()->addHours($duration);
                                        if ($this->checkIfScheduleTaken($participantSchedule->participant_id, $examSchedule->id, $schedule, $scheduleEnd)) {
                                            continue;
                                        }

                                        foreach ($examinerScheduleList as $key => $examinerSchedule) {
                                            $examinerExist = $this->isExaminerBusy($examinerSchedule->examiner_id, $schedule, $scheduleEnd);

                                            if (!$examinerExist) {
                                                $examinerScheduleId = $examinerSchedule->id;
                                                Log::info("selected examiner wawancara : " . $examinerSchedule->examiner_id);
                                                break;
                                            }
                                        }

                                        if ($examinerScheduleId) {
                                            $selectedSchedule = $schedule;
                                            $selectedScheduleEnd = $scheduleEnd;
                                            $selectedScheduleIndex = $index;
                                            break;
                                        }
                                    }
                                }

                                if (!$examinerScheduleId) {
                                    Log::info("no available examiner for wawancara");
                                    continue;
                                }

                                if (!$selectedSchedule) {
                                    Log::info("no available schedule for participant wawancara");
                                    continue;
                                }

                                unset($schedules[$selectedScheduleIndex]);
                                $schedules = array_values($schedules);

                                $participantSchedule->personal_schedule = $selectedSchedule;
                                $participantSchedule->personal_schedule_end = $selectedScheduleEnd;
                                $participantSchedule->save();

                                $examScheduleSupervised = new ExamScheduleSupervised();
                                $examScheduleSupervised->participant_schedule_id = $participantSchedule->id;
                                $examScheduleSupervised->examiner_schedule_id = $examinerScheduleId;
                                $examScheduleSupervised->saveWithUUid();

                                Log::info("saving wawancara schedule for participant_schedule_id " . $examScheduleSupervised->participant_schedule_id);
                                continue;

                            } else if ($examSchedule->exam_type_code == ExamTypes::PRAKTIK->value) {
                                $examinerScheduleId = null;

                                if ($participantSchedule->personal_schedule) {
                                    $currentSchedule = Carbon::parse($participantSchedule->personal_schedule);

                                    foreach ($schedules as $index => $schedule) {
                                        $examinerScheduleId = null;
                                        if (!$currentSchedule->equalTo($schedule)) {
                                            continue;
                                        }

                                        $scheduleEnd = $schedule->copy()->addHours($duration);
                                        if ($this->checkIfScheduleTaken($participantSchedule->participant_id, $examSchedule->id, $schedule, $scheduleEnd)) {
                                            continue;
                                        }

                                        foreach ($examinerScheduleList as $key => $examinerSchedule) {
                                            $examinerExist = $this->isExaminerBusy($examinerSchedule->examiner_id, $schedule, $scheduleEnd);

                                            if (!$examinerExist) {
                                                $examinerScheduleId = $examinerSchedule->id;
                                                Log::info("selected examiner praktik : " . $examinerSchedule->examiner_id);
                                                break;
                                            }
                                        }

                                        if ($examinerScheduleId) {
                                            $selectedSchedule = $schedule;
                                            $selectedScheduleEnd = $scheduleEnd;
                                            $selectedScheduleIndex = $index;
                                            break;
                                        }
                                    }
                                }

                                if (!$examinerScheduleId) {
                                    foreach ($schedules as $index => $schedule) {
                                        $examinerScheduleId = null;
                                        $scheduleEnd = $schedule->copy()->addHours($duration);
                                        if ($this->checkIfScheduleTaken($participantSchedule->participant_id, $examSchedule->id, $schedule, $scheduleEnd)) {
                                            continue;
                                        }

                                        foreach ($examinerScheduleList as $key => $examinerSchedule) {
                                            $examinerExist = $this->isExaminerBusy($examinerSchedule->examiner_id, $schedule, $scheduleEnd);

                                            if (!$examinerExist) {
                                                $examinerScheduleId = $examinerSchedule->id;
                                                Log::info("selected examiner praktik : " . $examinerSchedule->examiner_id);
                                                break;
                                            }
                                        }

                                        if (!$examinerScheduleId) {
                                            continue;
                                        }

                                        if (!$this->isParticipantBusy($participantSchedule->participant_id, $schedule, $scheduleEnd)) {
                                            $selectedSchedule = $schedule;
                                            $selectedScheduleEnd = $scheduleEnd;
                                            $selectedScheduleIndex = $index;
                                            break;
                                        }
                                    }
                                }

                                if (!$examinerScheduleId) {
                                    Log::info("no available examiner for praktik");
                                    continue;
                                }

                                if (!$selectedSchedule) {
                                    Log::info("no available schedule for participant praktik");
                                    continue;
                                }

                                unset($schedules[$selectedScheduleIndex]);
                                $schedules = array_values($schedules);

                                $participantSchedule->personal_schedule = $selectedSchedule;
                                $participantSchedule->personal_schedule_end = $selectedScheduleEnd;
                                $participantSchedule->save();

                                $examScheduleSupervised = new ExamScheduleSupervised();
                                $examScheduleSupervised->participant_schedule_id = $participantSchedule->id;
                                $examScheduleSupervised->examiner_schedule_id = $examinerScheduleId;
                                $examScheduleSupervised->saveWithUUid();

                                Log::info("saving praktik schedule for participant_schedule_id " . $examScheduleSupervised->participant_schedule_id);
                                continue;

                            } else if ($examSchedule->exam_type_code == ExamTypes::STUDI_KASUS->value) {
                                $examinerScheduleId = null;

                                $randomIndex = array_rand($examinerScheduleList);
                                $examinerSchedule = $examinerScheduleList[$randomIndex];
                                $examinerScheduleId = $examinerSchedule->id;
                                Log::info("selected examiner studi kasus : " . $examinerSchedule->examiner_id);

                                if (!$examinerScheduleId) {
                                    Log::info("no available examiner for studi kasus");
                                    continue;
                                }

                                $examScheduleSupervised = new ExamScheduleSupervised();
                                $examScheduleSupervised->participant_schedule_id = $participantSchedule->id;
                                $examScheduleSupervised->examiner_schedule_id = $examinerScheduleId;
                                $examScheduleSupervised->saveWithUUid();

                                Log::info("saving studi kasus studikasus for participant_schedule_id " . $examScheduleSupervised->participant_schedule_id);
                                continue;

                            } else if ($examSchedule->exam_type_code == ExamTypes::PORTOFOLIO->value) {
                                $examinerScheduleId = null;

                                $randomIndex = array_rand($examinerScheduleList);
                                $examinerSchedule = $examinerScheduleList[$randomIndex];
                                $examinerScheduleId = $examinerSchedule->id;
                                Log::info("selected examiner studi kasus : " . $examinerSchedule->examiner_id);

                                if (!$examinerScheduleId) {
                                    Log::info("no available examiner for portofolio");
                                    continue;
                                }

                                $examScheduleSupervised = new ExamScheduleSupervised();
                                $examScheduleSupervised->participant_schedule_id = $participantSchedule->id;
                                $examScheduleSupervised->examiner_schedule_id = $examinerScheduleId;
                                $examScheduleSupervised->saveWithUUid();

                                Log::info("saving portofolio schedule for participant_schedule_id " . $examScheduleSupervised->participant_schedule_id);
                                continue;
                            }
                        }
                    });
                } catch (BusinessException $be) {
                    Log::error('Error collecting examiner :' . $be->getMessage());
                    continue;
                } finally {
                    unset($examSchedule);
                }
            }
            // Force garbage collection after each room
            gc_collect_cycles();
        }
        Log::info('FINISH SCHEDULING EXAMINER');
        unset($roomList);
    }

    private function getPrimaryExaminer($exam_schedule_id)
    {
        return ExamScheduleSupervised::whereHas("examinerSchedule.examSchedule", function ($query) use ($exam_schedule_id) {
            $query->where("exam_schedule_id", $exam_schedule_id);
        })->oldest("date_created")->first();
    }

    private function checkIfExaminerTaken($examiner_id, $exam_schedule_id_list)
    {
        return ExamScheduleSupervised::whereHas("examinerSchedule.examSchedule", function ($query) use ($examiner_id, $exam_schedule_id_list) {
            $query->whereHas("roomUkom", function ($query2) {
                $query2->where("delete_flag", false)
                    ->where("inactive_flag", false);
            })->where('examiner_id', $examiner_id)
                ->whereNotIn("exam_schedule_id", $exam_schedule_id_list);
        })->exists();
    }

    private function checkIfScheduleTaken($participant_id, $exam_schedule_id, Carbon $start, Carbon $end)
    {
        return ParticipantSchedule::where("exam_schedule_id", $exam_schedule_id)
            ->whereNot("participant_id", $participant_id)
            ->whereNotNull("personal_schedule")
            ->whereNotNull("personal_schedule_end")
            ->where('personal_schedule', '<', $end)
            ->where('personal_schedule_end', '>', $start)
            ->exists();
    }

    private function isExaminerBusy($examiner_id, Carbon $start, Carbon $end, $excludeId = null)
    {
        return ExamScheduleSupervised::whereHas('examinerSchedule', function ($query) use ($examiner_id) {
            $query->where("examiner_id", $examiner_id);
        })->whereHas("participantSchedule", function ($query) use ($start, $end) {
            $query->where('personal_schedule', '<', $end)
                ->where('personal_schedule_end', '>', $start);
        })->when($excludeId, function ($query) use ($excludeId) {
            $query->where('id', '!=', $excludeId);
        })->exists();
    }

    private function isParticipantBusy($participant_id, Carbon $start, Carbon $end)
    {
        return ParticipantSchedule::where("participant_id", $participant_id)
            ->where('personal_schedule', '<', $end)
            ->where('personal_schedule_end', '>', $start)->exists();
    }

    private function generatePersonalSchedules(
        Carbon $start,
        Carbon $end,
        float $durationHour,
        int $participantCount,
        bool $ignoreError = false
    ) {
        // Cache config (reuse same as previous function)
        if (!$this->inmemoryCacheScheduleSysConf) {
            $this->inmemoryCacheScheduleSysConf = [
                'isWeekendAllowed' => SystemConfiguration::find("UKOM_SCHEDULE_IS_WEEKEN_ALLOWED")->value === "ya",
                'start' => (int) SystemConfiguration::find("UKOM_SCHEDULE_START_AT")->value,
                'end' => (int) SystemConfiguration::find("UKOM_SCHEDULE_END_AT")->value,
                'lunch_start' => (int) SystemConfiguration::find("UKOM_SCHEDULE_START_LUNCH_AT")->value,
                'lunch_end' => (int) SystemConfiguration::find("UKOM_SCHEDULE_END_LUNCH_AT")->value,
            ];
        }

        $conf = $this->inmemoryCacheScheduleSysConf;

        $startHour = $conf['start'] ?? 8;
        $endHour = $conf['end'] ?? 17;
        $lunchStartHour = $conf['lunch_start'] ?? 12;
        $lunchEndHour = $conf['lunch_end'] ?? 13;

        $durationMinutes = (int) round($durationHour * 60);

        $schedules = [];
        $current = $start->copy();

        // Normalize midnight end
        if ($end->format('H:i:s') === '00:00:00') {
            $end = $end->copy()->setTime(23, 59, 59);
        }

        for ($i = 0; $i < $participantCount; $i++) {

            while ($current->lt($end)) {

                // Skip weekend if not allowed
                if (!$conf['isWeekendAllowed'] && $current->isWeekend()) {
                    $current = $current->next(Carbon::MONDAY)->setTime($startHour, 0);
                    continue;
                }

                $workStart = $current->copy()->setTime($startHour, 0, 0);
                $workEnd = $current->copy()->setTime($endHour, 0, 0);
                $lunchStart = $current->copy()->setTime($lunchStartHour, 0, 0);
                $lunchEnd = $current->copy()->setTime($lunchEndHour, 0, 0);

                // Align to working hours
                if ($current->lt($workStart)) {
                    $current = $workStart;
                }

                // If already past work hours → next day
                if ($current->gte($workEnd)) {
                    $current = $current->copy()->addDay()->setTime($startHour, 0);
                    continue;
                }

                $slotEnd = $current->copy()->addMinutes($durationMinutes);

                // If exceeds working hours → next day
                if ($slotEnd->gt($workEnd)) {
                    $current = $current->copy()->addDay()->setTime($startHour, 0);
                    continue;
                }

                // Handle lunch overlap
                $overlapsLunch = $current->lt($lunchEnd) && $slotEnd->gt($lunchStart);
                if ($overlapsLunch) {
                    $current = $lunchEnd;
                    continue;
                }

                // Final boundary check
                if ($slotEnd->gt($end)) {
                    if ($ignoreError) {
                        break 2; // exit both loops
                    }

                    throw new BusinessException(
                        'Not enough time slots for all participants.',
                        'ESS-00001'
                    );
                }

                $schedules[] = $current->copy();

                // Move to next slot
                $current = $slotEnd;

                // move to next participant
                continue 2;
            }

            // If we exit while but still need participants
            if (!$ignoreError) {
                throw new BusinessException(
                    'Not enough time slots for all participants.',
                    'ESS-00001'
                );
            }

            break;
        }

        // foreach ($schedules as $key => $value) {
        //     Log::info("date generated $key = " . $value->toDateTimeString());
        // }

        return $schedules;
    }

    private function generatePersonalSchedulesWithoutLimit(
        Carbon $start,
        Carbon $end,
        float $durationHour,
        bool $ignoreError = false
    ) {
        // Cache config
        if (!$this->inmemoryCacheScheduleSysConf) {
            $this->inmemoryCacheScheduleSysConf = [
                'isWeekendAllowed' => SystemConfiguration::find("UKOM_SCHEDULE_IS_WEEKEN_ALLOWED")->value === "ya",
                'start' => (int) SystemConfiguration::find("UKOM_SCHEDULE_START_AT")->value,
                'end' => (int) SystemConfiguration::find("UKOM_SCHEDULE_END_AT")->value,
                'lunch_start' => (int) SystemConfiguration::find("UKOM_SCHEDULE_START_LUNCH_AT")->value,
                'lunch_end' => (int) SystemConfiguration::find("UKOM_SCHEDULE_END_LUNCH_AT")->value,
            ];
        }

        $conf = $this->inmemoryCacheScheduleSysConf;

        $startHour = $conf['start'] ?? 8;
        $endHour = $conf['end'] ?? 17;
        $lunchStartHour = $conf['lunch_start'] ?? 12;
        $lunchEndHour = $conf['lunch_end'] ?? 13;

        $durationMinutes = (int) round($durationHour * 60);

        $schedules = [];
        $current = $start->copy();

        // Normalize end-of-day midnight
        if ($end->format('H:i:s') === '00:00:00') {
            $end = $end->copy()->setTime(23, 59, 59);
        }

        while ($current->lt($end)) {

            // Skip weekend if not allowed
            if (!$conf['isWeekendAllowed'] && $current->isWeekend()) {
                $current = $current->next(Carbon::MONDAY)->setTime($startHour, 0);
                continue;
            }

            $workStart = $current->copy()->setTime($startHour, 0, 0);
            $workEnd = $current->copy()->setTime($endHour, 0, 0);
            $lunchStart = $current->copy()->setTime($lunchStartHour, 0, 0);
            $lunchEnd = $current->copy()->setTime($lunchEndHour, 0, 0);

            // Align to working hours
            if ($current->lt($workStart)) {
                $current = $workStart;
            }

            $slotEnd = $current->copy()->addMinutes($durationMinutes);

            // If slot starts after work hours → next day
            if ($current->gte($workEnd)) {
                $current = $current->copy()->addDay()->setTime($startHour, 0);
                continue;
            }

            // If slot exceeds work hours → next day
            if ($slotEnd->gt($workEnd)) {
                $current = $current->copy()->addDay()->setTime($startHour, 0);
                continue;
            }

            // Handle lunch overlap
            $overlapsLunch = $current->lt($lunchEnd) && $slotEnd->gt($lunchStart);

            if ($overlapsLunch) {
                // Move to after lunch
                $current = $lunchEnd;
                continue;
            }

            // Final boundary check
            if ($slotEnd->gt($end)) {
                if ($ignoreError) {
                    break;
                }

                throw new BusinessException(
                    'Not enough time slots within the given range.',
                    'ESS-00001'
                );
            }

            // ✅ Valid slot
            $schedules[] = $current->copy();

            // Move forward
            $current = $slotEnd;
        }

        // foreach ($schedules as $key => $value) {
        //     Log::info("date generated $key = " . $value->toDateTimeString());
        // }

        return $schedules;
    }
}
