<?php

namespace dokuwiki\plugin\oauthslack;

use dokuwiki\plugin\oauth\Service\AbstractOAuth2Base;
use OAuth\Common\Http\Uri\Uri;

/**
 * Custom Service for Slack oAuth
 */
class Slack extends AbstractOAuth2Base
{
    /**
     * Defined scopes
     */
    
    const USERINFO_URL = 'https://slack.com/api/openid.connect.userInfo';
    
    const USERINFO_JSON_USER = 'name';
    const USERINFO_JSON_NAME = 'given_name';
    const USERINFO_JSON_MAIL = 'email';
    const USERINFO_JSON_GRPS = 'profile';
    
    const SCOPE_OPENID = 'openid';
    const SCOPE_EMAIL = 'email';
    const SCOPE_PROFILE = 'profile';

    const BUTTON_LABEL = 'Slack';
    const BUTTON_BACKGROUND_COLOR = '#4A154B';

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
