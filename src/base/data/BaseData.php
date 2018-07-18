<?php

namespace connect\crm\base\data;

use yii\base\BaseObject;

class BaseData extends BaseObject
{
    const ID = 'id';
    const NAME = 'name';
    const PHONE = 'phone_number';
    const EMAIL = 'email';
    const PROFILE_ID = 'external_profile_id';
    const TIME_CREATED = 'time_created';
    const TIME_UPDATED = 'time_created';

    const EMPTY_NOT_SET = '(not set)';
    const EMPTY_DASH = '-';
    const EMPTY_DASH_2 = '–';
    const EMPTY_LINE = '';
    const EMPTY_NONE = 'none';

    public static function all(): array
    {
        return [];
    }
}
