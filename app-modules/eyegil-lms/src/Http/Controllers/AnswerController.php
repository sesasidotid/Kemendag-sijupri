<?php

namespace Eyegil\EyegilLms\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\EyegilLms\Services\AnswerService;
use Illuminate\Http\Request;

#[Controller("/api/v1/anwer")]
class AnswerController
{
    public function __construct(
        private AnswerService $answerService,
    ) {}

    #[Post()]
    public function save(Request $request)
    {
        $answerDto = AnswerDto::fromRequest($request)->validateSave();
        return $this->answerService->save($answerDto);
    }
}
