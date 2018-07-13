<?php

namespace semsty\connect\retailcrm\action\lists;

use semsty\connect\base\dict\Action as DictAction;
use semsty\connect\retailcrm\action\base\Action;
use semsty\connect\retailcrm\dict\Entities;

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
