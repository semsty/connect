<?php

namespace connect\crm\bitrix24\action;

class UserFieldGet extends Get
{
    const ID = 10;
    const NAME = 'user.field.get';

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.userfield.get';
    }
}
