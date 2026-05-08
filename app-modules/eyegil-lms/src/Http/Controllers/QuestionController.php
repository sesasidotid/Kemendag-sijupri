<?php

namespace Eyegil\EyegilLms\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Models\Question;
use Eyegil\EyegilLms\Services\QuestionService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/question")]
class QuestionController
{
    public function __construct(
        private QuestionService $questionService,
        private StorageService $storageService,
    ) {
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $query = $request->query();
        $association_id = $query['association_id'] ?? null;
        $module_id = $query['module_id'] ?? null;
        $type = $query['type'] ?? null;
        unset($query['association_id']);
        unset($query['module_id']);
        unset($query['type']);

        $result = $this->questionService->findSearch(
            new Pageable($query),
            $association_id,
            $module_id,
            $type,
        );

        return $result->setCollection($result->getCollection()->map(function (Question $question) {
            $questionDto = new QuestionDto();
            $questionDto->fromModel($question);
            if ($question->attachment != null) {
                $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
            }

            return $questionDto;
        }));
    }


    #[Get("/droplist")]
    public function findDropList(Request $request)
    {
        $query = $request->query();
        return $this->questionService->findDropList(
            $query['association_id'] ?? null,
            $query['module_id'] ?? null,
            $query['type'] ?? null,
        )->map(function (Question $question) {
            $questionDto = new QuestionDto();
            $questionDto->fromModel($question);
            if ($question->attachment != null) {
                $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
            }

            return $questionDto;
        });
    }

    #[Post()]
    public function save(Request $request)
    {
        $questionDto = QuestionDto::fromRequest($request)->validateSave();
        return $this->questionService->save($questionDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $questionDto = QuestionDto::fromRequest($request)->validateUpdate();
        return $this->questionService->update($questionDto);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->questionService->delete($id);
    }
}
