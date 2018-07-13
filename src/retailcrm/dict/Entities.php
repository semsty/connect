<?php

namespace semsty\connect\retailcrm\dict;

use semsty\connect\base\dict\Entities as BaseEntities;

class Entities extends BaseEntities
{
    const CREDENTIAL = 'credential';
    const CUSTOM_FIELD = 'custom-field';
    const CUSTOM_DICTIONARY = 'custom-dictionary';
    const ORDER = 'order';
    const CUSTOMER = 'customer';
    const HISTORY = 'history';
    const STATUS = 'status';

    const CUSTOM_DICTIONARY_PLURALIZE = 'custom-dictionaries';
    const STATUS_PLURALIZE = 'statuses';

    public static function dictEntityTypes(): array
    {
        return [
            static::CREDENTIAL => 'credential',
            static::CUSTOM_FIELD => 'custom-field',
            static::CUSTOM_DICTIONARY => 'custom-dictionary',
            static::ORDER => 'order',
            static::CUSTOMER => 'customer',
            static::TASK => 'task',
            static::HISTORY => 'history'
        ];
    }

    public static function dictEntityMap(): array
    {
        return [
            static::ORDER => static::LEAD,
            static::CUSTOMER => static::CONTACT
        ];
    }
}
