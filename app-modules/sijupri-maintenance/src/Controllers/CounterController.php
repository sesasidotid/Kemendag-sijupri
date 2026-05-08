<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\SijupriMaintenance\Services\CounterService;
use Illuminate\Http\Request;

#[Controller("/api/v1/counter")]
class CounterController
{
    public function __construct(
        private CounterService $counterService
    ) {
    }

    #[Get("/{code}")]
    public function findById($code)
    {
        return $this->counterService->findByCode($code);
    }

    #[Put("/{code}")]
    public function update(string $code, Request $request)
    {
        return $this->counterService->update($code, $request->value);
    }
}
