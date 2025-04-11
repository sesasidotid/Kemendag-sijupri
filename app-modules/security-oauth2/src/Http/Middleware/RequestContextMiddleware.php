<?php

namespace Eyegil\SecurityOauth2\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;
use Symfony\Component\HttpFoundation\Response;

class RequestContextMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $parser = new Parser(new JoseEncoder());
        try {
            $token = $parser->parse(str_replace("Bearer ", "", $request->header("Authorization")));
        } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
            throw $e;
        }
        assert($token instanceof UnencryptedToken);
        $claims = $token->claims();
        $details = $claims->get("details");
        $request->attributes->set("request_context", $details);

        return $next($request);
    }
}
