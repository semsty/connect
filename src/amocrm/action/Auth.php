<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\Action as BaseAction;
use connect\crm\amocrm\dict\Errors;
use connect\crm\amocrm\query\Query;
use connect\crm\base\dict\Action;
use connect\crm\base\exception\ConnectException;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\traits\ProviderAction;
use yii\helpers\Json;

class Auth extends BaseAction
{
    use ProviderAction;

    const ID = 1;
    const NAME = Action::AUTH;

    public $attempts = 0;
    public $max_attempts = 10;
    public $ip = null;
    public $with_auth = false;

    protected $path = 'private/api/auth.php?type=json';

    public function getConfig(): array
    {
        return ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'content' => Json::encode([
                    'USER_LOGIN' => $this->login,
                    'USER_HASH' => $this->apiKey
                ])
            ]
        ]);
    }

    public function getResponse(): array
    {
        try {
            $this->attempts++;
            return parent::getResponse();
        } catch (\Throwable $e) {
            if ($this->attempts < $this->max_attempts) {
                usleep(rand(1000, 1000000));
                return $this->getResponse();
            } else {
                throw $e;
            }
        }
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
