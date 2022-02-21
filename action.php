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

        $userurl = 'https://slack.com/api/openid.connect.userInfo';
        $raw = $oauth->request($userurl);

        if (!$raw) throw new OAuthException('Failed to fetch data from userurl');
        $result = json_decode($raw, true);
        if (!$result) throw new OAuthException('Failed to parse data from userurl');
        
        $json_username = 'name';
        $json_fullname = 'given_name';
        $json_email = 'email';
        $json_groups = 'profile';
        
        $user = DotAccess::get($result, $json_username, '');
        $name = DotAccess::get($result, $json_fullname, '');
        $mail = DotAccess::get($result, $json_email, '');
        $grps = DotAccess::get($result, $json_groups, []);

        // type fixes
        if (is_array($user)) $user = array_shift($user);
        if (is_array($name)) $user = array_shift($name);
        if (is_array($mail)) $user = array_shift($mail);
        if (!is_array($grps)) {
            $grps = explode(',', $grps);
            $grps = array_map('trim', $grps);
        }

        // fallbacks for user name
        if (empty($user)) {
            if (!empty($name)) {
                $user = $name;
            } elseif (!empty($mail)) {
                list($user) = explode('@', $mail);
            }
        }

        // fallback for full name
        if (empty($name)) {
            $name = $user;
        }

        return compact('user', 'name', 'mail', 'grps');
    }

    /** @inheritdoc */
    public function getScopes()
    {
        $scopes = ['openid', 'email', 'profile'];
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
