<?php

namespace connect\crm\tests\app;

use connect\crm\base\query\traits\RateLimitedModel;

class TestRateLimit
{
    use RateLimitedModel;

    public function __call($method_name, $args)
    {
        if (method_exists($this, '_' . $method_name)) {
            $this->checkMethodLimit($method_name);
            return call_user_func_array([$this, '_' . $method_name], $args);
        }
        return parent::__call($method_name, $args);
    }

    public function _limitedMethod($timestamp)
    {
        return $this->time() - $timestamp;
    }

    public function time()
    {
        return $this->microtime_float();
    }

    public function attempts($method_name)
    {
        return $this->method_attempts[$method_name];
    }
}
