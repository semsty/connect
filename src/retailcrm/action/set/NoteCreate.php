<?php

namespace semsty\connect\retailcrm\action\set;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\CreateAction;
use semsty\connect\retailcrm\dict\Entities;

class NoteCreate extends CreateAction
{
    const ID = 12;
    const NAME = Entities::NOTE . Action::NAME_DELIMITER . Action::CREATE;
    public $entity = Entities::NOTE;
    protected $path = '/api/{version}/customers/{entity}s/create';
}
