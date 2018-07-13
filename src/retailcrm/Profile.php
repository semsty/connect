<?php

namespace semsty\connect\retailcrm;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public static function getRequiredKeys(): array
    {
        return ArrayHelper::merge(parent::getRequiredKeys(), [
            'apiKey', 'subdomain'
        ]);
    }
}
