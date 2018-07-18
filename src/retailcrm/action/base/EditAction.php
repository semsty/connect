<?php

namespace connect\crm\retailcrm\action\base;

use yii\helpers\ArrayHelper;

class EditAction extends CreateAction
{
    public $id;
    public $by;
    protected $path = '/api/{version}/{entity}s/{id}/edit';

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            ['by', 'in', 'range' => ['externalId', 'id']],
            ['by', 'default', 'value' => 'id']
        ]);
    }

    public function getConfig(): array
    {
        return ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'url' => [
                    'id' => $this->id,
                    'by' => $this->by
                ]
            ]
        ]);
    }
}
