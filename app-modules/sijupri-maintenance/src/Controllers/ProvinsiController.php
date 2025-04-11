<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\ProvinsiDto;
use Eyegil\SijupriMaintenance\Services\ProvinsiService;
use Illuminate\Http\Request;

#[Controller("/api/v1/provinsi")]
class ProvinsiController
{
    public function __construct(
        private ProvinsiService $provinsiService
    ) {}

    #[Get("search")]
    public function findSearch(Request $request)
    {
        $query = $request->query();
        $query['eq_delete_flag'] = false;
        $query['eq_inactive_flag'] = false;
        return $this->provinsiService->findSearch(new Pageable($query));
    }

    #[Get()]
    public function findAll()
    {
        return $this->provinsiService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->provinsiService->findById($id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $provinsiDto = ProvinsiDto::fromRequest($request)->validateSave();
        return $this->provinsiService->save($provinsiDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $provinsiDto = ProvinsiDto::fromRequest($request)->validateUpdate();
        return $this->provinsiService->update($provinsiDto);
    }
}
