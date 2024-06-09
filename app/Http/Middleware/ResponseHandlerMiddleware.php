<?php

namespace App\Http\Middleware;

use App\Exceptions\BusinessException;
use Closure;
use Illuminate\Support\Facades\Log;
use Throwable;

class ResponseHandlerMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (!empty($response->exception)) {
            $e = $response->exception;
            Log::error("unknowns error : {$e->getMessage()}");
            if ($response->exception instanceof BusinessException) {
                session()->flash('response', [
                    'title' => 'Error',
                    'message' => $e->getMessage(),
                    'icon' => 'error',
                ]);
                return redirect()->back();
            } else {
                session()->flash('response', [
                    'title' => 'Error',
                    'message' => 'something went wrong',
                    'icon' => 'error',
                ]);
                return redirect()->back();
            }
        }

        return $response;
    }
}
