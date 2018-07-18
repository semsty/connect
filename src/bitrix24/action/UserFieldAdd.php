<?php

namespace connect\crm\bitrix24\action;

class UserFieldAdd extends Get
{
    const ID = 8;
    const NAME = 'user.field.add';

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.userfield.add';
    }
}
