<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\KompetensiIndikatorDto;
use Eyegil\SijupriMaintenance\Services\KompetensiIndikatorService;
use Illuminate\Http\Request;

#[Controller("/api/v1/kompetensi_indikator")]
class KompetensiIndikatorController
{
    public function __construct(
        private KompetensiIndikatorService $kompetensiIndikatorService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->kompetensiIndikatorService->findSearch(new Pageable($request->query()));
    }

    #[Get("/droplist")]
    public function findDropList(Request $request)
    {
        $query = $request->query();
        return $this->kompetensiIndikatorService->findDropList(
            $query['jabatan_code'] ?? null,
            $query['jenjang_code'] ?? null,
            $query['bidang_jabatan_code'] ?? null,
        );
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->kompetensiIndikatorService->findById($id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $kompetensiIndikatorDto = KompetensiIndikatorDto::fromRequest($request)->validateSave();
        return $this->kompetensiIndikatorService->save($kompetensiIndikatorDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $kompetensiIndikatorDto = KompetensiIndikatorDto::fromRequest($request)->validateUpdate();
        return $this->kompetensiIndikatorService->update($kompetensiIndikatorDto);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->kompetensiIndikatorService->delete($id);
    }
}
