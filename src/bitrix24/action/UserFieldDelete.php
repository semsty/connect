<?php

namespace connect\crm\bitrix24\action;

class UserFieldDelete extends Update
{
    const ID = 9;
    const NAME = 'user.field.delete';

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.userfield.delete';
    }
}
