<?php

namespace semsty\connect\bitrix24\dict;

use semsty\connect\base\dict\Dictionary;

class Selects extends Dictionary
{
    const DICT_NAME = 'selects';

    const SELECT_ALL_SYSTEM_FIELDS = '*';
    const SELECT_ALL_USER_FIELDS = 'UF_*';

    public static function dictSelects()
    {
        return [static::SELECT_ALL_SYSTEM_FIELDS, static::SELECT_ALL_USER_FIELDS];
    }
}
