<?php

namespace semsty\connect\amocrm\action;

use semsty\connect\amocrm\action\base\SetAction;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\base\dict\Action;
use semsty\connect\base\helpers\Json;
use yii\helpers\ArrayHelper;

class CallsSet extends SetAction
{
    const ID = 13;
    const NAME = Entities::CALL . Action::NAME_DELIMITER . Action::SET;
    public $code;
    public $key;
    public $account_id;
    protected $path = 'api/calls/add/';
    protected $entity = Entities::CALL;

    public static function getSystemFields()
    {
        return ArrayHelper::merge(parent::getSystemFields(), [
            'account_id', 'uuid', 'caller', 'to', 'date', 'type', 'billsec', 'link'
        ]);
    }

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['code', 'key', 'account_id'], 'string'],
            [['account_id'], 'required'],
            ['code', 'default', 'value' => \Yii::$app->params['amocrm']['calltracking']['id']],
            ['key', 'default', 'value' => \Yii::$app->params['amocrm']['calltracking']['secret']]
        ]);
    }

    public function getConfig(): array
    {
        $config = ArrayHelper::merge(parent::getConfig(), [
            'url' => [
                'subdomain' => $this->subdomain,
                'code' => $this->code,
                'key' => $this->key,
                'account_id' => $this->account_id
            ]
        ]);
        unset($config['query']['version']);
        return $config;
    }

    public function getData()
    {
        $json = parent::getData();
        $data = Json::decode($json, true);
        $data['request'] = $data['request']['calls'];
        foreach ($data['request']['add'] as $no => $call) {
            $data['request']['add'][$no]['account_id'] = $this->account_id;
        }
        return Json::encode($data);
    }
}
