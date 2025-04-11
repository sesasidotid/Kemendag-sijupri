<?php

namespace Eyegil\SecurityBase\Http\Middleware;

use Closure;
use Exception;
use Eyegil\SecurityBase\Services\AuthenticationFilterServiceMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Server\CryptTrait;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationFilterMapMiddleware
{
    use CryptTrait;

    public function __construct(
        private AuthenticationFilterServiceMap $authenticationFilterServiceMap,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($request['grant_type'] == "refresh_token") {
            $this->setEncryptionKey(app('encrypter')->getKey());
            $refreshTokenData = $this->decrypt($request['refresh_token']);
            $user_id = json_decode($refreshTokenData, true)['user_id'];
            $request->merge(['username' => $user_id]);
            return $this->authenticationFilterServiceMap->get($request['client_id'] . '-refresh')->handle($request, $next);
        } else {
            return $this->authenticationFilterServiceMap->get($request['client_id'])->handle($request, $next);
        }
    }
}
