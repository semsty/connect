<?php

namespace semsty\connect\retailcrm\action\set;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\EditAction;
use semsty\connect\retailcrm\dict\Entities;

class OrderEdit extends EditAction
{
    const ID = 10;
    const NAME = Entities::ORDER . Action::NAME_DELIMITER . Action::UPDATE;

    public $entity = Entities::ORDER;
}
