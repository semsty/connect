<?php

namespace connect\crm\bitrix24\query;

use connect\crm\base\query\Connection as BaseConnection;
use connect\crm\bitrix24\action\base\Action;
use yii\helpers\ArrayHelper;

class Connection extends BaseConnection
{
    protected function increment($data = null)
    {
        $next = ArrayHelper::getValue($data, $this->limit_response_key);
        if ($next && $this->max_limit < $next) {
            $this->max_limit = $next;
        } else {
            $this->max_limit += Action::MAX_LIMIT;
        }
    }

    protected function checkPayload($data)
    {
        return $this->max_limit < ArrayHelper::getValue($data, 'total');
    }
}