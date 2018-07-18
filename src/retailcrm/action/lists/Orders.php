<?php

namespace connect\crm\retailcrm\action\lists;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\ListAction;
use connect\crm\retailcrm\dict\Entities;
use connect\crm\retailcrm\filter\Orders as Filter;

class Orders extends ListAction
{
    const ID = 3;
    const NAME = Entities::ORDER . Action::NAME_DELIMITER . Action::LIST;

    public $entity = Entities::ORDER;
    public $_filter_class = Filter::class;
}
