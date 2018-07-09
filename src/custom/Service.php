<?php

namespace semsty\connect\custom;

use semsty\connect\base\dict\Action;
use semsty\connect\base\Service as BaseService;
use semsty\connect\custom\actions\Action as BaseAction;

class Service extends BaseService
{
    const SERVICE_ID = 1000;
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
