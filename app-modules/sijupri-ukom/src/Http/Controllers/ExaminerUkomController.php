<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Dtos\ExaminerUkomDto;
use Eyegil\SijupriUkom\Services\ExaminerUkomService;
use Illuminate\Http\Request;

#[Controller("/api/v1/examiner_ukom")]
class ExaminerUkomController
{
    public function __construct(
        private ExaminerUkomService $examinerUkomService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->examinerUkomService->findSearch(new Pageable($request->query()));
    }

    #[Get("/{id}")]
    public function findById(Request $request)
    {
        return $this->examinerUkomService->findById($request->id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $examinerUkomDto = ExaminerUkomDto::fromRequest($request)->validateSaveExaminer();
        return $this->examinerUkomService->save($examinerUkomDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $examinerUkomDto = ExaminerUkomDto::fromRequest($request)->validateUpdateExaminer();
        return $this->examinerUkomService->update($examinerUkomDto);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->examinerUkomService->delete($id);
    }
}
