<?php

namespace Eyegil\EyegilLms\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\EyegilLms\Models\Answer;
use Illuminate\Support\Facades\DB;

class AnswerService
{

    public function findById($id): Answer
    {
        return Answer::findOrThrowNotFound($id);
    }

    public function findByQuestionIdAndParticipantId($question_id, $participant_id)
    {
        return Answer::where('question_id', $question_id)
            ->where('participant_id', $participant_id)
            ->first();
    }

    public function save(AnswerDto $answerDto)
    {
        return DB::transaction(function () use ($answerDto) {
            $userContext = user_context();

            $answer = $this->findByQuestionIdAndParticipantId($answerDto->question_id, $answerDto->participant_id);
            if ($answer) {
                $answer->fromArray($answerDto->toArray());
                $answer->created_by = optional($userContext)->id ?? "system";
                $answer->save();
            } else {
                $answer = new Answer();
                $answer->fromArray($answerDto->toArray());
                $answer->created_by = optional($userContext)->id ?? "system";
                $answer->saveWithUuid();
            }

            return $answer;
        });
    }
}
