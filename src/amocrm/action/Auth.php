<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\Action as BaseAction;
use connect\crm\base\dict\Action;
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
}
