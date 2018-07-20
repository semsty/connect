<?php

namespace connect\crm\base\query\traits;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\query\Query;

/**
 * Trait BatchConnection
 * @package connect\base\query\traits
 */
trait BatchConnection
{
    /**
     * @var $limit_request_key
     * request key of limit attribute
     */
    public $limit_request_key;

    /**
     * @var $limit_response_key
     * response key of limit attribute
     */
    public $limit_response_key;

    /**
     * @var $offset_request_key
     * request key of offset attribute
     */
    public $offset_request_key;

    /**
     * @var $offset_response_key
     * response key of offset attribute
     */
    public $offset_response_key;

    /**
     * @var $max_limit
     * maximum iteration limit
     */
    public $max_limit;

    /**
     * @var $offset_increment
     * increment of iteration offset
     */
    public $offset_increment;

    /**
     * @var $current_offset
     * offset of current iteration
     */
    public $current_offset;

    /**
     * @var $cursor
     * key on which to merge data
     */
    public $cursor;

    /**
     * @var int $max_offset
     */
    public $max_offset = 0;

    /**
     * @var int $current_batch
     */
    protected $current_batch = 0;

    /**
     * @var bool $previous_result
     */
    protected $previous_result = true;

    public function batch()
    {
        if (
            $this->previous_result
            &&
            ($this->max_offset ? $this->current_batch < $this->max_offset : true)
        ) {
            $this->current_batch++;
            $this->prepareRequest();
            $request = $this->createRequest();
            /**
             * @var $request Query
             */
            $response = $request->send();
            $payload = $response->getData();
            $this->increment($payload);
            $this->previous_result = $this->checkPayload($payload);
            $data = ArrayHelper::getValue($payload, $this->cursor, []);
            return $data;
        }
    }

    protected function prepareRequest()
    {
        $sub_config = [
            'url' => [
                $this->limit_request_key => $this->max_limit,
                $this->offset_request_key => $this->current_offset
            ]
        ];
        $this->requestConfig = ArrayHelper::merge($this->requestConfig, $sub_config);
    }

    protected function increment($data = null)
    {
        $this->current_offset = $this->current_offset + $this->offset_increment;
    }

    protected function checkPayload($data)
    {
        $current = $this->max_limit * $this->current_offset;
        $max = $this->max_limit * ArrayHelper::getValue($data, $this->offset_response_key, 0);
        return $current <= $max;
    }

    public function all()
    {
        $result = [];
        $i = 0;
        while ($data = $this->batch()) {
            $i++;
            $result = ArrayHelper::merge($result, $data);
        }
        $this->reset();
        return $result;
    }

    public function reset()
    {
        $this->current_batch = 0;
        $this->previous_result = true;
    }
}
