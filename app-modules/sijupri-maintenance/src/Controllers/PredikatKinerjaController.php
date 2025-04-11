<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\PredikatKinerjaService;

#[Controller("/api/v1/predikat_kinerja")]
class PredikatKinerjaController
{
    public function __construct(
        private PredikatKinerjaService $predikatKinerjaService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->predikatKinerjaService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->predikatKinerjaService->findById($id);
    }
}
