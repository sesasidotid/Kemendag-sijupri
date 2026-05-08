<?php

namespace Eyegil\EyegilLms\Services;

use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\EyegilLms\Models\Answer;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;

class AnswerService
{

    public function __construct(
        private StorageService $storageService
    ) {
    }

    public function findById($id): Answer
    {
        return Answer::findOrThrowNotFound($id);
    }

    public function findByIdV2($id)
    {
        return Answer::find($id);
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

            $answer = $this->findByIdV2($answerDto->id);
            if ($answer) {
                if ($answerDto->file_answer_upload)
                    $answerDto->answer_upload = $this->storageService->putObjectFromBase64WithFilename("system", "lms", $answer->answer_upload ?? "answer_" . Carbon::now()->format('YmdHis'), $answerDto->file_answer_upload);

                $answer->fromArray($answerDto->toArray());
                $answer->created_by = optional($userContext)->id ?? "system";
                $answer->save();
            } else {
                if ($answerDto->file_answer_upload)
                    $answerDto->answer_upload = $this->storageService->putObjectFromBase64WithFilename("system", "lms", "answer_" . Carbon::now()->format('YmdHis'), $answerDto->file_answer_upload);

                $answer = new Answer();
                $answer->fromArray($answerDto->toArray());
                $answer->created_by = optional($userContext)->id ?? "system";
                $answer->saveWithUuid();
            }

            return $answer;
        });
    }
}
