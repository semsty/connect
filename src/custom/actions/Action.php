<?php

namespace semsty\connect\custom\actions;

use semsty\connect\base\Action as BaseAction;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\traits\ProviderAction;

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
