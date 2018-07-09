<?php

namespace semsty\connect\amocrm\actions;

use semsty\connect\amocrm\actions\base\SetAction;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\base\dict\Action;
use yii\helpers\ArrayHelper;

class LeadsSet extends SetAction
{
    const ID = 8;
    const NAME = Entities::LEAD . Action::NAME_DELIMITER . Action::SET;

    protected $path = 'api/{version}/leads';
    protected $entity = Entities::LEAD;

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), ['status_id', 'price', 'tags']);
    }
}
