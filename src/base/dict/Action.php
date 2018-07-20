<?php

namespace connect\crm\base\dict;

class Action extends Dictionary
{
    const DICT_NAME = 'actions';

    const NAME_DELIMITER = '-';
    const AUTH = 'auth';
    const INFO = 'info';
    const GET = 'get';
    const LIST = 'list';
    const CREATE = 'create';
    const UPDATE = 'update';
    const DELETE = 'delete';
    const SET = 'set'; #create or update
    const BASE = 'base';

    public static function dictActions()
    {
        return [
            static::AUTH,
            static::INFO,
            static::GET,
            static::LIST,
            static::CREATE,
            static::UPDATE,
            static::DELETE,
            static::SET
        ];
    }
}
