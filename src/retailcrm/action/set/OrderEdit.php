<?php

namespace connect\crm\retailcrm\action\set;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\EditAction;
use connect\crm\retailcrm\dict\Entities;

class OrderEdit extends EditAction
{
    const ID = 10;
    const NAME = Entities::ORDER . Action::NAME_DELIMITER . Action::UPDATE;

    public $entity = Entities::ORDER;
}
