<?php

namespace Eyegil\SecurityOauth2\Providers;

use Eyegil\SecurityOauth2\Customs\OauthAccessToken;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class SecurityOauth2ServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		Passport::ignoreRoutes();
	}

	public function boot(): void
	{
		Passport::loadKeysFrom(__DIR__ . '/../secrets/oauth');
		Passport::hashClientSecrets();
		Passport::enablePasswordGrant();
		Passport::useAccessTokenEntity(OauthAccessToken::class);
	}
}
