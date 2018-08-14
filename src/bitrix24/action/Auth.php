<?php

namespace connect\crm\bitrix24\action;

use connect\crm\base\exception\ConnectException;
use connect\crm\base\helpers\Json;
use connect\crm\base\traits\ProviderAction;
use connect\crm\bitrix24\action\base\Action;
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
    public $code;

    public function rules(): array
    {
        $rules = [
            [['scope'], 'required'],
            [['client_id', 'client_secret', 'grant_type', 'refresh_token', 'scope', 'code'], 'string'],
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
        if ($this->grant_type == 'authorization_code') {
            $rules[] = [['code'], 'required'];
        } else {
            $rules[] = [['refresh_token'], 'required'];
        }
        return $rules;
    }

    public static function getGrantTypes()
    {
        return [
            'refresh_token', 'authorization_code'
        ];
    }

    public static function getScopes()
    {
        return ['crm'];
    }

    public function getDefaultConfig(): array
    {
        $config = ArrayHelper::merge(parent::getDefaultConfig(), [
            'requestConfig' => [
                'url' => [
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'grant_type' => $this->grant_type,
                    'refresh_token' => $this->refresh_token,
                    'scope' => $this->scope,
                    'code' => $this->code
                ]
            ]
        ]);
        $username = ArrayHelper::getValue($this->profile->config, 'username');
        $password = ArrayHelper::getValue($this->profile->config, 'password');
        if ($username && $password && $this->service->isBoxed()) {
            $config['requestConfig']['options'] = [
                'userpwd' => "$username:$password"
            ];
            $config['transport'] = 'yii\httpclient\CurlTransport';
        }
        return $config;
    }

    public function getAuthKeys(): array
    {
        $keys = ['domain', 'scope'];
        if ($this->grant_type != 'authorization_code') {
            $keys[] = 'refresh_token';
        }
        return $keys;
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
        $this->profile->setConfig(
            ArrayHelper::merge($this->profile->config, $data)
        );
        $this->profile->save();
        return $data;
    }

    protected function getPath()
    {
        return 'oauth/token/';
    }
}
