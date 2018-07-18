<?php

namespace connect\crm\base\query\traits;

use connect\crm\base\helpers\ArrayHelper;

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

    public function sendWithOffset()
    {
        $data = [];
        $result = [];
        $i = 0;
        do {
            $i++;
            $this->prepareRequest();
            $request = $this->createRequest();
            $response = $request->send();
            $data[$i] = $response->getData();
            $this->increment($data[$i]);
        } while (
            ArrayHelper::keyExists($i, $data)
            &&
            $data[$i]
            &&
            $this->endTrigger($data[$i])
            &&
            ($this->max_offset ? $i < $this->max_offset : true)
        );
        foreach ($data as $sub_data) {
            if ($sub_data) {
                $sub_data = ArrayHelper::getValue($sub_data, $this->cursor);
                $result = ArrayHelper::merge($sub_data, $result);
            }
        }
        return $result ? $result : [];
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

    protected function endTrigger($data)
    {
        $current = $this->max_limit * $this->current_offset;
        $max = $this->max_limit * ArrayHelper::getValue($data, $this->offset_response_key, 0);
        return $current <= $max;
    }
}
