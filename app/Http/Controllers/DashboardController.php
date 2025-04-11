<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

#[Controller("/v1/dashboard")]
class DashboardController
{
    public function __construct(
        private DashboardService $dashboardService,
    ) {}


    #[Get("/participant_ukom_count")]
    public function notifyProfile()
    {
        return $this->dashboardService->getParticipantUkomCountByMonth();
    }
}
