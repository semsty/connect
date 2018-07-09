<?php

namespace semsty\connect\amocrm\actions;

use semsty\connect\amocrm\actions\base\ListAction;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\base\dict\Action;
use yii\helpers\ArrayHelper;

class NotesList extends ListAction
{
    const ID = 6;
    const NAME = Entities::NOTE . Action::NAME_DELIMITER . Action::LIST;
    public $type;
    public $element_id;
    public $id;
    public $note_type;
    protected $path = 'api/{version}/notes';
    protected $entity = Entities::NOTE;

    public function rules(): array
    {
        $rules = parent::rules();
        $element_types = $this->service->dictionaries->keys('note.entity.types');
        $rules = ArrayHelper::merge($rules, [
            [['type'], 'default', 'value' => $element_types[0]],
            ['note_type', 'in', 'range' => $this->service->dictionaries->keys('note.types')],
            ['type', 'in', 'range' => $element_types],
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
