<?php

namespace App\Http\Middleware;

use Closure;
use Eyegil\Base\Http\Middleware\UserContextMiddleware;
use Eyegil\Base\UserContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SijupriUserContextMiddleware extends UserContextMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {
        $request_context = $request->attributes->get('request_context');
        $userContext = new UserContext();
        $userContext->id = $request_context['user_id'] ?? $request_context['id'] ?? null;
        $userContext->menu_codes = $request_context['menu_codes'] ?? null;
        $userContext->role_codes = $request_context['role_codes'] ?? null;
        $userContext->application_code = $request_context['application_code'] ?? null;
        $userContext->details['unit_kerja_id'] = $request_context['unit_kerja_id'] ?? null;
        $userContext->details['instansi_id'] = $request_context['instansi_id'] ?? null;
        $userContext->details['participant_id'] = $request_context['participant_id'] ?? null;
        $request->attributes->set("user_context", $userContext);
        $request->attributes->remove('request_context');
        Log::info("User Context created :: " . json_encode($userContext));
        return $next($request);
    }
}
