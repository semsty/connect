<?php

namespace semsty\connect\bitrix24\actions;

use semsty\connect\base\traits\RecipientAction;
use yii\helpers\ArrayHelper;

class Update extends Add
{
    use RecipientAction;

    const ID = 6;
    const NAME = 'update';

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
        return 'rest/crm.' . $this->entity . '.update';
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
