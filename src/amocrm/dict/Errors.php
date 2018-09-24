<?php

namespace connect\crm\amocrm\dict;

use connect\crm\base\dict\Dictionary;

class Errors extends Dictionary
{
    const DICT_NAME = 'errors';

    const CODE_INCORRECT_STRUCTURE = 400;
    const CODE_NOT_AUTHORIZED = 401;
    const CODE_PAYMENT_REQUIRED = 402;
    const CODE_ACCOUNT_DISABLED = 403;
    const CODE_TOO_MANY_REQUESTS = 429;
    const CODE_ACCOUNT_NOT_FOUND = 101;
    const CODE_INCORRECT_LOGIN_OR_PASSWORD = 110;

    public static function dictCommonErrors()
    {
        return [
            static::CODE_INCORRECT_STRUCTURE => 'incorrect-structure',
            static::CODE_PAYMENT_REQUIRED => 'payment-required',
            static::CODE_ACCOUNT_DISABLED => 'account-disabled',
            static::CODE_TOO_MANY_REQUESTS => 'too-many-requests',
            static::CODE_ACCOUNT_NOT_FOUND => 'account-not-found',
            static::CODE_INCORRECT_LOGIN_OR_PASSWORD => 'incorrect-login-or-password',
            static::CODE_NOT_AUTHORIZED => 'incorrect-login-or-password'
        ];
    }
}
