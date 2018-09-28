<?php

namespace connect\crm\retailcrm\action\lists;

use connect\crm\base\dict\Action as DictAction;
use connect\crm\retailcrm\action\base\ListAction;
use connect\crm\retailcrm\dict\Entities;

class Users extends ListAction
{
    const ID = 15;
    const NAME = Entities::USER . DictAction::NAME_DELIMITER . DictAction::LIST;

    public $entity = Entities::USER;

    public function run()
    {
        $data = parent::run();
        $this->service->schema->_info['users'] = $data;
        return $data;
    }
}
