<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\SijupriUkom\Dtos\UkomModuleQuestionDto;
use Eyegil\SijupriUkom\Services\UkomModuleService;
use Illuminate\Http\Request;

#[Controller("/api/v1/ukom_module")]
class UkomModuleController
{
    public function __construct(
        private UkomModuleService $ukomModuleService,
    ) {}

    #[Get("/download/{exam_type}")]
    public function downloadTemplate($exam_type)
    {
        return $this->ukomModuleService->downloadTemplate($exam_type);
    }

    #[Post("/save/bulk")]
    public function uploadQuestion(Request $request)
    {
        $ukomModuleQuestionDto = UkomModuleQuestionDto::fromRequest($request);
        return $this->ukomModuleService->saveQuestion($ukomModuleQuestionDto);
    }
}
