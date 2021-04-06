<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\Action as BaseAction;
use connect\crm\amocrm\dict\Errors;
use connect\crm\amocrm\query\Query;
use connect\crm\base\dict\Action;
use connect\crm\base\exception\ConnectException;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\traits\RandomRetryActionTrait;
use connect\crm\base\traits\RecipientAction;
use yii\helpers\Json;

/**
 * Class Exchange
 * @property $client_id
 * @property $client_secret
 * @property $state
 * @package connect\crm\amocrm\action
 */
class Exchange extends BaseAction
{
    use RecipientAction, RandomRetryActionTrait;

    const ID = 15;
    const NAME = 'exchange';

    public $with_auth = false;
    public $method = 'POST';
    public $client_id = '';
    public $client_secret = '';
    public $state = '';

    protected $path = 'oauth2/exchange_api_key';

    public function getConfig(): array
    {
        return ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'format' => 'json',
                'data' => [
                    'subdomain' => $this->subdomain,
                    'login' => $this->login,
                    'api_key' => $this->apiKey,
                    'client_uuid' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'state' => $this->state
                ]
            ]
        ]);
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
