<?php

namespace semsty\connect\retailcrm\action\lists;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\ListAction;
use semsty\connect\retailcrm\dict\Entities;

class Notes extends ListAction
{
    const ID = 11;
    const NAME = Entities::NOTE . Action::NAME_DELIMITER . Action::LIST;
    public $entity = Entities::NOTE;
    protected $path = '/api/{version}/customers/{entity}s';
}
