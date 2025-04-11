<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\JenjangService;

#[Controller("/api/v1/jenjang")]
class JenjangController
{
    public function __construct(
        private JenjangService $jenjangService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->jenjangService->findAll();
    }

    #[Get("/jabatan/{jabatan_code}")]
    public function findByJabatanCode($jabatan_code)
    {
        return $this->jenjangService->findByJabatanCode($jabatan_code);
    }

    #[Get("/{code}")]
    public function findBycode($code)
    {
        return $this->jenjangService->findBycode($code);
    }

    #[Get("/next/{code}")]
    public function findNextBycode($code)
    {
        return $this->jenjangService->findNextBycode($code);
    }
}
