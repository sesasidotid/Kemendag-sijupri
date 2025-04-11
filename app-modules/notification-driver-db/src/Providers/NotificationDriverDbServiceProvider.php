<?php

namespace Eyegil\NotificationDriverDb\Providers;

use Eyegil\NotificationBase\Services\NotificationDriverServiceMap;
use Eyegil\NotificationDriverDb\Services\NotificationMessageService;
use Illuminate\Support\ServiceProvider;

class NotificationDriverDbServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(NotificationMessageService::class, function ($app) {
			return new NotificationMessageService();
		});

		$this->app->afterResolving(NotificationDriverServiceMap::class, function (NotificationDriverServiceMap $map) {
			$map->put('db', $this->app->make(NotificationMessageService::class));
		});
	}

	public function boot(): void
	{
		$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/eyegil_03_notification_driver_db.php');
		$this->loadRoutesFrom(__DIR__ . '/../../routes/notification-driver-db-routes.php');
	}
}
