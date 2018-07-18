<?php

namespace connect\crm\custom;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public static function getRequiredKeys(): array
    {
        return ArrayHelper::merge(parent::getRequiredKeys(), [
            'custom_config'
        ]);
    }
}
