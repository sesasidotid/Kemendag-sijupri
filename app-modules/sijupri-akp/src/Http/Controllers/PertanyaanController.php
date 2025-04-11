<?php

namespace Eyegil\SijupriAkp\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriAkp\Dtos\PertanyaanDto;
use Eyegil\SijupriAkp\Services\PertanyaanService;
use Illuminate\Http\Request;

#[Controller("/api/v1/pertanyaan")]
class PertanyaanController
{
    public function __construct(
        private PertanyaanService $peertanyaanService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->peertanyaanService->findSearch(new Pageable($request->query()));
    }

    #[Get()]
    public function findAll()
    {
        return $this->peertanyaanService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->peertanyaanService->findById($id);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->peertanyaanService->delete($id);
    }
}
