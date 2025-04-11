<?php

namespace Eyegil\SecurityOauth2\Customs;

use Illuminate\Support\Facades\Session;
use Lcobucci\JWT\UnencryptedToken;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

trait Oauth2AccessTokenTrait
{
    use AccessTokenTrait;

    private function convertToJWT(): UnencryptedToken
    {
        $this->initJwtConfiguration();

        return $this->jwtConfiguration->builder()
            ->permittedFor($this->getClient()->getIdentifier())
            ->identifiedBy($this->getIdentifier())
            ->issuedAt(new \DateTimeImmutable())
            ->canOnlyBeUsedAfter(new \DateTimeImmutable())
            ->expiresAt($this->getExpiryDateTime())
            ->relatedTo((string) request()->attributes->get('user_id'))
            ->withClaim('scopes', $this->getScopes())
            ->withClaim('details', request()->attributes->get('details') ?? [])
            ->getToken($this->jwtConfiguration->signer(), $this->jwtConfiguration->signingKey());
    }

    /**
     * Generate a string representation from the access token
     */
    public function __toString()
    {
        return $this->convertToJWT()->toString();
    }
}
