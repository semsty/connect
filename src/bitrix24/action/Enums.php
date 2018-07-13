<?php

namespace semsty\connect\bitrix24\action;

use semsty\connect\base\traits\ProviderAction;

class Enums extends ListAction
{
    use ProviderAction;

    const ID = 520;
    const NAME = 'enums';

    public $type = 'activitytype';

    public function getPath()
    {
        return 'rest/crm.enum.' . $this->type;
    }
}
