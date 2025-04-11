<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\InstansiTypeService;

#[Controller("/api/v1/instansi_type")]
class InstansiTypeController
{
    public function __construct(
        private InstansiTypeService $instansiTypeService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->instansiTypeService->findAll();
    }

    #[Get("/{code}")]
    public function findByCode($code)
    {
        return $this->instansiTypeService->findByCode($code);
    }
}
