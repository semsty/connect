<?php

namespace semsty\connect\retailcrm\action\lists;

use semsty\connect\base\dict\Action;
use semsty\connect\retailcrm\action\base\ListAction;
use semsty\connect\retailcrm\dict\Entities;

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
