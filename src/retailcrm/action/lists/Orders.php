<?php

namespace semsty\connect\retailcrm\action\lists;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\ListAction;
use semsty\connect\retailcrm\dict\Entities;
use semsty\connect\retailcrm\filter\Orders as Filter;

class Orders extends ListAction
{
    const ID = 3;
    const NAME = Entities::ORDER . Action::NAME_DELIMITER . Action::LIST;

    public $entity = Entities::ORDER;
    public $_filter_class = Filter::class;
}
