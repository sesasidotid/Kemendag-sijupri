<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\KategoriSertifikasiService;

#[Controller("/api/v1/kategori_sertifikasi")]
class KategoriSertifikasiController
{
    public function __construct(
        private KategoriSertifikasiService $kategoriSertifikasiService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->kategoriSertifikasiService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->kategoriSertifikasiService->findById($id);
    }
}
