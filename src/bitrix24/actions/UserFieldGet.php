<?php

namespace semsty\connect\bitrix24\actions;

class UserFieldGet extends Get
{
    const ID = 10;
    const NAME = 'user.field.get';

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.userfield.get';
    }
}
