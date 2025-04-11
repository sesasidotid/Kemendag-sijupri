<?php

namespace App\Providers;

use App\Http\Middleware\MobileAuthenticationFilterMiddleware;
use App\Http\Middleware\RefreshMobileAuthenticationFilterMiddleware;
use App\Http\Middleware\RefreshSecurityAuthenticationFIlterMiddleware;
use App\Http\Middleware\SecurityAuthenticationFIlterMiddleware;
use App\Http\Middleware\SIUkomAuthenticationFilterMiddleware;
use Eyegil\SecurityBase\Services\DeviceService;
use Eyegil\NotificationFirebase\Services\FirebaseMessageTokenService;
use Eyegil\NotificationFirebase\Services\NotificationFirebaseService;
use Eyegil\SecurityBase\Services\AuthenticationFilterServiceMap;
use Eyegil\SecurityBase\Services\UserApplicationChannelService;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SecurityAuthenticationFIlterMiddleware::class, function ($app) {
            return new SecurityAuthenticationFIlterMiddleware(
                $app->make(DeviceService::class),
                $app->make(UserApplicationChannelService::class),
                $app->make(UserAuthenticationService::class),
            );
        });

        $this->app->singleton(MobileAuthenticationFilterMiddleware::class, function ($app) {
            return new MobileAuthenticationFilterMiddleware(
                $app->make(DeviceService::class),
                $app->make(FirebaseMessageTokenService::class),
                $app->make(NotificationFirebaseService::class),
                $app->make(UserApplicationChannelService::class),
                $app->make(UserAuthenticationService::class),
            );
        });
        $this->app->singleton(RefreshSecurityAuthenticationFIlterMiddleware::class, function ($app) {
            return new RefreshSecurityAuthenticationFIlterMiddleware(
                $app->make(DeviceService::class),
                $app->make(UserApplicationChannelService::class),
                $app->make(UserAuthenticationService::class)
            );
        });

        $this->app->singleton(RefreshMobileAuthenticationFilterMiddleware::class, function ($app) {
            return new RefreshMobileAuthenticationFilterMiddleware(
                $app->make(DeviceService::class),
                $app->make(FirebaseMessageTokenService::class),
                $app->make(NotificationFirebaseService::class),
                $app->make(UserApplicationChannelService::class),
                $app->make(UserAuthenticationService::class),
            );
        });

        $this->app->afterResolving(AuthenticationFilterServiceMap::class, function (AuthenticationFilterServiceMap $map) {
            $map->put('sijupri-web', $this->app->make(SecurityAuthenticationFIlterMiddleware::class));
            $map->put('sijupri-jf-mobile', $this->app->make(MobileAuthenticationFilterMiddleware::class));
            $map->put('sijupri-web-refresh', $this->app->make(RefreshSecurityAuthenticationFIlterMiddleware::class));
            $map->put('sijupri-jf-mobile-refresh', $this->app->make(RefreshMobileAuthenticationFilterMiddleware::class));
            $map->put('siukom-participant', $this->app->make(SIUkomAuthenticationFilterMiddleware::class));
            $map->put('siukom-participant-refresh', $this->app->make(SIUkomAuthenticationFilterMiddleware::class));
            $map->put('siukom-examiner', $this->app->make(SIUkomAuthenticationFilterMiddleware::class));
            $map->put('siukom-examiner-refresh', $this->app->make(SIUkomAuthenticationFilterMiddleware::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
