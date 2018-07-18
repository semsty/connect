<?php

namespace connect\crm\retailcrm\action\set;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\EditAction;
use connect\crm\retailcrm\dict\Entities;

class CustomerEdit extends EditAction
{
    const ID = 8;
    const NAME = Entities::CUSTOMER . Action::NAME_DELIMITER . Action::UPDATE;

    public $entity = Entities::CUSTOMER;
}
