<?php

namespace semsty\connect\retailcrm\action\lists;

use semsty\connect\base\dict\Action as DictAction;
use semsty\connect\retailcrm\action\base\Action;
use semsty\connect\retailcrm\dict\Entities;

class Credentials extends Action
{
    const ID = 2;
    const NAME = Entities::CREDENTIAL . DictAction::NAME_DELIMITER . DictAction::LIST;
    public $entity = Entities::CREDENTIAL;
    protected $path = '/api/{entity}s';

    public function run()
    {
        $data = parent::run();
        $this->service->schema->_info['credentials'] = $data;
        return $data;
    }
}
