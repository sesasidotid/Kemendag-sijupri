<?php

namespace Eyegil\SecurityPassword\Providers;

use Eyegil\SecurityBase\Services\AuthenticationServiceMap;
use Eyegil\SecurityPassword\Services\PasswordAuthenticationService;
use Eyegil\SecurityPassword\Services\PasswordService;
use Illuminate\Support\ServiceProvider;

class SecurityPasswordServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(PasswordService::class, function ($app) {
			return new PasswordService();
		});

		$this->app->singleton(PasswordAuthenticationService::class, function ($app) {
			return new PasswordAuthenticationService(
				$app->make(PasswordService::class)
			);
		});

		$this->app->afterResolving(AuthenticationServiceMap::class, function (AuthenticationServiceMap $map) {
			$map->put('password', $this->app->make(PasswordAuthenticationService::class));
		});
	}

	public function boot(): void
	{
		$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/eyegil_02_security_password.php');
		$this->loadRoutesFrom(__DIR__ . '/../../routes/security-password-routes.php');
	}
}
