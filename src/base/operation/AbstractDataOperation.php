<?php

namespace connect\crm\base\operation;

use connect\crm\base\db\ActiveRecord;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\helpers\DateHelper;
use yii\base\Event;

/**
 * Class AbstractDataOperation
 * @property $status_id
 * @property $config
 * @package connect\crm\base\operation
 */
abstract class AbstractDataOperation extends ActiveRecord
{
    const OPERATION_ID = 0;
    const NAME = 'abstract';

    const STATUS_CREATED = 0;
    const STATUS_PREPARED = 1;
    const STATUS_RUNNING = 2;
    const STATUS_ENDED = 3;
    const STATUS_ERROR = 5;
    const STATUS_RETRIED = 9;
    const STATUS_MANUALLY_RETRIED = self::STATUS_RETRIED;

    const EVENT_PREPARE = 'operation.prepare';
    const EVENT_RUN = 'operation.run';
    const EVENT_END = 'operation.end';
    const EVENT_ERROR = 'operation.error';
    const EVENT_RETRY = 'operation.retry';
    const EVENT_MANUALLY_RETRY = 'operation.manually_retry';
    public $_data;
    public $_start_time;
    protected $_config = [];
    protected $default_config = [];
    protected $_events = [];
    protected $_error;

    public function execute()
    {
        $this->run();
    }

    public function run()
    {
        return $this->_data;
    }

    public function isSuccess(): bool
    {
        return $this->status_id == static::STATUS_ENDED;
    }

    public function isError(): bool
    {
        return ArrayHelper::isIn($this->status_id, [static::STATUS_ERROR, static::STATUS_RETRIED]);
    }

    public function isRetried(): bool
    {
        return $this->status_id == static::STATUS_RETRIED;
    }

    public function isRunning(): bool
    {
        return ArrayHelper::isIn($this->status_id, [static::STATUS_RUNNING, static::STATUS_CREATED, static::STATUS_PREPARED]);
    }

    public function getStatusName()
    {
        if ($this->status_id) {
            return static::getStatusesNames()[$this->status_id];
        }
    }

    public static function getStatusesNames(): array
    {
        return [
            static::STATUS_CREATED => 'Created',
            static::STATUS_PREPARED => 'Prepared',
            static::STATUS_RUNNING => 'Running',
            static::STATUS_ENDED => 'Success',
            static::STATUS_ERROR => 'Error',
            static::STATUS_RETRIED => 'Retried'
        ];
    }

    public function trigger($name, Event $event = null)
    {
        $name = $this->getEventName($name);
        $this->_events[] = [$name, $event, DateHelper::getFloatMicroTime()];
        \Yii::info($name, static::class);
        return parent::trigger($name, $event);
    }

    public function getEventName($name): string
    {
        $path = explode('.', $name);
        $origin = end($path);
        if (static::isModelEvent($origin)) {
            $name = $origin;
        }
        return $name;
    }

    public function commit()
    {
        $this->_start_time = DateHelper::getFloatMicroTime();
    }

    public function rollback()
    {
        foreach ($this->_events as $data) {
            $this->rollbackEvent(...$data);
        }
    }

    public function rollbackEvent($name, $event = null, $time = null)
    {
        $method_name = 'rollback' . ucwords($name, '\.');
        $method_name = preg_replace('([\.]+)', '', $method_name);
        if (method_exists(static::class, $method_name)) {
            $this->$method_name($name, $event);
        }
    }
}
