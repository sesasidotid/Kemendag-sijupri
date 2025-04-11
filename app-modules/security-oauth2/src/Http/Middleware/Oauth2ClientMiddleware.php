<?php

namespace Eyegil\SecurityOauth2\Http\Middleware;

use Closure;
use Eyegil\Base\Exceptions\BusinessException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;

class Oauth2ClientMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = request()->header('Authorization');
        if ($authHeader && strpos($authHeader, 'Basic ') === 0) {
            $base64Credentials = substr($authHeader, 6);
            $credentials = base64_decode($base64Credentials);

            list($username, $password) = explode(':', $credentials, 2);

            $request->merge(['client_id' => $username]);
            $request->merge(['client_secret' => $password]);
            $grant_type = $request->input('grant_type');

            $oauthConfig = config('eyegil.security.oauth2.clients') ?? [];
            $clientConfig = $oauthConfig[$request['client_id']] ?? null;

            if ($clientConfig) {
                Passport::tokensExpireIn(now()->addSeconds($clientConfig['accessTokenLifetime'] ?? 3600));
                Passport::refreshTokensExpireIn(now()->addSeconds($clientConfig['refreshTokenLifetime'] ?? (3600 * 24) * 7));
                if (!in_array($grant_type, $clientConfig['grants'] ?? [])) {
                    throw new BusinessException("Invalid grant_type", "", ["grant_type" => $grant_type]);
                }
            }

            return $next($request);
        } else {
            return throw new BusinessException("Un-Authorized", "AUTH");
        }
    }
}
