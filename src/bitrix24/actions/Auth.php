<?php

namespace semsty\connect\bitrix24\actions;

use semsty\connect\base\exception\ConnectException;
use semsty\connect\base\helpers\Json;
use semsty\connect\base\traits\ProviderAction;
use semsty\connect\bitrix24\actions\base\Action;
use yii\helpers\ArrayHelper;

/**
 * @link https://{subdomain}.bitrix24.ru/oauth/authorize/?response_type=code&client_id=app.56581ab3732844.81408708&redirect_uri=https%3A%2F%2Fapicrm.alytics.ru%2Foauth.php
 */
class Auth extends Action
{
    use ProviderAction;

    const ID = 1;
    const NAME = 'auth';

    public $with_auth = false;
    public $grant_type;
    public $client_id;
    public $client_secret;
    public $refresh_token;
    public $scope;

    public function rules(): array
    {
        return [
            [['refresh_token', 'scope'], 'required'],
            [['client_id', 'client_secret', 'grant_type', 'refresh_token', 'scope'], 'string'],
            /**
             * TODO: mv to dict
             */
            [['grant_type'], 'default', 'value' => static::getGrantTypes()[0]],
            [['grant_type'], 'in', 'range' => static::getGrantTypes()],
            [['scope'], 'default', 'value' => static::getScopes()[0]],
            [['scope'], 'in', 'range' => static::getScopes()],
            [['client_id'], 'default', 'value' => \Yii::$app->params['bitrix24']['client_id']],
            [['client_secret'], 'default', 'value' => \Yii::$app->params['bitrix24']['client_secret']]
        ];
    }

    public static function getGrantTypes()
    {
        return [
            'refresh_token'
        ];
    }

    public static function getScopes()
    {
        return [
            'crm'
        ];
    }

    public function getDefaultConfig(): array
    {
        return ArrayHelper::merge(parent::getDefaultConfig(), [
            'requestConfig' => [
                'url' => [
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'grant_type' => $this->grant_type,
                    'refresh_token' => $this->refresh_token,
                    'scope' => $this->scope
                ]
            ]
        ]);
    }

    public function getAuthKeys(): array
    {
        return [
            'domain', 'scope', 'refresh_token'
        ];
    }

    public function checkAuth()
    {
        return false;
    }

    public function run()
    {
        $data = parent::run();
        foreach (['access_token', 'refresh_token'] as $key) {
            if (!ArrayHelper::keyExists($key, $data)) {
                throw new ConnectException('Invalid response: ' . Json::encode($data));
            }
        }
        $data['expires_in'] = strtotime('now') + $data['expires_in'];
        $this->profile->setConfig($data);
        $this->profile->save();
        return $data;
    }

    protected function getPath()
    {
        return 'oauth/token/';
    }
}
