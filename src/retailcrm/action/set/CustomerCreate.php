<?php

namespace connect\crm\retailcrm\action\set;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\CreateAction;
use connect\crm\retailcrm\dict\Entities;

class CustomerCreate extends CreateAction
{
    const ID = 7;
    const NAME = Entities::CUSTOMER . Action::NAME_DELIMITER . Action::CREATE;

    public $entity = Entities::CUSTOMER;
}
