<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\JenisKelaminService;

#[Controller("/api/v1/jenis_kelamin")]
class JenisKelaminController
{
    public function __construct(
        private JenisKelaminService $jenisKelaminService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->jenisKelaminService->findAll();
    }

    #[Controller("/{code}")]
    public function findByCode($code)
    {
        return $this->jenisKelaminService->findByCode($code);
    }
}
