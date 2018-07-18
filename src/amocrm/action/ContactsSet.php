<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\SetAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class ContactsSet extends SetAction
{
    const ID = 9;
    const NAME = Entities::CONTACT . Action::NAME_DELIMITER . Action::SET;

    protected $path = 'api/{version}/contacts';
    protected $entity = Entities::CONTACT;

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), [
            'company_id', 'linked_company_id', 'leads_id', 'linked_leads_id', 'company_name'
        ]);
    }
}
