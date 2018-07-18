<?php

namespace connect\crm\retailcrm\action\lists;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\ListAction;
use connect\crm\retailcrm\dict\Entities;
use connect\crm\retailcrm\filter\History as Filter;

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
