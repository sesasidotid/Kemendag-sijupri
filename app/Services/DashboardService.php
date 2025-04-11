<?php

namespace App\Services;

use Carbon\Carbon;
use Eyegil\NotificationBase\Services\NotificationService;
use Eyegil\SijupriUkom\Models\ParticipantUkom;

class DashboardService
{

    public function __construct(
        private NotificationService $notificationService,
    ) {}

    public function getParticipantUkomCountByMonth()
    {
        $current_date = Carbon::now();
        $months = collect();

        for ($i = 11; $i >= 0; $i--) {
            $date = $current_date->copy()->subMonths($i);

            $count = ParticipantUkom::whereYear('date_created', $date->year)
                ->whereMonth('date_created', $date->month)
                ->count();

            $months->push([
                'month' => $date->format('F'),
                'year' => $date->format('Y'),
                'count' => $count
            ]);
        }

        return $months;
    }
}
