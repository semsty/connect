<?php

namespace semsty\connect\bitrix24\dict;

use semsty\connect\base\dict\Entities as BaseEntities;

class Entities extends BaseEntities
{
    const CUSTOM_FIELD = 'user_field';

    const ACTIVITY = 'activity';

    public static function dictEntityTypes()
    {
        return [
            static::CONTACT => 'contact',
            static::LEAD => 'lead',
            static::DEAL => 'deal',
            static::COMPANY => 'company',
            static::CUSTOM_FIELD => 'user-field',
            static::NOTE => static::ACTIVITY
        ];
    }
}
