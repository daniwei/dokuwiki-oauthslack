<?php

use dokuwiki\plugin\oauth\Adapter;
use dokuwiki\plugin\oauthslack\DotAccess;
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

        $result = json_decode($oauth->request('https://slack.com/api/openid.connect.userInfo'), true);
        
        $data['user'] = $result['name'];
        $data['name'] = $result['given_name'];
        $data['mail'] = $result['email'];
        $data['grps'] = $result['naprofileme'];

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
        $label = 'Slack';
        return $label;
    }

    /** @inheritDoc */
    public function getColor()
    {
        $color = '#4A154B';
        return $color;    
    }
}
