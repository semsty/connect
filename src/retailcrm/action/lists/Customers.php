<?php

namespace semsty\connect\retailcrm\action\lists;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\ListAction;
use semsty\connect\retailcrm\dict\Entities;
use semsty\connect\retailcrm\filter\CustomersFilter;

class Customers extends ListAction
{
    const ID = 4;
    const NAME = Entities::CUSTOMER . Action::NAME_DELIMITER . Action::LIST;

    public $entity = Entities::CUSTOMER;
    public $_filter_class = CustomersFilter::class;
}
