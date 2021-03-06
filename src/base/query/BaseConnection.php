<?php

namespace connect\crm\base\query;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\query\traits\BatchConnection;
use connect\crm\base\query\traits\RateLimitedModel;
use connect\crm\base\traits\ServiceModel;
use yii\base\Event;
use yii\httpclient\Client;

/**
 * Class Connection
 * @property $service Service
 * @property $owner
 * @package connect\base\query
 */
class BaseConnection extends Client
{
    use ServiceModel, RateLimitedModel, BatchConnection;

    const EVENT_CHECK_RATE_LIMIT = 'check-rate-limit';

    protected $_owner = null;

    protected $_error_handler;

    public function getErrorHandler()
    {
        if (empty($this->_error_handler)) {
            $class = static::getErrorHandlerClass();
            $this->_error_handler = new $class(['connection' => $this]);
        }
        return $this->_error_handler;
    }

    public static function getErrorHandlerClass()
    {
        return static::getReferenceClass('ErrorHandler', ErrorHandler::class, 0);
    }

    public function getOwner()
    {
        return $this->_owner;
    }

    public function setOwner($owner)
    {
        if ($this->_owner != $owner) {
            $this->reset();
        }
        $this->_owner = $owner;
    }

    public function init()
    {
        parent::init();
        $this->on('*.' . static::EVENT_CHECK_RATE_LIMIT, [$this, 'handleCheckRateLimit']);
    }

    public function setRateLimit($value)
    {
        $this->setRateMap([
            'rate_limit' => ['createRequest' => $value[0]],
            'attempt_limit' => ['createRequest' => $value[1]]
        ]);
    }

    public function getResponse(): Response
    {
        return $this->createRequest()->send();
    }

    public function getRateLimit()
    {
        return [
            ArrayHelper::getValue($this->rate_limit_map, 'createRequest'),
            ArrayHelper::getValue($this->attempt_limit_map, 'createRequest'),
            ArrayHelper::getValue($this->method_attempts, 'createRequest'),
            ArrayHelper::getValue($this->rate_map, 'createRequest')
        ];
    }

    public function createRequest()
    {
        $this->trigger(static::EVENT_CHECK_RATE_LIMIT);
        $this->checkMethodLimit('createRequest');
        if (!ArrayHelper::keyExists('createRequest', $this->rate_limit_map)) {
            ArrayHelper::setValue($this->rate_limit_map, 'createRequest', 0);
        }
        if (!ArrayHelper::keyExists('createRequest', $this->attempt_limit_map)) {
            ArrayHelper::setValue($this->attempt_limit_map, 'createRequest', 0);
        }
        return parent::createRequest();
    }

    public function trigger($name, Event $event = null)
    {
        $service_name = $this->service->name;
        if ($event && empty($event->sender)) {
            $event->sender = $this->owner;
        }
        return parent::trigger("$service_name.connection.$name", $event);
    }

    public function handleCheckRateLimit($event = null)
    {

    }
}
