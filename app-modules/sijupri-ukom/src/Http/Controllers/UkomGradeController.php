<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Converters\UkomGradeConverter;
use Eyegil\SijupriUkom\Dtos\UkomGradeDto;
use Eyegil\SijupriUkom\Dtos\UkomModuleQuestionDto;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Eyegil\SijupriUkom\Services\UkomGradeService;
use Illuminate\Http\Request;

#[Controller("/api/v1/ukom_grade")]
class UkomGradeController
{
    public function __construct(
        private UkomGradeService $ukomGradeService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $search = $this->ukomGradeService->findSearch(new Pageable($request->query()));
        return $search->setCollection($search->getCollection()->map(function (UkomGrade $ukomGrade) {
            return UkomGradeConverter::toDto($ukomGrade);
        }));
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return UkomGradeConverter::toDto($this->ukomGradeService->findById($id));
    }
}
