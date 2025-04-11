<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\SijupriUkom\Services\ExamTypeService;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam_type")]
class ExamTypeController
{
    public function __construct(
        private ExamTypeService $examTypeService,
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->examTypeService->findAll();
    }

    #[Get("/{id}")]
    public function findByCode($id)
    {
        return $this->examTypeService->findByCode($id);
    }
}
