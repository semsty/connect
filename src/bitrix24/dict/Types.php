<?php

namespace semsty\connect\bitrix24\dict;

use semsty\connect\base\dict\Dictionary;

class Types extends Dictionary
{
    const DICT_NAME = 'types';

    const ACTIVITY_CONTACT = 2;

    const ACTIVITY_TYPE_MEETING = 1;
    const ACTIVITY_TYPE_CALL = 2;
    const ACTIVITY_TYPE_TASK = 3;
    const ACTIVITY_TYPE_MESSAGE = 4;
    const ACTIVITY_TYPE_ACTION = 5;
    const ACTIVITY_TYPE_USER_ACTION = 6;

    const OWNER_TYPE_LEAD = 1;
    const OWNER_TYPE_DEAL = 2;
    const OWNER_TYPE_CONTACT = 3;
    const OWNER_TYPE_COMPANY = 4;
    const OWNER_TYPE_SCORE = 5;
    const OWNER_TYPE_OFFER = 7;
    const OWNER_TYPE_REQUISITES = 8;

    const PHONE_TYPE_WORK = 'WORK';

    public static function dictActivityTypes(): array
    {
        return [
            static::ACTIVITY_TYPE_MEETING,
            static::ACTIVITY_TYPE_CALL,
            static::ACTIVITY_TYPE_TASK,
            static::ACTIVITY_TYPE_MESSAGE,
            static::ACTIVITY_TYPE_ACTION,
            static::ACTIVITY_TYPE_USER_ACTION
        ];
    }

    public static function dictOwnerTypes(): array
    {
        return [
            static::OWNER_TYPE_LEAD,
            static::OWNER_TYPE_DEAL,
            static::OWNER_TYPE_CONTACT,
            static::OWNER_TYPE_COMPANY,
            static::OWNER_TYPE_SCORE,
            static::OWNER_TYPE_OFFER,
            static::OWNER_TYPE_REQUISITES
        ];
    }

    public static function dictPhoneTypes(): array
    {
        return [
            static::PHONE_TYPE_WORK
        ];
    }
}
