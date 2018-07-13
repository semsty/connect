<?php

namespace semsty\connect\retailcrm\action\set;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\CreateAction;
use semsty\connect\retailcrm\dict\Entities;

class CustomerCreate extends CreateAction
{
    const ID = 7;
    const NAME = Entities::CUSTOMER . Action::NAME_DELIMITER . Action::CREATE;

    public $entity = Entities::CUSTOMER;
}
