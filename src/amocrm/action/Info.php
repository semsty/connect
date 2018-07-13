<?php

namespace semsty\connect\amocrm\action;

use semsty\connect\amocrm\action\base\Action as BaseAction;
use semsty\connect\base\dict\Action;
use semsty\connect\base\traits\ProviderAction;
use yii\helpers\ArrayHelper;

class Info extends BaseAction
{
    use ProviderAction;

    const ID = 2;
    const NAME = Action::INFO;

    protected $path = 'private/api/{version}/json/accounts/current';

    public function getDefaultConfig(): array
    {
        return ArrayHelper::merge(parent::getDefaultConfig(), [
            'requestConfig' => [
                'url' => $this->getUrl()
            ]
        ]);
    }

    public function run()
    {
        $data = parent::run();
        $data = $data['response']['account'];
        $this->service->schema->info = $data;
        return $data;
    }
}
