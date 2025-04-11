<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\KategoriPengembanganService;

#[Controller("/api/v1/kategori_pengembangan")]
class KategoriPengembanganController
{
    public function __construct(
        private KategoriPengembanganService $kategoriPengembanganService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->kategoriPengembanganService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->kategoriPengembanganService->findById($id);
    }
}
