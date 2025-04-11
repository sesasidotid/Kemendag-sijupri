<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\PendidikanService;

#[Controller("/api/v1/pendidikan")]
class PendidikanController
{
    public function __construct(
        private PendidikanService $pendidikanService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->pendidikanService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->pendidikanService->findById($id);
    }
}
