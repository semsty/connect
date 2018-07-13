<?php

namespace semsty\connect\base\operation;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\helpers\DateHelper;
use semsty\connect\Settings;


/**
 * Class BaseOperation
 * @property $config
 * @property $executing_time
 * @property $status_id
 * @property $type_id
 * @package common\models\operation
 */
class BaseOperation extends AbstractDataOperation
{
    const NAME = 'base-operation';

    public static function tableName(): string
    {
        return '{{%operation}}';
    }

    public function rules(): array
    {
        return [
            [['status_id', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['executing_time'], 'double'],
            [['config_json'], 'safe'],
            [['config_json'], 'default', 'value' => '{}'],
            [['type_id'], 'default', 'value' => static::OPERATION_ID],
            [['config', 'typeName'], 'safe']
        ];
    }

    public function init()
    {
        parent::init();
        $this->on('*.' . static::EVENT_PREPARE, [$this, 'handlePrepare']);
        $this->on('*.' . static::EVENT_RUN, [$this, 'handleRun']);
        $this->on('*.' . static::EVENT_END, [$this, 'handleEnd']);
        $this->on('*.' . static::EVENT_ERROR, [$this, 'handleError']);
        $this->on('*.' . static::EVENT_RETRY, [$this, 'handleRetry']);
        $this->on('*.' . static::EVENT_MANUALLY_RETRY, [$this, 'handleManuallyRetry']);
    }

    public function getExecutingTimeSec()
    {
        return round($this->executing_time, 2);
    }

    public function runSafely()
    {
        $start = DateHelper::getFloatMicroTime();
        $this->trigger(static::EVENT_RUN);
        $this->save();
        $success = true;
        try {
            $this->run();
            $this->trigger(static::EVENT_END);
        } catch (\Exception $e) {
            $this->_data = $e->getMessage() . "\n" . $e->getTraceAsString();
            $this->_error = $e;
            $this->trigger(static::EVENT_ERROR);
            $success = false;
        }
        $this->executing_time = DateHelper::getFloatMicroTime() - $start;
        if ($this->save()) {
            return $success;
        }
    }

    public function manuallyRetry()
    {
        $this->trigger(static::EVENT_MANUALLY_RETRY);
        $this->retry();
    }

    public function retry()
    {
        $this->trigger(static::EVENT_RETRY);
        $className = $this->getClass();
        $operation = $className::findOne($this->id);
        $operation->retry();
    }

    public function getClass(): string
    {
        $className = Settings::getOperation($this->type_id, true, true);
        if (!$className) {
            $className = static::class;
        }
        return $className;
    }

    public function getError()
    {
        return $this->_error;
    }

    public function getTypeName(): string
    {
        $className = $this->getClass();
        return $className::NAME;
    }

    public function setConfig($value)
    {
        $this->setJsonField('config_json', $value);
    }

    public function setConfigPartially($key, $value)
    {
        $config = $this->config;
        ArrayHelper::setValue($config, $key, $value);
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->getJsonField('config_json');
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status_id = static::STATUS_CREATED;
        }
        return parent::beforeSave($insert);
    }

    public function handlePrepare($event = null)
    {
        $this->status_id = static::STATUS_PREPARED;
    }

    public function handleRun($event = null)
    {
        $this->status_id = static::STATUS_RUNNING;
        $this->commit();
    }

    public function handleEnd($event = null)
    {
        $this->status_id = static::STATUS_ENDED;
    }

    public function handleError($event = null)
    {
        $this->status_id = static::STATUS_ERROR;
        $this->rollback();
    }

    public function handleRetry($event = null)
    {
        $this->status_id = static::STATUS_RETRIED;
    }

    public function handleManuallyRetry($event = null)
    {
        $this->status_id = static::STATUS_MANUALLY_RETRIED;
    }
}
