<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\Action as BaseAction;
use connect\crm\amocrm\dict\Errors;
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

    /**
     * @param $response Query
     * @throws ConnectException
     */
    public function raiseErrorByResponse($response)
    {
        if ($code = ArrayHelper::getValue($response->content, ['response', 'error_code'])) {
            if (ArrayHelper::keyExists($code, Errors::dictCommonErrors())) {
                throw new ConnectException(Errors::dictCommonErrors()[$code]);
            }
        }
        parent::raiseErrorByResponse($response);
    }
}
