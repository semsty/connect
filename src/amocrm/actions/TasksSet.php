<?php

namespace semsty\connect\amocrm\actions;

use semsty\connect\amocrm\actions\base\SetAction;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\base\dict\Action;
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
