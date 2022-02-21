<?php

use dokuwiki\plugin\oauth\Adapter;
use dokuwiki\plugin\oauthslack\Slack;

/**
 * Service Implementation for oAuth Slack authentication
 */
class action_plugin_oauthslack extends Adapter
{

    /** @inheritdoc */
    public function registerServiceClass()
    {
        return Slack::class;
    }

    /** * @inheritDoc */
    public function getUser()
    {
        $oauth = $this->getOAuthService();
        $data = array();

        $result = json_decode($oauth->request(Slack::USERINFO_URL), true);
        
        $data['user'] = $result[Slack::USERINFO_JSON_USER];
        $data['name'] = $result[Slack::USERINFO_JSON_NAME];
        $data['mail'] = $result[Slack::USERINFO_JSON_MAIL];
        $data['grps'] = $result[Slack::USERINFO_JSON_GRPS];

        return $data;
    }

    /** @inheritdoc */
    public function getScopes()
    {
        $scopes = [Slack::SCOPE_OPENID, Slack::SCOPE_EMAIL, Slack::SCOPE_PROFILE];
        return $scopes;
    }

    /** @inheritDoc */
    public function getLabel()
    {
        return Slack::BUTTON_LABEL;
    }

    /** @inheritDoc */
    public function getColor()
    {
        return Slack::BUTTON_BACKGROUND_COLOR;
    }
}
