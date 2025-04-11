<?php

namespace Eyegil\EyegilLms\Services;

use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Pageable;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\EyegilLms\Dtos\MultipleChoiceDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Enums\QuestionType;
use Eyegil\EyegilLms\Models\MultipleChoice;
use Eyegil\EyegilLms\Models\Question;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionService
{

    public function __construct(
        private MultipleChoiceService $multipleChoiceService,
        private AnswerService $answerService,
        private StorageService $storageService,
        private QuestionGroupService $questionGroupService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(Question::class);
    }

    public function findDropList($association_id = null, $module_id = null, $type = null)
    {
        return Question::query()
            ->when($association_id, fn($query) => $query->whereHas("questionGroup", function ($query) use ($association_id) {
                $query->where("association_id", $association_id);
            }))
            ->when($module_id, fn($query) => $query->where("module_id", $module_id))
            ->when($type, fn($query) => $query->where("type", $type))
            ->get();
    }

    public function findById($id): Question
    {
        return Question::findOrThrowNotFound($id);
    }

    public function save(QuestionDto $questionDto)
    {
        return DB::transaction(function () use ($questionDto) {
            $userContext = user_context();

            $question = new Question();
            $question->fromArray($questionDto->toArray());
            $question->created_by = $userContext->id;
            $question->saveWithUuid();

            //set id on the dto
            $questionDto->id = $question->id;

            if ($questionDto->association && $questionDto->association_id) {
                $this->questionGroupService->save($questionDto);
            }

            if ($questionDto->type == QuestionType::MULTI_CHOICE) {
                $this->multipleChoiceService->save($questionDto);
            }

            return $question;
        });
    }

    public function saveWithAttachment(QuestionDto $questionDto)
    {
        return DB::transaction(function () use ($questionDto) {
            if ($questionDto->file_attachment) {
                $questionDto->attachment = $this->storageService->putObjectFromBase64WithFilename("system", "lms", "questions_" . Carbon::now()->format('YmdHis'), $questionDto->file_attachment);
            }
            return $this->save($questionDto);
        });
    }

    public function update(QuestionDto $questionDto)
    {
        return DB::transaction(function () use ($questionDto) {
            $userContext = user_context();

            $question = $this->findById($questionDto->id);
            $question->updated_by = $userContext->id;
            $question->question = $questionDto->question;
            $question->save();

            if ($questionDto->type == QuestionType::MULTI_CHOICE) {
                $questionDto->id = $question->id;
                $this->multipleChoiceService->save($questionDto);
            }

            return $question;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();

            $question = $this->findById($id);
            $question->updated_by = $userContext->id;
            $question->delete_flag = true;
            $question->save();

            return $question;
        });
    }
}
