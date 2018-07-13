<?php

namespace semsty\connect\retailcrm\action\set;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\EditAction;
use semsty\connect\retailcrm\dict\Entities;

class CustomerEdit extends EditAction
{
    const ID = 8;
    const NAME = Entities::CUSTOMER . Action::NAME_DELIMITER . Action::UPDATE;

    public $entity = Entities::CUSTOMER;
}
