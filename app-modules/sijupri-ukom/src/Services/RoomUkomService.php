<?php

namespace Eyegil\SijupriUkom\Services;

use App\Services\SendNotifyService;
use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Pageable;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriMaintenance\Services\BidangJabatanService;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Dtos\RoomUkomDto;
use Eyegil\SijupriUkom\Dtos\RoomUkomQuestionDto;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\SijupriUkom\Models\RoomUkom;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomUkomService
{
    public function __construct(
        private DocumentUkomService $documentUkomService,
        private BidangJabatanService $bidangJabatanService,
        private ParticipantRoomUkomService $participantRoomUkomService,
        private UkomBanService $ukomBanService,
        private ExamQuestionService $examQuestionService,
        private SendNotifyService $sendNotifyService
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual('periodePendaftaran|type', 'periode_ukom');
        $pageable->addEqual('delete_flag', false);
        $pageable->addEqual('inactive_flag', false);
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(RoomUkom::class);
    }

    public function findQuestionSearch(Pageable $pageable, $exam_type_code, $room_ukom_id)
    {
        $search = $this->examQuestionService->findSearch($pageable, $exam_type_code, $room_ukom_id);
        return $search->setCollection($search->getCollection()->map(function (ExamQuestion $examQuestion) {
            return $examQuestion->question;
        }));
    }

    public function findById($id): RoomUkom
    {
        return RoomUkom::findOrThrowNotFound($id);
    }

    public function save(RoomUkomDto $roomUkomDto)
    {
        DB::transaction(function () use ($roomUkomDto) {
            $userContext = user_context();
            $roomUkom = new RoomUkom();
            $roomUkom->fromArray($roomUkomDto->toArray());
            $roomUkom->created_by = $userContext->id;
            $roomUkom->exam_start_at = Carbon::parse($roomUkomDto->exam_start_at);
            $roomUkom->exam_end_at = Carbon::parse($roomUkomDto->exam_end_at);
            $roomUkom->saveWithUUid();

            return $roomUkom;
        });
    }

    public function setQuestion(RoomUkomQuestionDto $RoomUkomQuestionDto)
    {
        DB::transaction(function () use ($RoomUkomQuestionDto) {
            $this->examQuestionService->save($RoomUkomQuestionDto);
        });
    }

    public function update(RoomUkomDto $roomUkomDto)
    {
        DB::transaction(function () use ($roomUkomDto) {
            $userContext = user_context();

            $roomUkom = $this->findById($roomUkomDto->id);

            if ($roomUkomDto->bidang_jabatan_code) {
                $bidangJabatan = $this->bidangJabatanService->findById($roomUkomDto->bidang_jabatan_code);
                if ($bidangJabatan->jabatan_code != $roomUkomDto->jabatan_code) {
                    throw new BusinessException("Invalid bidang jabatan on jabatan", "RUS-00001");
                }
            }

            $roomUkom->fromArray($roomUkomDto->toArray());
            $roomUkom->updated_by = $userContext->id;
            $roomUkom->exam_start_at = Carbon::parse($roomUkomDto->exam_start_at);
            $roomUkom->exam_end_at = Carbon::parse($roomUkomDto->exam_end_at);
            $roomUkom->save();

            return $roomUkom;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $roomUkom = $this->findById($id);
            $examDate = Carbon::parse($roomUkom->exam_start_at)->startOfDay();
            $now = Carbon::now()->startOfDay();

            if ($examDate->isToday() || $now->greaterThanOrEqualTo($examDate)) {
                throw new BusinessException("Cannot delete active room", "UKM-00001");
            }
            ParticipantRoomUkom::where("room_id", $id)->delete();
            ExamQuestion::where("room_ukom_id", $id)->delete();
            ExamSchedule::where("room_ukom_id", $id)->delete();
            $roomUkom->delete();
        });
    }

    public function registeringRoom()
    {
        DB::transaction(function () {
            $this->ukomBanService->deleteExpiredBan();
            RoomUkom::where("exam_end_at", "<=", Carbon::now()->addDays(1))->update([
                "inactive_flag" => true
            ]);

            $roomUkomDtoList = RoomUkom::select("ukm_room.*")
                ->leftJoin("ukm_participant_room", "ukm_room.id", "=", "ukm_participant_room.room_id")
                ->where("exam_start_at", ">=", Carbon::now()->addDays(3))
                ->groupBy("ukm_room.id")
                ->havingRaw("COUNT(ukm_participant_room.id) < ukm_room.participant_quota")
                ->get()->map(function (RoomUkom $roomUkom) {
                    return (new RoomUkomDto())->fromModel($roomUkom);
                });


            foreach ($roomUkomDtoList as $key => $roomUkomDto) {
                $participantUkomDtoList = ParticipantUkom::where("next_jabatan_code", $roomUkomDto->jabatan_code)
                    ->where("next_jenjang_code", $roomUkomDto->jenjang_code)
                    ->where("inactive_flag", false)
                    ->where("delete_flag", false)
                    ->where("bidang_jabatan_code", $roomUkomDto->bidang_jabatan_code)
                    ->whereDoesntHave("ukomBan")
                    ->whereDoesntHave("participantRoomUkom")
                    ->orderBy("date_created", "asc")
                    ->limit($roomUkomDto->participant_quota)
                    ->get()->map(function (ParticipantUkom $participantUkom) use ($roomUkomDto) {
                        $participantUkomDto = (new ParticipantUkomDto())->fromModel($participantUkom);

                        $notificationDto = new NotificationDto();
                        $notificationDto->objectMap = [
                            "name" => $participantUkomDto->name,
                            "date_start" => $roomUkomDto->exam_start_at,
                            "date_end" => $roomUkomDto->exam_end_at,
                            "detail_page_url" => config("eyegil.client_url") . '/ukm-clarrify?key=' . Crypt::encrypt($participantUkomDto->id),
                        ];
                        $this->sendNotifyService->sendEmailFinishUkomRegistration($notificationDto, $participantUkomDto->email);

                        return $participantUkomDto;
                    });

                $roomUkomDto->participant_dto_list = $participantUkomDtoList;
                $this->participantRoomUkomService->save($roomUkomDto);
            }
        });
    }
}
