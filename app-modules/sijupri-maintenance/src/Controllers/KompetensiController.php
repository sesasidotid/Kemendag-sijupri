<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\KompetensiDto;
use Eyegil\SijupriMaintenance\Services\KompetensiService;
use Illuminate\Http\Request;

#[Controller("/api/v1/kompetensi")]
class KompetensiController
{
    public function __construct(
        private KompetensiService $kompetensiService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->kompetensiService->findSearch(new Pageable($request->query()));
    }

    #[Get("/droplist")]
    public function findDropList(Request $request)
    {
        $query = $request->query();
        return $this->kompetensiService->findDropList(
            $query['jabatan_code'] ?? null,
            $query['jenjang_code'] ?? null,
            $query['bidang_jabatan_code'] ?? null,
        );
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->kompetensiService->findById($id);
    }

    #[Get("/code/{code}")]
    public function findByCode($code)
    {
        return $this->kompetensiService->findByCode($code);
    }

    #[Post()]
    public function save(Request $request)
    {
        $kompetensiDto = KompetensiDto::fromRequest($request)->validateSave();
        return $this->kompetensiService->save($kompetensiDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $kompetensiDto = KompetensiDto::fromRequest($request)->validateUpdate();
        return $this->kompetensiService->update($kompetensiDto);
    }
}
