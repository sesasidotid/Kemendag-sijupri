<?php

namespace Eyegil\SijupriAkp\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriAkp\Services\InstrumentService;

#[Controller("/api/v1/instrument")]
class InstrumentController
{
    public function __construct(
        private InstrumentService $instrumentService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->instrumentService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->instrumentService->findById($id);
    }
}
