<?php

namespace connect\crm\retailcrm\query;

use connect\crm\base\query\Connection as BaseConnection;

class Connection extends BaseConnection
{
    protected function endTrigger($data)
    {
        return $data['pagination']['currentPage'] < $data['pagination']['totalPageCount'];
    }
}
