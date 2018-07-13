<?php

namespace semsty\connect\retailcrm\action\lists;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\ListAction;
use semsty\connect\retailcrm\dict\Entities;

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
