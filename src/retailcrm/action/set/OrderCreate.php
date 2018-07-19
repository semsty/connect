<?php

namespace connect\crm\retailcrm\action\set;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\CreateAction;
use connect\crm\retailcrm\dict\Entities;

class OrderCreate extends CreateAction
{
    const ID = 9;
    const NAME = Entities::ORDER . Action::NAME_DELIMITER . Action::CREATE;

    public $entity = Entities::ORDER;
}
