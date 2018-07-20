<?php

namespace connect\crm\retailcrm\action\lists;

use connect\crm\base\dict\Action as DictAction;
use connect\crm\retailcrm\action\base\Action;
use connect\crm\retailcrm\dict\Entities;

class Statuses extends Action
{
    const ID = 13;
    const NAME = Entities::STATUS . DictAction::NAME_DELIMITER . DictAction::LIST;
    public $entity = Entities::STATUS;
    protected $path = '/api/{version}/reference/statuses';

    public function run()
    {
        $data = parent::run();
        $this->service->schema->_info['statuses'] = $data;
        return $data;
    }
}
