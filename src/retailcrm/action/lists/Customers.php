<?php

namespace connect\crm\retailcrm\action\lists;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\ListAction;
use connect\crm\retailcrm\dict\Entities;
use connect\crm\retailcrm\filter\Customers as Filter;

class Customers extends ListAction
{
    const ID = 4;
    const NAME = Entities::CUSTOMER . Action::NAME_DELIMITER . Action::LIST;

    public $entity = Entities::CUSTOMER;
    public $_filter_class = Filter::class;
}
