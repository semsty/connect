<?php

namespace connect\crm\retailcrm\action\set;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\CreateAction;
use connect\crm\retailcrm\dict\Entities;

class NoteCreate extends CreateAction
{
    const ID = 12;
    const NAME = Entities::NOTE . Action::NAME_DELIMITER . Action::CREATE;
    public $entity = Entities::NOTE;
    protected $path = '/api/{version}/customers/{entity}s/create';
}
