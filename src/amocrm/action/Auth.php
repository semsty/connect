<?php

namespace semsty\connect\amocrm\action;

use semsty\connect\amocrm\action\base\Action as BaseAction;
use semsty\connect\base\dict\Action;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\traits\ProviderAction;
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
