<?php

namespace Eyegil\SijupriAkp\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriAkp\Services\MatrixService;

#[Controller("/api/v1/akp_matrix")]
class MatrixController
{
    public function __construct(
        private MatrixService $matrixService
    ) {}


    #[Get()]
    public function findByNip($nip)
    {
        return $this->matrixService->findByNip($nip);
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->matrixService->findById($id);
    }
}
