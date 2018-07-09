<?php

namespace semsty\connect\bitrix24\query;

use semsty\connect\base\query\Connection as BaseConnection;

class Connection extends BaseConnection
{
    protected function increment($data = null)
    {
        $this->max_limit = $this->getByKey($data, $this->limit_response_key);
    }

    protected function endTrigger($data)
    {
        return $this->getByKey($data, $this->limit_response_key);
    }
}
