<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\SetAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\amocrm\dict\Types;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

/**
 * Class NotesSet
 * @property $subentity
 * @package connect\crm\amocrm\action
 */
class NotesSet extends SetAction
{
    const ID = 11;
    const NAME = Entities::NOTE . Action::NAME_DELIMITER . Action::SET;

    public $subentity = 'leads';

    protected $path = 'api/{version}/{subentity}/notes';
    protected $entity = Entities::NOTE;

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), [
            'entity_id', 'note_type', 'text', 'params'
        ]);
    }

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            [['subentity'], 'string']
        ]);
        return $rules;
    }

    public static function mapTypes(): array
    {
        return [
            Types::NOTE_TYPE_COMMON => Types::EVENT_TYPE_COMMON,
            Types::NOTE_TYPE_CALL_IN => Types::EVENT_TYPE_CALL_IN
        ];
    }

    public function getConfig(): array
    {
        $config = ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'url' => [
                    'subentity' => $this->subentity
                ]
            ]
        ]);
        if ($add = ArrayHelper::getValue($config, ['requestConfig', 'data', 'add'])) {
            $config['requestConfig']['data'] = $add;
        }
        return $config;
    }

    public function getData()
    {
        foreach ($this->data as $mode => &$mode_data) {
            foreach ($mode_data as $no => &$data) {
                if (!ArrayHelper::keyExists('element_type', $data)) {
                    $this->data[$mode][$no]['element_type'] = key($this->service->dictionaries->get('element.types'));
                }
                if (!ArrayHelper::keyExists('element_type', $data)) {
                    $this->data[$mode][$no]['note_type'] = key($this->service->dictionaries->get('note.types'));
                }
                if ($id = ArrayHelper::getValue($data, 'element_id')) {
                    $data['entity_id'] = (int)$id;
                    unset($data['element_id']);
                }
                if ($type = ArrayHelper::getValue($data, 'element_type')) {
                    $this->subentity = Entities::getEntityTypePluralize(Types::dictElementTypes()[$type]);
                    unset($data['element_type']);
                }
                if ($mapped = ArrayHelper::getValue(static::mapTypes(), $this->data[$mode][$no]['note_type'])) {
                    $this->data[$mode][$no]['note_type'] = $mapped;
                }
                if ($params = ArrayHelper::getValue($data, 'params')) {
                    foreach ($params as $key => $value) {
                        $new[strtolower($key)] = $value;
                    }
                    if ($src = ArrayHelper::getValue($new, 'src')) {
                        $new['source'] = $src;
                        unset($new['src']);
                    }
                    if ($duration = ArrayHelper::getValue($new, 'duration')) {
                        $new['duration'] = (int)$duration;
                    }
                    $data['params'] = $new;
                }
            }
        }
        return parent::getData();
    }
}
