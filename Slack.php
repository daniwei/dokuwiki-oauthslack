<?php

namespace dokuwiki\plugin\oauthslack;

use dokuwiki\plugin\oauth\Service\AbstractOAuth2Base;
use OAuth\Common\Http\Uri\Uri;
//use OAuth\OAuth2\Service\ServiceInterface;

/**
 * Custom Service for Slack oAuth
 */
class Slack extends AbstractOAuth2Base
{
    /**
     * Defined scopes
     */
    const SCOPE_OPENID = 'openid';
    const SCOPE_EMAIL = 'email';
    const SCOPE_PROFILE = 'profile';

    /** @inheritdoc */
    public function getAuthorizationEndpoint()
    {
        $authurl = 'https://slack.com/openid/connect/authorize';
        return new Uri($authurl);
    }

    /** @inheritdoc */
    public function getAccessTokenEndpoint()
    {
        $tokenurl = 'https://slack.com/api/openid.connect.token';
        return new Uri($tokenurl);
    }

    /**
     * @inheritdoc
     */
    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_HEADER_BEARER;
    }
}
