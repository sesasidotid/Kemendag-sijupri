<?php

namespace Eyegil\SecurityOauth2\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Laravel\Passport\Http\Controllers\AccessTokenController as AccessTokenControllerOriginal;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\TokenRepository;
use Nyholm\Psr7\Response as Psr7Response;

class AccessTokenController extends AccessTokenControllerOriginal
{

    public function __construct(
        AuthorizationServer $server,
        TokenRepository $tokens
    ) {
        parent::__construct($server, $tokens);
    }

    public function issueToken(ServerRequestInterface $request)
    {
        $body = $request->getParsedBody();
        return $this->withErrorHandling(function () use ($request, $body) {
            $result = $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
            $content = json_decode($result->getContent(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Failed to decode JSON response content: ' . json_last_error_msg());
            }

            if (isset($body['details']) && is_array($body['details'])) {
                $content = array_merge($content, $body['details']);
            }

            return response()->json($content);
        });
    }
}
