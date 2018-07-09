<?php

namespace semsty\connect\bitrix24\actions;

use semsty\connect\base\traits\ProviderAction;
use semsty\connect\bitrix24\actions\base\Action;
use yii\helpers\ArrayHelper;

class Delete extends Action
{
    use ProviderAction;

    const ID = 7;
    const NAME = 'delete';

    public $entity = 'deal';
    public $id;

    public function rules(): array
    {
        $rules = parent::rules();
        $rules = ArrayHelper::merge($rules, [
            [['id'], 'integer'],
            [['id'], 'required']
        ]);
        return $rules;
    }

    public function getPath()
    {
        return 'rest/crm.' . $this->entity . '.delete';
    }

    public function getDefaultConfig(): array
    {
        return ArrayHelper::merge(parent::getDefaultConfig(), [
            'requestConfig' => [
                'url' => [
                    'id' => $this->id
                ]
            ]
        ]);
    }
}
