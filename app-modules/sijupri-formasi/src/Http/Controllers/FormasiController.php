<?php

namespace Eyegil\SijupriFormasi\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriFormasi\Converters\FormasiConverter;
use Eyegil\SijupriFormasi\Converters\FormasiDetailConverter;
use Eyegil\SijupriFormasi\Dtos\FormasiJabatanDto;
use Eyegil\SijupriFormasi\Enums\FormasiStatus;
use Eyegil\SijupriFormasi\Models\Formasi;
use Eyegil\SijupriFormasi\Services\FormasiService;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/formasi")]
class FormasiController
{
    public function __construct(
        private FormasiService $formasiService,
        private StorageService $storageService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $search = $this->formasiService->findSearch(new Pageable($request->query()));
        return $search->setCollection($search->getCollection()->map(function (Formasi $formasi) {
            $formasiArray = $formasi->toArray();
            $formasiArray['unit_kerja_name'] = $formasi->unitKerja->name;

            return $formasiArray;
        }));
    }

    #[Get("/{id}")]
    public function findById(Request $request)
    {
        return FormasiConverter::toDtoWithDocumentStorage($this->formasiService->findById($request->id), $this->storageService);
    }

    #[Get("/unit_kerja/{unit_kerja_id}")]
    public function findByUnitKerjaId(Request $request)
    {
        return FormasiConverter::toDtoWithStorage($this->formasiService->findByUnitKerjaId($request->unit_kerja_id), $this->storageService);
    }

    #[Get("/{unit_kerja_id}/{jabatan_code}")]
    public function findByUnitKerjaIdAndJabatanCode(Request $request)
    {
        return $this->formasiService->findByUnitKerjaIdAndJabatanCode($request->unit_kerja_id, $request->jabatan_code);
    }

    #[Get("/calculate/provinsi/{provinsi_id}")]
    public function calculateProvinsi($provinsi_id)
    {
        return $this->formasiService->calculateProvinsi($provinsi_id);
    }

    #[Get("/calculate/kab_kota/{kab_kota_id}")]
    public function calculateKabKota($kab_kota_id)
    {
        return $this->formasiService->calculateKabKota($kab_kota_id);
    }

    #[Get("/calculate/unit_kerja/{unit_kerja_id}")]
    public function calculateUnitKerja($unit_kerja_id)
    {
        return $this->formasiService->calculateUnitKerja($unit_kerja_id);
    }
}
