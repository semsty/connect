<?php

namespace connect\crm\retailcrm\action\set;

use connect\crm\base\dict\Action as DictAction;
use connect\crm\retailcrm\action\base\CreateAction;
use connect\crm\retailcrm\dict\Entities;
use yii\helpers\ArrayHelper;

class Calls extends CreateAction
{
    const ID = 14;
    const NAME = Entities::CALL . DictAction::NAME_DELIMITER . DictAction::CREATE;

    public $entity = Entities::CALL;

    protected $path = '/api/{version}/telephony/{entity}s/upload';

    public function getData()
    {
        if (ArrayHelper::isAssociative($this->data)) {
            $this->data = [$this->data];
        }
        return ['calls' => $this->data];
    }
}