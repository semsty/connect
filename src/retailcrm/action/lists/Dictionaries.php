<?php

namespace connect\crm\retailcrm\action\lists;

use connect\crm\base\dict\Action;
use connect\crm\retailcrm\action\base\ListAction;
use connect\crm\retailcrm\dict\Entities;

class Dictionaries extends ListAction
{
    const ID = 1;
    const NAME = Entities::CUSTOM_DICTIONARY . Action::NAME_DELIMITER . Action::LIST;
    public $entity = Entities::CUSTOM_DICTIONARY;
    protected $path = '/api/{version}/custom-fields/dictionaries';

    public function getEntityResponseName()
    {
        return 'customDictionaries';
    }

    public function run()
    {
        $data = parent::run();
        $this->service->schema->_info[Entities::getEntityTypePluralize(Entities::CUSTOM_DICTIONARY)] = $data;
        return $data;
    }
}
