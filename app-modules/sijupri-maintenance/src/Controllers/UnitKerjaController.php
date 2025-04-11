<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\UnitKerjaDto;
use Eyegil\SijupriMaintenance\Services\UnitKerjaService;
use Illuminate\Http\Request;

#[Controller("/api/v1/unit_kerja")]
class UnitKerjaController
{
    public function __construct(
        private UnitKerjaService $unitKerjaService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->unitKerjaService->findSearch(new Pageable($request->query()));
    }

    #[Get()]
    public function findAll()
    {
        return $this->unitKerjaService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->unitKerjaService->findById($id);
    }

    #[Get("/instansi/{instansi_id}")]
    public function findByInstansiId($instansi_id)
    {
        return $this->unitKerjaService->findByInstansiId($instansi_id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $unitKerjaDto = UnitKerjaDto::fromRequest($request)->validateSave();
        return $this->unitKerjaService->save($unitKerjaDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $unitKerjaDto = UnitKerjaDto::fromRequest($request)->validateSave();
        return $this->unitKerjaService->update($unitKerjaDto);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->unitKerjaService->delete($request->id);
    }
}
