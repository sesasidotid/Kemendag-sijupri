<?php

namespace Eyegil\NotificationBase\Providers;

use Eyegil\NotificationBase\Services\NotificationDriverServiceMap;
use Eyegil\NotificationBase\Services\NotificationService;
use Eyegil\NotificationBase\Services\NotificationServiceMap;
use Eyegil\NotificationBase\Services\NotificationSubscriptionService;
use Eyegil\NotificationBase\Services\NotificationTemplateService;
use Eyegil\NotificationBase\Services\NotificationTopicService;
use Illuminate\Support\ServiceProvider;

class NotificationBaseServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(NotificationServiceMap::class, function ($app) {
			return new NotificationServiceMap();
		});

		$this->app->singleton(NotificationDriverServiceMap::class, function ($app) {
			return new NotificationDriverServiceMap();
		});

		$this->app->singleton(NotificationTemplateService::class, function ($app) {
			return new NotificationTemplateService();
		});

		$this->app->singleton(NotificationTopicService::class, function ($app) {
			return new NotificationTopicService();
		});

		$this->app->singleton(NotificationSubscriptionService::class, function ($app) {
			return new NotificationSubscriptionService();
		});

		$this->app->singleton(NotificationService::class, function ($app) {
			return new NotificationService(
				$app->make(NotificationTemplateService::class),
				$app->make(NotificationServiceMap::class)
			);
		});
	}

	public function boot(): void {}
}