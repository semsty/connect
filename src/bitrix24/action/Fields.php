<?php

namespace connect\crm\bitrix24\action;

use connect\crm\base\traits\ProviderAction;
use connect\crm\bitrix24\action\base\Action;

class Fields extends Action
{
    use ProviderAction;

    const ID = 2;
    const NAME = 'fields';

    public $entity = 'deal';
    public $with_info = false;

    public function getPath()
    {
        return 'rest/crm.' . $this->entity . '.fields';
    }

    public function run()
    {
        $data = parent::run();
        $this->service->schema->_info[$this->entity] = $data['result'];
        return $data['result'];
    }
}
