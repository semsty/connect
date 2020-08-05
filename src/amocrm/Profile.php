<?php

namespace connect\crm\amocrm;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public function isOauth(): bool
    {
        return !empty(ArrayHelper::getValue($this->config, 'access_token'));
    }

    public function __set($name, $value)
    {
        if ($name == 'expires_in') {
            $this->setConfigPartially($name, $value);
        } else {
            parent::__set($name, $value);
        }
    }

    public static function getRequiredKeys(): array
    {
        return ArrayHelper::merge(parent::getRequiredKeys(), [
            'login', 'subdomain', 'access_token', 'refresh_token'
        ]);
    }
}
