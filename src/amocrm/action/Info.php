<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\Action as BaseAction;
use connect\crm\base\dict\Action;
use connect\crm\base\traits\ProviderAction;
use yii\helpers\ArrayHelper;

class Info extends BaseAction
{
    use ProviderAction;

    const ID = 2;
    const NAME = Action::INFO;

    protected $path = 'private/api/{version}/json/accounts/current';

    public function run()
    {
        $data = parent::run();
        $data = $data['response']['account'];
        $this->service->schema->info = $data;
        return $data;
    }
}
