<?php

namespace Eyegil\EyegilLms\Providers;

use Illuminate\Support\ServiceProvider;

class EyegilLmsServiceProvider extends ServiceProvider
{
	public function register(): void {}

	public function boot(): void
	{
		$this->loadRoutesFrom(__DIR__ . '/../../routes/eyegil-lms-routes.php');
		$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/eyegil_02_lms.php');
	}
}
