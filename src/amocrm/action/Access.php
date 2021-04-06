<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\Action as BaseAction;
use connect\crm\amocrm\dict\Errors;
use connect\crm\amocrm\query\Query;
use connect\crm\base\exception\ConnectException;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\traits\RandomRetryActionTrait;
use connect\crm\base\traits\RecipientAction;
use yii\helpers\Json;

/**
 * Class OAuth
 * @property $client_id
 * @property $client_secret
 * @property $grant_type
 * @property $code
 * @property $refresh_token
 * @property $redirect_uri
 * @package connect\crm\amocrm\action
 */
class Access extends BaseAction
{
    use RecipientAction, RandomRetryActionTrait;

    const ID = 16;
    const NAME = 'access';

    const GRANT_TYPE_CODE = 'authorization_code';
    const GRANT_TYPE_REFRESH = 'refresh_token';

    public $with_auth = false;
    public $method = 'POST';
    public $client_id = '';
    public $client_secret = '';
    public $grant_type = self::GRANT_TYPE_REFRESH;
    public $code = '';
    public $refresh_token = '';
    public $redirect_uri = '';

    protected $path = 'oauth2/access_token';

    public function getConfig(): array
    {
        $body = [
            'subdomain' => $this->subdomain,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => $this->grant_type,
            'redirect_uri' => $this->redirect_uri
        ];
        if ($this->code) {
            $body['code'] = $this->code;
        }
        if ($this->refresh_token) {
            $body['refresh_token'] = $this->refresh_token;
        }
        $parent = parent::getConfig();
        unset($parent['requestConfig']['url']['version']);
        unset($parent['requestConfig']['url']['access_token']);
        return ArrayHelper::merge($parent, [
            'requestConfig' => [
                'format' => 'json',
                'data' => $body
            ]
        ]);
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

    public function isRefreshToken(): bool
    {
        return $this->grant_type == static::GRANT_TYPE_REFRESH;
    }

    /**
     * @param $response Query
     * @throws ConnectException
     */
    public function raiseErrorByResponse($response)
    {
        if ($code = ArrayHelper::getValue($response->data, ['response', 'error_code'])) {
            $this->ip = \yii\helpers\ArrayHelper::getValue($response->data, ['response', 'ip']);
            if (ArrayHelper::keyExists($code, Errors::dictCommonErrors())) {
                throw new ConnectException(Errors::dictCommonErrors()[$code]);
            }
        }
        parent::raiseErrorByResponse($response);
    }
}
