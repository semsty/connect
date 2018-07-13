<?php

namespace semsty\connect\retailcrm\action\set;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\CreateAction;
use semsty\connect\retailcrm\dict\Entities;

class OrderCreate extends CreateAction
{
    const ID = 9;
    const NAME = Entities::ORDER . Action::NAME_DELIMITER . Action::CREATE;

    public $entity = Entities::ORDER;
}
