<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\SijupriMaintenance\Dtos\BidangJabatanDto;
use Eyegil\SijupriMaintenance\Services\BidangJabatanService;
use Illuminate\Http\Request;

#[Controller("/api/v1/bidang_jabatan")]
class BidangJabatanController
{
    public function __construct(
        private BidangJabatanService $bidangJabatanService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->bidangJabatanService->findAll();
    }

    #[Get("/jabatan/{jabatan_code}")]
    public function findAllByJabatan($jabatan_code)
    {
        return $this->bidangJabatanService->findAllByJabatan($jabatan_code);
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->bidangJabatanService->findById($id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $bidangJabatanDto = BidangJabatanDto::fromRequest($request)->validateSave();
        return $this->bidangJabatanService->save($bidangJabatanDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $bidangJabatanDto = BidangJabatanDto::fromRequest($request)->validateUpdate();
        return $this->bidangJabatanService->update($bidangJabatanDto);
    }

    #[Delete("/{code}")]
    public function delete($code)
    {
        return $this->bidangJabatanService->delete($code);
    }
}
