<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\PangkatService;

#[Controller("/api/v1/pangkat")]
class PangkatController
{
    public function __construct(
        private PangkatService $pangkatService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->pangkatService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->pangkatService->findById($id);
    }

    #[Get("/jenjang/{jenjang_code}")]
    public function findByJenjangCode($jenjang_code)
    {
        return $this->pangkatService->findByJenjangCode($jenjang_code);
    }
}
