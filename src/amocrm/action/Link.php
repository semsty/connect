<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\SetAction;
use connect\crm\amocrm\dict\Entities;
use connect\crm\amocrm\dict\Types;
use connect\crm\base\dict\Action;
use yii\helpers\ArrayHelper;

/**
 * Class Link
 * @property $subentity
 * @property $entity_id
 * @property $to_entity_id
 * @property $to_entity_type
 * @property $metadata
 * @package connect\crm\amocrm\action
 */
class Link extends SetAction
{
    const ID = 19;
    const NAME = 'link' . Action::NAME_DELIMITER . Action::SET;

    public $subentity = 'leads';
    public $entity_id;
    public $to_entity_id;
    public $to_entity_type;
    public $metadata = [];

    protected $path = 'api/{version}/{subentity}/{entity_id}/link';
    protected $entity = 'link';

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['subentity', 'to_entity_type'], 'string'],
            [['entity_id', 'to_entity_id'], 'integer']
        ]);
    }

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), [
            'entity_id', 'to_entity_id', 'to_entity_type'
        ]);
    }

    public function getConfig(): array
    {
        return ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'url' => [
                    'subentity' => $this->subentity,
                    'entity_id' => $this->entity_id
                ],
                'data' =>  [
                    'to_entity_id' => $this->to_entity_id,
                    'to_entity_type' => $this->to_entity_type,
                    'metadata' => $this->metadata
                ]
            ]
        ]);
    }
}
