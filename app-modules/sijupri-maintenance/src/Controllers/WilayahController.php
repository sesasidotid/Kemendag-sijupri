<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\WilayahService;

#[Controller("/api/v1/wilayah")]
class WilayahController
{
    public function __construct(
        private WilayahService $wilayahService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->wilayahService->findAll();
    }

    #[Get("/{code}")]
    public function findByCode($code)
    {
        return $this->wilayahService->findByCode($code);
    }
}
