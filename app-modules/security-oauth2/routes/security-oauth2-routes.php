<?php

use Eyegil\Base\Http\Middleware\CaseSupportMiddleware;
use Eyegil\SecurityOauth2\Http\Middleware\Oauth2ClientMiddleware;
use Eyegil\SecurityBase\Http\Middleware\AuthenticationFilterMapMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => '\Eyegil\SecurityOauth2\Http\Controllers',
], function () {

    Route::middleware(['response_handler', CaseSupportMiddleware::class, Oauth2ClientMiddleware::class])->group(function () {
        Route::post('/token', [
            'uses' => 'AccessTokenController@issueToken',
            'as' => 'token',
            'middleware' => ['throttle', AuthenticationFilterMapMiddleware::class],
        ]);

        Route::get('/authorize', [
            'uses' => 'AuthorizationController@authorize',
            'as' => 'authorizations.authorize',
            'middleware' => 'web',
        ]);

        $guard = config('passport.guard', null);

        Route::middleware(['web', $guard ? 'auth:' . $guard : 'auth'])->group(function () {
            Route::post('/token/refresh', [
                'uses' => 'TransientTokenController@refresh',
                'as' => 'token.refresh',
            ]);

            Route::post('/authorize', [
                'uses' => 'ApproveAuthorizationController@approve',
                'as' => 'authorizations.approve',
            ]);

            Route::delete('/authorize', [
                'uses' => 'DenyAuthorizationController@deny',
                'as' => 'authorizations.deny',
            ]);

            Route::get('/tokens', [
                'uses' => 'AuthorizedAccessTokenController@forUser',
                'as' => 'tokens.index',
            ]);

            Route::delete('/tokens/{token_id}', [
                'uses' => 'AuthorizedAccessTokenController@destroy',
                'as' => 'tokens.destroy',
            ]);

            Route::get('/clients', [
                'uses' => 'ClientController@forUser',
                'as' => 'clients.index',
            ]);

            Route::post('/clients', [
                'uses' => 'ClientController@store',
                'as' => 'clients.store',
            ]);

            Route::put('/clients/{client_id}', [
                'uses' => 'ClientController@update',
                'as' => 'clients.update',
            ]);

            Route::delete('/clients/{client_id}', [
                'uses' => 'ClientController@destroy',
                'as' => 'clients.destroy',
            ]);

            Route::get('/scopes', [
                'uses' => 'ScopeController@all',
                'as' => 'scopes.index',
            ]);

            Route::get('/personal-access-tokens', [
                'uses' => 'PersonalAccessTokenController@forUser',
                'as' => 'personal.tokens.index',
            ]);

            Route::post('/personal-access-tokens', [
                'uses' => 'PersonalAccessTokenController@store',
                'as' => 'personal.tokens.store',
            ]);

            Route::delete('/personal-access-tokens/{token_id}', [
                'uses' => 'PersonalAccessTokenController@destroy',
                'as' => 'personal.tokens.destroy',
            ]);
        });
    });
});
