<?php

namespace connect\crm\custom;

use connect\crm\base\dict\Action;
use connect\crm\base\Service as BaseService;
use connect\crm\custom\action\Action as BaseAction;

class Service extends BaseService
{
    const ID = 1000;
    const NAME = 'custom';

    public $url = '';
    public $formats = ['json'];

    public static function getDataProviderActions(): array
    {
        return [
            Action::GET => BaseAction::class
        ];
    }

    public function setUrl($value)
    {
        $this->_path = $value;
    }
}
