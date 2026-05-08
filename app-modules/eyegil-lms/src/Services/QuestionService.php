<?php

namespace Eyegil\EyegilLms\Services;

use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Pageable;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Enums\QuestionType;
use Eyegil\EyegilLms\Models\Question;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionService
{

    public function __construct(
        private MultipleChoiceService $multipleChoiceService,
        private ChecklistService $checklistService,
        private AnswerService $answerService,
        private StorageService $storageService,
        private QuestionGroupService $questionGroupService,
    ) {
    }

    public function findSearch(Pageable $pageable, $association_id = null, $module_id = null, $type = null)
    {
        $pageable->addEqual('delete_flag', false);
        $pageable->addEqual('inactive_flag', false);
        return $pageable->setWhereQueries(function (Pageable $instance, $query) use ($association_id, $module_id, $type) {
            $query->when($association_id, fn($query) => $query->whereHas("questionGroup", function ($query) use ($association_id) {
                $query->where("association_id", $association_id);
            }))
                ->when($module_id, fn($query) => $query->where("module_id", $module_id))
                ->when($type, fn($query) => $query->where("type", $type));
        }, false)
            ->setOrderQueries(function (Pageable $instance, $query) {
                if (empty($instance->sort)) {
                    $query->orderBy($instance->getTable() . '.date_created', 'desc');
                }
            })->search(Question::class);
    }

    public function findDropList($association_id = null, $module_id = null, $type = null)
    {
        return Question::query()
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
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

    public function findByIdV2($id)
    {
        return Question::find($id);
    }

    public function findByParentQuestionIdAndJabatanCodeAndJenjangCodeAndBidangJabatanCode($parent_question_id, $jabatan_code, $jenjang_code, $bidang_jabatan_code)
    {
        return Question::where("parent_question_id", $parent_question_id)
            ->whereHas("questionGroup", function ($query) use ($jabatan_code, $jenjang_code, $bidang_jabatan_code) {
                $query->whereHas("associationIndikator", function ($query) use ($jabatan_code, $jenjang_code, $bidang_jabatan_code) {
                    $query->whereHas("kompetensi", function ($query) use ($jabatan_code, $jenjang_code, $bidang_jabatan_code) {
                        $query->where("jabatan_code", $jabatan_code)
                            ->where("jenjang_code", $jenjang_code)
                            ->where("bidang_jabatan_code", $bidang_jabatan_code);
                    });
                });
            })
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->get();
    }

    public function findByParentQuestionId($parent_question_id, $komponen_id_list)
    {
        return Question::where("parent_question_id", $parent_question_id)
            ->whereHas("questionGroup", function ($query) use ($komponen_id_list) {
                $query->where("association", "komponen")
                    ->whereIn("association_id", $komponen_id_list);
            })
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->get();
    }

    public function findByParentQuestionIdV2($parent_question_id)
    {
        return Question::where("parent_question_id", $parent_question_id)
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->get();
    }

    public function findByModuleIdAndJabatanCodeAndJenjangCodeAndBidangJabatanCode($module_id, $jabatan_code, $jenjang_code, $bidang_jabatan_code)
    {
        return Question::where("module_id", $module_id)
            ->whereHas("questionGroup", function ($query) use ($jabatan_code, $jenjang_code, $bidang_jabatan_code) {
                $query->whereHas("associationIndikator", function ($query) use ($jabatan_code, $jenjang_code, $bidang_jabatan_code) {
                    $query->whereHas("kompetensi", function ($query) use ($jabatan_code, $jenjang_code, $bidang_jabatan_code) {
                        $query->where("jabatan_code", $jabatan_code)
                            ->where("jenjang_code", $jenjang_code)
                            ->where("bidang_jabatan_code", $bidang_jabatan_code);
                    });
                });
            })
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->get();
    }

    public function findByModuleIdAndAssociationAndAssociationIdWithLimit($module_id, $association, $association_id, $limit)
    {
        return Question::where('module_id', $module_id)
            ->whereHas("questionGroup", function ($query) use ($association, $association_id) {
                $query->where("association", $association)
                    ->where("association_id", $association_id);
            })
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function findByModuleIdAndAssociationAndAssociationId($module_id, $association, $association_id)
    {
        return Question::where('module_id', $module_id)
            ->whereHas("questionGroup", function ($query) use ($association, $association_id) {
                $query->where("association", $association)
                    ->where("association_id", $association_id);
            })
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->get();
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

            if ($questionDto->multiple_choice_dto_list != null && count($questionDto->multiple_choice_dto_list) > 0) {
                $this->multipleChoiceService->save($questionDto);
            }

            if ($questionDto->checklist_dto_list != null && count($questionDto->checklist_dto_list) > 0) {
                $this->checklistService->save($questionDto);
            }

            return $question;
        });
    }

    public function saveV2(QuestionDto $questionDto)
    {
        return DB::transaction(function () use ($questionDto) {
            $userContext = user_context();

            $question = new Question();
            $question->fromArray($questionDto->toArray());
            $question->created_by = $userContext->id;
            $question->save();

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

            $question = $this->findById(id: $questionDto->id);
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

    public function deleteByParentQuestionId($parent_question_id)
    {
        return DB::transaction(function () use ($parent_question_id) {
            $userContext = user_context();

            Question::where("parent_question_id", $parent_question_id)
                ->update([
                    "updated_by" => $userContext->id,
                    "delete_flag" => true
                ]);
        });
    }

    public function deleteByModuleId($module_id)
    {
        return DB::transaction(function () use ($module_id) {
            $userContext = user_context();

            Question::where("module_id", $module_id)
                ->update([
                    "updated_by" => $userContext->id,
                    "delete_flag" => true
                ]);
        });
    }

    public function deleteByModuleIdAndAssociationAndAssociationId($module_id, $association, $association_id)
    {
        return DB::transaction(function () use ($module_id, $association, $association_id) {
            $userContext = user_context();

            Question::where("module_id", $module_id)
                ->where("delete_flag", false)
                ->whereHas("questionGroup", function ($q) use ($association, $association_id) {
                    $q->where("association", $association)
                        ->where("association_id", $association_id);
                })->update([
                        "updated_by" => $userContext->id,
                        "delete_flag" => true
                    ]);
        });
    }
}
