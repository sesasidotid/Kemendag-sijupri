<?php

use Eyegil\Base\Http\Middleware\ApiResponseHandlerMiddleware;
use Eyegil\Base\Http\Middleware\CaseSupportMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(Eyegil\Base\Http\Middleware\LogTraceMiddleware::class);
        $middleware->alias([
            'response_handler' => ApiResponseHandlerMiddleware::class,
            'client' => Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
            'request_context' => Eyegil\SecurityOauth2\Http\Middleware\RequestContextMiddleware::class,
            'user_context' => App\Http\Middleware\SijupriUserContextMiddleware::class,
            'case_support' => CaseSupportMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
    })->create();
