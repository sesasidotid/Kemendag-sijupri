<?php

namespace Eyegil\SijupriFormasi\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriFormasi\Services\UnsurService;
use Illuminate\Http\Request;

#[Controller("/api/v1/unsur")]
class UnsurController
{
    public function __construct(
        private UnsurService $unsurService
    ) {}

    #[Get("/tree/{jabatan_code}")]
    public function findUnsurTree(Request $request)
    {
        return $this->unsurService->findUnsurTree($request->jabatan_code);
    }

    #[Get("/{id}")]
    public function findById(Request $request)
    {
        return $this->unsurService->findById($request->id);
    }
}
