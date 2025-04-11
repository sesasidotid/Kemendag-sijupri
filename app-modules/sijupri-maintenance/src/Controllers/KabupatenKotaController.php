<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\KabupatenKotaDto;
use Eyegil\SijupriMaintenance\Services\KabupatenKotaService;
use Illuminate\Http\Request;

#[Controller("/api/v1/kab_kota")]
class KabupatenKotaController
{
    public function __construct(
        private KabupatenKotaService $kabupatenKotaService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $query = $request->query();
        $query['eq_delete_flag'] = false;
        $query['eq_inactive_flag'] = false;
        return $this->kabupatenKotaService->findSearch(new Pageable($query));
    }

    #[Get()]
    public function findAll()
    {
        return $this->kabupatenKotaService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->kabupatenKotaService->findById($id);
    }

    #[Get("/type/{type}/{provinsi_id}")]
    public function findByTypeAndProvinsiId(Request $request)
    {
        return $this->kabupatenKotaService->findByTypeAndProvinsiId($request->type, $request->provinsi_id);
    }

    #[Get("/type/kota")]
    public function findAllKota()
    {
        return $this->kabupatenKotaService->findAllKota();
    }

    #[Get("/type/kabupaten")]
    public function findAllKabupaten()
    {
        return $this->kabupatenKotaService->findAllKabupaten();
    }

    #[Post()]
    public function save(Request $request)
    {
        $kabupatenKotaDto = KabupatenKotaDto::fromRequest($request)->validateSave();
        return $this->kabupatenKotaService->save($kabupatenKotaDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $kabupatenKotaDto = KabupatenKotaDto::fromRequest($request)->validateUpdate();
        return $this->kabupatenKotaService->update($kabupatenKotaDto);
    }
}
