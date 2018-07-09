<?php

namespace semsty\connect\amocrm\actions;

use semsty\connect\amocrm\actions\base\ListAction;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\base\dict\Action;
use yii\helpers\ArrayHelper;

class TasksList extends ListAction
{
    const ID = 7;
    const NAME = Entities::TASK . Action::NAME_DELIMITER . Action::LIST;
    public $type;
    public $element_id;
    public $id;
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
