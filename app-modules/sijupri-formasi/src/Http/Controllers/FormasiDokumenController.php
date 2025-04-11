<?php

namespace Eyegil\SijupriFormasi\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriFormasi\Dtos\FormasiDokumenDto;
use Eyegil\SijupriFormasi\Dtos\FormasiDto;
use Eyegil\SijupriFormasi\Services\FormasiDokumenService;
use Eyegil\SijupriFormasi\Services\FormasiService;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Http\Request;

#[Controller("/api/v1/formasi_dokumen")]
class FormasiDokumenController
{
    public function __construct(
        private FormasiDokumenService $formasiDokumenService,
    ) {}

    #[Get("/all")]
    public function findAll(Request $request)
    {
        return $this->formasiDokumenService->findAll();
    }

    #[Get("/{unit_kerja_id}")]
    public function findAllByUnitKerjaId($unit_kerja_id)
    {
        return $this->formasiDokumenService->findAllByUnitKerjaId($unit_kerja_id);
    }

    #[Post("/dokumen_persyaratan")]
    public function saveDokumen(Request $request)
    {
        $formasiDokumenDto = FormasiDokumenDto::fromRequest($request);
        return $this->formasiDokumenService->saveDokumen($formasiDokumenDto);
    }
}
