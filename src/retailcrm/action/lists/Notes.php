<?php

namespace connect\crm\retailcrm\action\lists;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\ListAction;
use connect\crm\retailcrm\dict\Entities;

class Notes extends ListAction
{
    const ID = 11;
    const NAME = Entities::NOTE . Action::NAME_DELIMITER . Action::LIST;
    public $entity = Entities::NOTE;
    protected $path = '/api/{version}/customers/{entity}s';
}
