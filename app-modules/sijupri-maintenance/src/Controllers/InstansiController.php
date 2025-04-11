<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Services\InstansiService;
use Illuminate\Http\Request;

#[Controller("/api/v1/instansi")]
class InstansiController
{
    public function __construct(
        private InstansiService $instansiService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->instansiService->findSearch(new Pageable($request->query()));
    }

    #[Get()]
    public function findAll()
    {
        return $this->instansiService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->instansiService->findById($id);
    }

    #[Get("/type/{instansi_type_code}")]
    public function findByInstansiTypeCode(Request $request)
    {
        return $this->instansiService->findByInstansiTypeCode($request->instansi_type_code);
    }

    #[Get("/provinsi/{provinsi_id}")]
    public function findByProvinsiId(Request $request)
    {
        return $this->instansiService->findByProvinsiId($request->provinsi_id);
    }

    #[Get("/kab_kota/{kabupaten_kota_id}")]
    public function findByKabupatenKotaiId(Request $request)
    {
        return $this->instansiService->findByKabupatenKotaiId($request->kabupaten_kota_id);
    }

    #[Post()]
    public function save(Request $request)
    {
        return $this->instansiService->save($request->all());
    }

    #[Put()]
    public function update(Request $request)
    {
        return $this->instansiService->update($request->all());
    }

    #[Delete()]
    public function delete(Request $request)
    {
        return $this->instansiService->delete($request->id);
    }
}
