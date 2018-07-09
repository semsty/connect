<?php

namespace semsty\connect\bitrix24\actions;

class UserFieldUpdate extends Update
{
    const ID = 12;
    const NAME = 'user.field.update';

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.userfield.update';
    }
}
