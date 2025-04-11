<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriMaintenance\Services\RatingKinerjaService;

#[Controller("/api/v1/rating_kinerja")]
class RatingKinerjaController
{
    public function __construct(
        private RatingKinerjaService $ratingKinerjaService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->ratingKinerjaService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->ratingKinerjaService->findById($id);
    }
}
