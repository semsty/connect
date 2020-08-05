<?php

namespace connect\crm\amocrm\dict;

use connect\crm\base\dict\Entities as BaseEntities;

class Entities extends BaseEntities
{
    const STATUS_DEAL_SUCCESSFUL = 142;
    const STATUS_DEAL_REJECTED = 143;

    const PIPELINE = 'pipeline';
    //const CUSTOM_FIELD = 'field';

    public static function dictEntityTypes()
    {
        return [
            static::CONTACT => 'contact',
            static::LEAD => 'lead',
            static::NOTE => 'event',
            static::COMPANY => 'company',
            static::TASK => 'task',
            static::CALL => 'call',
            static::CUSTOM_FIELD => 'custom_field',
            static::PIPELINE => 'pipeline'
        ];
    }
}
