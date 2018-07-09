<?php

namespace semsty\connect\amocrm\dict;

use semsty\connect\base\dict\Dictionary;

class Errors extends Dictionary
{
    const DICT_NAME = 'errors';

    const CODE_INCORRECT_STRUCTURE = 400;
    const CODE_PAYMENT_REQUIRED = 402;
    const CODE_ACCOUNT_DISABLED = 403;
    const CODE_TOO_MANY_REQUESTS = 429;

    public static function dictCommonErrors()
    {
        return [
            static::CODE_INCORRECT_STRUCTURE => 'incorrect-structure',
            static::CODE_PAYMENT_REQUIRED => 'payment-required',
            static::CODE_ACCOUNT_DISABLED => 'account-disabled',
            static::CODE_TOO_MANY_REQUESTS => 'too-many-requests'
        ];
    }
}
