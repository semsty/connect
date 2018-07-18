<?php

namespace connect\crm\amocrm\query;

use connect\crm\base\query\Connection as BaseConnection;
use yii\helpers\ArrayHelper;

class Connection extends BaseConnection
{
    protected function endTrigger($data)
    {
        $current = count(ArrayHelper::getValue($data, $this->offset_response_key, []));
        return $current >= $this->max_limit;
    }
}
