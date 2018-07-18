<?php

namespace connect\crm\retailcrm\action\base;

use connect\crm\base\helpers\Json;
use connect\crm\base\traits\RecipientAction;
use yii\helpers\ArrayHelper;

class CreateAction extends Action
{
    use RecipientAction;

    public $data = [];
    public $site;
    protected $path = '/api/{version}/{entity}s/create';

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                'site',
                'default',
                'value' => ArrayHelper::getValue($this->service->schema->info, 'credentials.sitesAvailable.0')
            ]
        ]);
    }

    public function getDefaultConfig(): array
    {
        return ArrayHelper::merge(parent::getDefaultConfig(), [
            'requestConfig' => [
                'data' => $this->getData()
            ]
        ]);
    }

    public function getData()
    {
        $system_fields = $this->service->dictionaries->get($this->entity . '.system.fields');
        $query = [];
        $query['site'] = $this->site;
        foreach ($this->data as $key => $value) {
            if (ArrayHelper::keyExists($key, $system_fields)) {
                $query[$this->entity][$key] = $value;
            } else {
                $query[$this->entity]['customFields'][$key] = $value;
            }
        }
        /**
         * @link https://www.retailcrm.ru/docs/Developers/ApiRules#post
         */
        foreach ($query as $key => $value) {
            if (is_array($value)) {
                $query[$key] = Json::encode($value);
            }
        }
        return $query;
    }
}
