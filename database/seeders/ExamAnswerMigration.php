<?php

namespace Database\Seeders;

use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamAnswerMigration extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            ExamQuestion::with('answer')->get()->each(function (ExamQuestion $examQuestion) {
                $examSchedule = ExamSchedule::where('room_ukom_id', $examQuestion->room_ukom_id)
                    ->where('exam_type_code', $examQuestion->exam_type_code)
                    ->first();

                if (!$examSchedule) {
                    $examQuestion->delete();
                } else {
                    $answerList = $examQuestion->answerAll;
                    if ($answerList->count() >= 1) {
                        foreach ($examQuestion->answerAll as $key => $answer) {
                            if ($key > 0) {
                                $examQuestion->answer_id = $answer->id;
                                $examQuestion->participant_ukom_id = $answer->participant_id;
                                $examQuestion->exam_schedule_id = $examSchedule->id;
                                $examQuestion->save();
                            } else {
                                $examQuestionNew = new ExamQuestion();
                                $examQuestionNew->fromArray($examQuestion->toArray());
                                $examQuestion->answer_id = $answer->id;
                                $examQuestion->participant_ukom_id = $answer->participant_id;
                                $examQuestion->exam_schedule_id = $examSchedule->id;
                                $examQuestion->saveWithUUid();
                            }
                        }
                    } else {
                        foreach ($examSchedule->participantScheduleList as $key => $participantSchedule) {
                            $examQuestionNew = new ExamQuestion();
                            $examQuestionNew->fromArray($examQuestion->toArray());
                            $examQuestion->answer_id = null;
                            $examQuestion->participant_ukom_id = $participantSchedule->participant_id;
                            $examQuestion->exam_schedule_id = $examSchedule->id;
                            $examQuestion->saveWithUUid();
                        }
                    }
                }
            });
        });
    }
}
