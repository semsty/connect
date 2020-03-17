<?php

namespace connect\crm\base\traits;

use connect\crm\base\query\Response;

trait RandomRetryActionTrait
{
    public $random_retry_attempts = 0;
    public $random_retry_max_attempts = 10;
    public $random_retry_delay = 1000000;

    /**
     * @return array
     * @throws \Throwable
     * @throws \connect\crm\base\exception\ConnectException
     */
    public function getResponse(): array
    {
        try {
            $this->random_retry_attempts++;
            return parent::getResponse();
        } catch (\Throwable $e) {
            if ($this->random_retry_attempts < $this->random_retry_max_attempts) {
                usleep(rand(1000, $this->random_retry_delay));
                return $this->getResponse();
            } else {
                throw $e;
            }
        }
    }
}
