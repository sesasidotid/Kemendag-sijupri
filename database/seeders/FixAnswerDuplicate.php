<?php

namespace Database\Seeders;

use Eyegil\EyegilLms\Models\Answer;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FixAnswerDuplicate extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            // Fetch distinct data for room_ukom_id and related fields
            $result = DB::table('ukm_exam_grade as ueg')
                ->join('ukm_participant as up', 'ueg.participant_id', '=', 'up.id')
                ->join('lms_answer as la', 'ueg.participant_id', '=', 'la.participant_id')
                ->join('ukm_exam_question as ueq', function ($join) {
                    $join->on('ueq.room_ukom_id', '=', 'ueg.room_ukom_id')
                        ->on('ueg.exam_type_code', '=', 'ueq.exam_type_code')
                        ->on('la.question_id', '=', 'ueq.question_id');
                })
                ->where('ueg.exam_type_code', 'MAKALAH')
                ->select([
                    'ueq.room_ukom_id',
                    'ueg.participant_id',
                    'ueg.exam_type_code',
                    'ueq.question_id',
                ])
                ->get();

            $roomIdList = $result->pluck('room_ukom_id')->toArray();
            $questionIdList = $result->pluck('question_id')->toArray();

            // Fetch all ParticipantRoomUkom records in one go
            $participantRoomUkomList = ParticipantRoomUkom::whereIn("room_id", $roomIdList)->get();

            // Fetch all the answers at once to avoid N+1 issue
            $answerList = Answer::whereNotNull("answer_upload")
                ->whereIn("participant_id", $participantRoomUkomList->pluck('participant_id')->toArray())
                ->get();

            // Process the answers and update them if necessary
            foreach ($participantRoomUkomList as $participantRoomUkom) {
                $participantAnswers = $answerList->where('participant_id', $participantRoomUkom->participant_id);

                Log::info("participant_id = " . $participantRoomUkom->participant_id);

                $isExist = false;
                foreach ($participantAnswers as $answer) {
                    Log::info("question_id cek = " . $answer->question_id);
                    if (in_array($answer->question_id, $questionIdList)) {
                        $isExist = true;
                        break;
                    }
                }

                // If answer does not exist, assign new question_id from the result set
                if (!$isExist) {
                    $answer = $participantAnswers->first();  // Get the first answer

                    // Check if $answer is not null before proceeding
                    if ($answer) {
                        foreach ($result as $value) {
                            if ($participantRoomUkom->room_id == $value->room_ukom_id) {
                                $answer->question_id = $value->question_id;
                                $answer->save();
                                break;
                            }
                        }
                    }
                }
            }
        });

        Log::info("FINISHED");
    }
}
