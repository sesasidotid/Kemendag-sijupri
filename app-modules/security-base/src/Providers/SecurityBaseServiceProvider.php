<?php

namespace Eyegil\SecurityBase\Providers;

use Eyegil\SecurityBase\Services\ApplicationService;
use Eyegil\SecurityBase\Services\AuthenticationFilterServiceMap;
use Eyegil\SecurityBase\Services\AuthenticationServiceMap;
use Eyegil\SecurityBase\Services\AuthenticationTypeService;
use Eyegil\SecurityBase\Services\MenuService;
use Eyegil\SecurityBase\Services\RoleMenuService;
use Eyegil\SecurityBase\Services\RoleService;
use Eyegil\SecurityBase\Services\UserApplicationChannelService;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SecurityBase\Services\UserRoleService;
use Eyegil\SecurityBase\Services\UserService;
use Illuminate\Support\ServiceProvider;

class SecurityBaseServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(AuthenticationFilterServiceMap::class, function ($app) {
			return new AuthenticationFilterServiceMap();
		});

		$this->app->singleton(AuthenticationServiceMap::class, function ($app) {
			return new AuthenticationServiceMap();
		});

		$this->app->singleton(ApplicationService::class, function ($app) {
			return new ApplicationService();
		});

		$this->app->singleton(AuthenticationTypeService::class, function ($app) {
			return new AuthenticationTypeService();
		});

		$this->app->singleton(UserRoleService::class, function ($app) {
			return new UserRoleService();
		});

		$this->app->singleton(RoleMenuService::class, function ($app) {
			return new RoleMenuService();
		});

		$this->app->singleton(UserApplicationChannelService::class, function ($app) {
			return new UserApplicationChannelService();
		});

		$this->app->singleton(UserService::class, function ($app) {
			return new UserService($app->make(UserRoleService::class), $app->make(UserApplicationChannelService::class));
		});

		$this->app->singleton(RoleService::class, function ($app) {
			return new RoleService($app->make(RoleMenuService::class));
		});

		$this->app->singleton(MenuService::class, function ($app) {
			return new MenuService();
		});

		$this->app->bind(UserAuthenticationService::class, function ($app) {
			return new UserAuthenticationService($app->make(UserService::class), $app->make(MenuService::class), $app->make(UserRoleService::class), $app->make(RoleMenuService::class), $app->make(AuthenticationServiceMap::class));
		});
	}

	public function boot(): void
	{
	}
}
