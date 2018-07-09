<?php

namespace semsty\connect\bitrix24\actions;

use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

class DealContactAdd extends Add
{
    const ID = 13;
    const NAME = 'deal.contact.add';

    public $id;

    public static function getEntities()
    {
        return ['deal'];
    }

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
        return 'rest/crm.' . $this->entity . '.contact.add';
    }

    public function getData()
    {
        if (!ArrayHelper::keyExists('CONTACT_ID', $this->data)) {
            throw new ErrorException('CONTACT_ID key does not exist');
        }
        return parent::getData();
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
