<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\SetAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class CustomFieldsSet extends SetAction
{
    const ID = 14;
    const NAME = Entities::CUSTOM_FIELD . Action::NAME_DELIMITER . Action::SET;

    protected $path = 'api/{version}/fields';
    protected $entity = 'field';

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), [
            'type', 'field_type', 'element_type', 'origin', 'disabled', 'request_id', 'is_editable'
        ]);
    }
}
