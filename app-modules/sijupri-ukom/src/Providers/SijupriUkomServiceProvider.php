<?php

namespace Eyegil\SijupriUkom\Providers;

use Eyegil\SijupriUkom\Jobs\UkomGradeJob;
use Eyegil\SijupriUkom\Services\ExamGradeService;
use Eyegil\SijupriUkom\Services\ParticipantUkomService;
use Eyegil\SijupriUkom\Services\UkomBanService;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class SijupriUkomServiceProvider extends ServiceProvider
{
	public function register(): void {}

	public function boot(): void
	{
		$this->app->bindMethod([UkomGradeJob::class, 'handle'], function (UkomGradeJob $job, Application $app) {
			return $job->handle(
				$app->make(ParticipantUkomService::class),
				$app->make(ExamGradeService::class),
				$app->make(StorageService::class),
				$app->make(StorageSystemService::class),
				$app->make(UkomBanService::class)
			);
		});
	}
}
