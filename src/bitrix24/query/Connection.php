<?php

namespace connect\crm\bitrix24\query;

use connect\crm\base\query\Connection as BaseConnection;
use yii\helpers\ArrayHelper;

class Connection extends BaseConnection
{
    protected function increment($data = null)
    {
        $this->max_limit = ArrayHelper::getValue($data, $this->limit_response_key);
    }

    protected function checkPayload($data)
    {
        return ArrayHelper::getValue($data, $this->limit_response_key);
    }
}
