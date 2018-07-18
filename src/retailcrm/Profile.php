<?php

namespace connect\crm\retailcrm;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public static function getRequiredKeys(): array
    {
        return ArrayHelper::merge(parent::getRequiredKeys(), [
            'apiKey', 'subdomain'
        ]);
    }
}
