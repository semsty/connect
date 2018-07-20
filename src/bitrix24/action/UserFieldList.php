<?php

namespace connect\crm\bitrix24\action;

class UserFieldList extends ListAction
{
    const ID = 11;
    const NAME = 'user.field.list';

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.userfield.list';
    }
}
