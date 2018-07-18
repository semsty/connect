<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\SetAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

class NotesSet extends SetAction
{
    const ID = 11;
    const NAME = Entities::NOTE . Action::NAME_DELIMITER . Action::SET;

    protected $path = 'api/{version}/notes';
    protected $entity = Entities::NOTE;

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), [
            'element_id', 'element_type', 'note_type', 'text', 'params'
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
                    $this->data[$mode][$no]['note_type'] = key($this->service->dictionaries->get('note.types'));
                }
            }
        }
        return parent::getData();
    }
}
