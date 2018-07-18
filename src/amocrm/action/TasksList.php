<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\ListAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class TasksList extends ListAction
{
    const ID = 7;
    const NAME = Entities::TASK . Action::NAME_DELIMITER . Action::LIST;
    public $type;
    public $element_id;
    protected $path = 'api/{version}/tasks';
    protected $entity = Entities::TASK;

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            [['element_id'], 'integer']
        ]);
        return $rules;
    }

    public function getQuery()
    {
        $query = parent::getQuery();
        $query['type'] = $this->type;
        $query['element_id'] = $this->element_id;
        $query['id'] = $this->id;
        return $query;
    }
}
