<?php

namespace Database\Seeders;

use Eyegil\EyegilLms\Models\Answer;
use Eyegil\EyegilLms\Models\Question;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamQuestionRetreaval extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            $result = DB::table('lms_answer as la')
                ->leftJoin('ukm_exam_question as ueq', function ($join) {
                    $join->on('ueq.answer_id', '=', 'la.id')
                        ->where('ueq.exam_schedule_id', '=', '9536ee65-f549-4722-a8a8-9a6a5f3599fe');
                })
                ->where('la.participant_id', 'a14944a6-3e52-486c-9278-528ab9d44630')
                ->whereNull('ueq.answer_id')
                ->select('la.*')
                ->get()->each(function ($answer) {
                    $question = Question::find($answer->question_id);

                    ExamQuestion::whereHas()
                });
        });
    }
}
