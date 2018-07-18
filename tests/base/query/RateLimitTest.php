<?php

namespace connect\crm\tests\base\query;

use connect\crm\tests\app\TestRateLimit;
use connect\crm\tests\base\TestCase;

class RateLimitTest extends TestCase
{
    /**
     * @var TestRateLimit
     */
    protected $instance;

    public function testRateLimit()
    {
        $this->instance->setRateMap([
            'rate_limit' => ['limitedMethod' => 1],
            'attempt_limit' => ['limitedMethod' => 1]
        ]);
        $this->instance->limitedMethod($this->instance->time());
        $seconds = $this->instance->limitedMethod($this->instance->time());
        expect(round($seconds))->equals(1);
    }

    public function testRateLimitSecondLess()
    {
        $this->instance->setRateMap([
            'rate_limit' => ['limitedMethod' => 1],
            'attempt_limit' => ['limitedMethod' => 13]
        ]);
        foreach (range(1, 13) as $attempt_no) {
            $this->instance->limitedMethod($this->instance->time());
            expect($this->instance->attempts('limitedMethod'))->equals($attempt_no);
        }
        $seconds = $this->instance->limitedMethod($this->instance->time());
        expect($this->instance->attempts('limitedMethod'))->equals(0);
        expect(round($seconds))->equals(1);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->instance = new TestRateLimit();
    }
}
