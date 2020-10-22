<?php

namespace connect\crm\bitrix24\query;

use connect\crm\base\query\Connection as BaseConnection;
use yii\helpers\ArrayHelper;

class Connection extends BaseConnection
{
    protected function increment($data = null)
    {
        $next = ArrayHelper::getValue($data, $this->limit_response_key);
        if ($this->max_limit < $next) {
            $this->max_limit = $next;
        }
    }

    protected function checkPayload($data)
    {
        return $this->max_limit < ArrayHelper::getValue($data, 'total');
    }
}
