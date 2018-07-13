<?php

namespace semsty\connect\bitrix24\action;

use semsty\connect\base\traits\ProviderAction;
use semsty\connect\bitrix24\action\base\Action;
use yii\helpers\ArrayHelper;

class Get extends Action
{
    use ProviderAction;

    const ID = 4;
    const NAME = 'get';

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

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.get';
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
