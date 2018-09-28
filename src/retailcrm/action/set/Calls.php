<?php

namespace connect\crm\retailcrm\action\set;

use connect\crm\retailcrm\action\base\CreateAction;
use yii\helpers\ArrayHelper;

class Calls extends CreateAction
{
    public function getData()
    {
        if (ArrayHelper::isAssociative($this->data)) {
            $this->data = [$this->data];
        }
        return $this->data;
    }
}