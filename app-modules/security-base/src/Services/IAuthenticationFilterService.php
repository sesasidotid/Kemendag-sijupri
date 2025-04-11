<?php

namespace Eyegil\SecurityBase\Services;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface IAuthenticationFilterService
{
    public function handle(Request $request, Closure $next);
}
