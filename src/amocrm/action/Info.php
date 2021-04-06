<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\base\Action as BaseAction;
use connect\crm\base\dict\Action;
use connect\crm\base\traits\ProviderAction;
use yii\helpers\ArrayHelper;

/**
 * Class Info
 * @property $with
 * @package connect\crm\amocrm\action
 */
class Info extends BaseAction
{
    use ProviderAction;

    const ID = 2;
    const NAME = Action::INFO;

    public $with = 'datetime_settings';

    protected $path = 'api/{version}/account';

    public function run()
    {
        $data = parent::run();
        $this->service->schema->info = $data;
        return $data;
    }

    public function getConfig(): array
    {
        return ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'url' => [
                    'with' => $this->with
                ]
            ]
        ]);
    }
}
