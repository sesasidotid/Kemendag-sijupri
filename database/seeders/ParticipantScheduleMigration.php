<?php

namespace Database\Seeders;

use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\SijupriUkom\Models\ParticipantSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Log;

class ParticipantScheduleMigration extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            ExamSchedule::all()->each(function (ExamSchedule $examSchedule) {
                ParticipantRoomUkom::where('room_id', $examSchedule->room_ukom_id)
                    ->get()
                    ->each(function (ParticipantRoomUkom $participantRoomUkom) use ($examSchedule) {
                        $participantSchedule = new ParticipantSchedule();
                        $participantSchedule->participant_id = $participantRoomUkom->participant_id;
                        $participantSchedule->exam_schedule_id = $examSchedule->id;
                        $participantSchedule->saveWithUUid();
                    });
            });
        });
    }
}
