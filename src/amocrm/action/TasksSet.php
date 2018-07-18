<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\SetAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class TasksSet extends SetAction
{
    const ID = 12;
    const NAME = Entities::TASK . Action::NAME_DELIMITER . Action::SET;

    protected $path = 'api/{version}/tasks';
    protected $entity = Entities::TASK;

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), [
            'element_id', 'element_type', 'task_type', 'text', 'params'
        ]);
    }

    public function getData()
    {
        foreach ($this->data as $mode => $mode_data) {
            foreach ($mode_data as $no => $data) {
                if (!ArrayHelper::keyExists('element_type', $data)) {
                    $this->data[$mode][$no]['element_type'] = key($this->service->dictionaries->get('element.types'));
                }
                if (!ArrayHelper::keyExists('element_type', $data)) {
                    $this->data[$mode][$no]['task_type'] = key($this->service->dictionaries->get('task.types'));
                }
            }
        }
        return parent::getData();
    }
}
