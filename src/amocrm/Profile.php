<?php

namespace semsty\connect\amocrm;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public static function getRequiredKeys(): array
    {
        return ArrayHelper::merge(parent::getRequiredKeys(), [
            'login', 'apiKey', 'subdomain'
        ]);
    }
}
