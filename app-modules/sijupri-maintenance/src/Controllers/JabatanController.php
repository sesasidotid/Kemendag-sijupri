<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\JabatanService;

#[Controller("/api/v1/jabatan")]
class JabatanController
{
    public function __construct(
        private JabatanService $jabatanService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->jabatanService->findAll();
    }

    #[Get("/{code}")]
    public function findByCode($code)
    {
        return $this->jabatanService->findByCode($code);
    }

    #[Get("/jenjang/{jenjang_code}")]
    public function findByJenjangCode($jenjang_code)
    {
        return $this->jabatanService->findByJenjangCode($jenjang_code);
    }
}
