<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\SijupriMaintenance\Services\PeriodePendaftaranService;
use Illuminate\Http\Request;

#[Controller("/api/v1/periode_pendaftaran")]
class PeriodePendaftaranController
{
    public function __construct(
        private PeriodePendaftaranService $periodePendaftaranService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->periodePendaftaranService->findAll();
    }

    #[Get("/switch")]
    public function switchActivation($id)
    {
        return $this->periodePendaftaranService->switchActivation($id);
    }

    #[Get("/{id}}")]
    public function findById($id)
    {
        return $this->periodePendaftaranService->findById($id);
    }

    #[Post()]
    public function save(Request $request)
    {
        return $this->periodePendaftaranService->save($request->all());
    }

    #[Put()]
    public function update(Request $request)
    {
        return $this->periodePendaftaranService->update($request->all());
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->periodePendaftaranService->delete($request->id);
    }
}
