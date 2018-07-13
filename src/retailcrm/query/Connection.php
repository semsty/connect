<?php

namespace semsty\connect\retailcrm\query;

use semsty\connect\base\query\Connection as BaseConnection;

class Connection extends BaseConnection
{
    protected function endTrigger($data)
    {
        return $data['pagination']['currentPage'] < $data['pagination']['totalPageCount'];
    }
}
