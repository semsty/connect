<?php

namespace semsty\connect\amocrm\actions;

use semsty\connect\amocrm\actions\base\ListAction;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\base\dict\Action;
use yii\helpers\ArrayHelper;

class LeadsList extends ListAction
{
    const ID = 3;
    const NAME = Entities::LEAD . Action::NAME_DELIMITER . Action::LIST;
    public $responsible_user_id;
    public $id;
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
