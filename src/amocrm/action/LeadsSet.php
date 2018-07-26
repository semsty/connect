<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\SetAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class LeadsSet extends SetAction
{
    const ID = 8;
    const NAME = Entities::LEAD . Action::NAME_DELIMITER . Action::SET;

    protected $path = 'api/{version}/leads';
    protected $entity = Entities::LEAD;

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), ['status_id', 'sale', 'tags']);
    }
}
