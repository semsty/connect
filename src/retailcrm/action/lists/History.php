<?php

namespace semsty\connect\retailcrm\action\lists;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\ListAction;
use semsty\connect\retailcrm\dict\Entities;
use semsty\connect\retailcrm\filter\History as Filter;

class History extends ListAction
{
    const ID = 6;
    const NAME = Entities::HISTORY . Action::NAME_DELIMITER . Action::LIST;
    public $entity = Entities::ORDER;
    public $_filter_class = Filter::class;
    protected $path = '/api/{version}/{entity}s/history';

    public function getEntityResponseName()
    {
        return Entities::HISTORY;
    }
}
