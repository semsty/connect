<?php

namespace semsty\connect\base\query\traits;

use semsty\connect\base\helpers\ArrayHelper;

/**
 * Trait RateLimitTrait
 * @package connect\base\query\traits
 */
trait RateLimitedModel
{
    public $rate_limit_map = [];
    public $attempt_limit_map = [];
    public $limit_log = [];
    protected $method_attempts = [];
    protected $rate_map = [];

    public function __call($method_name, $args)
    {
        if (method_exists($this, '_' . $method_name)) {
            $this->checkMethodLimit($method_name);
            return call_user_func_array([$this, '_' . $method_name], $args);
        }
        return parent::__call($method_name, $args);
    }

    protected function checkMethodLimit($method_name)
    {
        $method_rate = &$this->rate_map[$method_name];
        $method_limit = &$this->rate_limit_map[$method_name];
        $attempts = &$this->method_attempts[$method_name];
        $this->limit_log[$method_name][] = [$this->microtime_float() => $attempts];
        $current_rate = $this->microtime_float() - (float)$method_rate;
        if ($this->checkMethodMap($method_name)) {
            if (($attempts >= $this->attempt_limit_map[$method_name]) && ($method_limit - $current_rate) >= 0) {
                usleep(($method_limit - $current_rate) * 1000000);
                $attempts = 0;
                $method_rate = $this->microtime_float();
            } else {
                $attempts++;
            }
        }
    }

    protected function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return (float)$usec + (float)$sec;
    }

    protected function checkMethodMap($method_name)
    {
        $limit = ArrayHelper::getValue($this->rate_limit_map, $method_name);
        $attempt = ArrayHelper::getValue($this->attempt_limit_map, $method_name);
        return !empty($limit) && !empty($attempt) && $limit >= 0 && $attempt >= 0;
    }

    public function setRateMap($data)
    {
        $this->rate_limit_map = $data['rate_limit'];
        $this->attempt_limit_map = $data['attempt_limit'];
        $this->prepare();
    }

    protected function prepare()
    {
        foreach ($this->rate_limit_map as $method_name => $limit) {
            $this->rate_map[$method_name] = $this->microtime_float();
            $this->method_attempts[$method_name] = 0;
            if (!array_key_exists($method_name, $this->attempt_limit_map)) {
                $this->attempt_limit_map[$method_name] = 1;
            }
        }
    }

    protected function getMethodLimitRate($method_name)
    {
        return $this->rate_limit_map[$method_name];
    }
}
