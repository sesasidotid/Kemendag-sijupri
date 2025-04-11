<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Dtos\RoomUkomDto;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Illuminate\Support\Facades\DB;

class ParticipantRoomUkomService
{
    public function save(RoomUkomDto $roomUkomDto)
    {
        DB::transaction(function () use ($roomUkomDto) {
            foreach ($roomUkomDto->participant_dto_list as $key => $participant_ukom_dto) {
                $participantUkomDto = (new ParticipantUkomDto)->fromArray((array) $participant_ukom_dto);

                $participantRoomUkom = new ParticipantRoomUkom();
                $participantRoomUkom->participant_id = $participantUkomDto->id;
                $participantRoomUkom->room_id = $roomUkomDto->id;
                $participantRoomUkom->saveWithUuid();
            }
        });
    }

    public function update(RoomUkomDto $roomUkomDto)
    {
        DB::transaction(function () use ($roomUkomDto) {
            ParticipantRoomUkom::where('room_id', $roomUkomDto->id)->delete();
            $this->save($roomUkomDto);
        });
    }

    public function deleteByParticipantId($participant_id)
    {
        DB::transaction(function () use ($participant_id) {
            ParticipantRoomUkom::where('participant_id', $participant_id)->delete();
        });
    }
}
