<?php

namespace Eyegil\NotificationSmtp\Providers;

use Eyegil\NotificationBase\Services\NotificationServiceMap;
use Eyegil\NotificationBase\Services\NotificationSubscriptionService;
use Eyegil\NotificationBase\Services\NotificationTopicService;
use Eyegil\NotificationSmtp\Services\NotificationSMTPService;
use Eyegil\SecurityBase\Services\UserService;
use Illuminate\Support\ServiceProvider;

class NotificationSmtpServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(NotificationSMTPService::class, function ($app) {
			return new NotificationSMTPService(
				$app->make(UserService::class),
				$app->make(NotificationSubscriptionService::class),
				$app->make(NotificationTopicService::class)
			);
		});

		$this->app->afterResolving(NotificationServiceMap::class, function (NotificationServiceMap $map) {
			$map->put('smtp', $this->app->make(NotificationSMTPService::class));
		});
	}

	public function boot(): void {}
}
