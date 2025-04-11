<?php

namespace Eyegil\EyegilLms\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Services\QuestionService;
use Illuminate\Http\Request;

#[Controller("/api/v1/question")]
class QuestionController
{
    public function __construct(
        private QuestionService $questionService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->questionService->findSearch(new Pageable($request->query()));
    }


    #[Get("/droplist")]
    public function findDropList(Request $request)
    {
        $query = $request->query();
        return $this->questionService->findDropList(
            $query['association_id'] ?? null,
            $query['module_id'] ?? null,
            $query['type'] ?? null,
        );
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
}
