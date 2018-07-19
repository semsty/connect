<?php

namespace connect\crm\custom\action;

use connect\crm\base\Action as BaseAction;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\traits\ProviderAction;

class Action extends BaseAction
{
    use ProviderAction;

    const ID = 1;
    const NAME = 'custom';

    public function getUrl(): string
    {
        return ArrayHelper::getValue($this->custom_config, ['requestConfig', 'url', '0']);
    }

    public function getAuthKeys(): array
    {
        return ['custom_config'];
    }
}
