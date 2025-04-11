<?php

namespace Eyegil\NotificationFirebase\Providers;

use Eyegil\NotificationBase\Services\NotificationDriverServiceMap;
use Eyegil\NotificationBase\Services\NotificationMessageService;
use Eyegil\NotificationBase\Services\NotificationServiceMap;
use Eyegil\NotificationBase\Services\NotificationSubscriptionService;
use Eyegil\NotificationBase\Services\NotificationTopicService;
use Eyegil\NotificationFirebase\Services\FirebaseCMEngineService;
use Eyegil\NotificationFirebase\Services\FirebaseMessageTokenService;
use Eyegil\NotificationFirebase\Services\NotificationFirebaseService;
use Illuminate\Support\ServiceProvider;

class NotificationFirebaseServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(NotificationFirebaseService::class, function ($app) {
			return new NotificationFirebaseService(
				$app->make(FirebaseMessageTokenService::class),
				$app->make(FirebaseCMEngineService::class),
				$app->make(NotificationSubscriptionService::class),
				$app->make(NotificationTopicService::class),
				$app->make(NotificationDriverServiceMap::class),
			);
		});

		$this->app->afterResolving(NotificationServiceMap::class, function (NotificationServiceMap $map) {
			$map->put('firebase', $this->app->make(NotificationFirebaseService::class));
		});
	}
	
	public function boot(): void
	{
	}
}
