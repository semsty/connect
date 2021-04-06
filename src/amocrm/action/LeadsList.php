<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\ListAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class LeadsList extends ListAction
{
    const ID = 3;
    const NAME = Entities::LEAD . Action::NAME_DELIMITER . Action::LIST;
    #const MAX_LIMIT = 250;
    public $responsible_user_id;
    protected $path = 'api/{version}/leads';
    protected $entity = Entities::LEAD;

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            [['responsible_user_id'], 'integer']
        ]);
        return $rules;
    }

    public function getQuery()
    {
        $query = parent::getQuery();
        $query['responsible_user_id'] = $this->responsible_user_id;
        $query['id'] = $this->id;
        return $query;
    }
}
