<?php

namespace connect\crm\retailcrm\action\lists;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\ListAction;
use connect\crm\retailcrm\dict\Entities;

class CustomFields extends ListAction
{
    const ID = 5;
    const NAME = Entities::CUSTOM_FIELD . Action::NAME_DELIMITER . Action::LIST;

    public $entity = Entities::CUSTOM_FIELD;

    public function getEntityResponseName()
    {
        return 'customFields';
    }

    public function run()
    {
        $data = parent::run();
        $this->service->schema->_info[Entities::getEntityTypePluralize(Entities::CUSTOM_FIELD)] = $data;
        return $data;
    }
}
