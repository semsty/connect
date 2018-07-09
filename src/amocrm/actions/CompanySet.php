<?php

namespace semsty\connect\amocrm\actions;

use semsty\connect\amocrm\actions\base\SetAction;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\base\dict\Action;
use yii\helpers\ArrayHelper;

class CompanySet extends SetAction
{
    const ID = 10;
    const NAME = Entities::COMPANY . Action::NAME_DELIMITER . Action::SET;

    protected $path = 'api/{version}/companies';
    protected $entity = Entities::COMPANY;

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), [
            'contacts_id', 'linked_contacts_id', 'leads_id', 'linked_leads_id', 'company_name'
        ]);
    }

    public function getEntityPluralizeName(): string
    {
        return Entities::getEntityTypePluralize(Entities::CONTACT);
    }
}
