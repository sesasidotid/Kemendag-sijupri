<?php

namespace Eyegil\SecurityOauth2\Customs;

use Laravel\Passport\Bridge\AccessToken;

class OauthAccessToken extends AccessToken
{
    use Oauth2AccessTokenTrait;
}
