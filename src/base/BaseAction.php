<?php

namespace connect\crm\base;

use connect\crm\base\exception\ConnectException;
use connect\crm\base\exception\Exception;
use connect\crm\base\exception\ProfileException;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\helpers\Json;
use connect\crm\base\query\Connection;
use connect\crm\base\query\Query;
use connect\crm\base\traits\ProfiledModel;
use connect\crm\base\traits\ReferenceReflection;
use connect\crm\base\traits\ServiceModel;
use connect\crm\Settings;
use yii\base\Event;
use yii\base\Model;

/**
 * Class BaseAction
 * @property $connection
 * @property $service Service
 * @property $profile Profile
 * @property $client
 * @property $isBatch
 * @package connect\crm\base\action
 */
class BaseAction extends Model
{
    use ServiceModel, ProfiledModel, ReferenceReflection;

    const ID = 0; //in service id
    const ACTION_ID = self::ID;
    const NAME = 'base-action';

    const EVENT_RUN = 'run';
    public $custom_config = [];
    protected $_batch = false;
    protected $path;

    public static function getProfileClass()
    {
        return static::getReferenceClass('Profile', Profile::class);
    }

    public static function getServiceClass()
    {
        return static::getReferenceClass('Service', Service::class);
    }

    public function getId(): int
    {
        return static::ID;
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function getIsBatch()
    {
        return $this->_batch;
    }

    public function setIsBatch(bool $value)
    {
        $this->_batch = $value;
        if ($value) {
            $this->validate();
            $this->getConnection();
        }
    }

    public function getConnection(): Connection
    {
        foreach ($this->getConfig() as $key => $value) {
            $this->service->connection->$key = $value;
        }
        $this->service->connection->owner = $this;
        return $this->service->connection;
    }

    public function getConfig(): array
    {
        return ArrayHelper::merge(
            $this->service->getConfig(),
            $this->getDefaultConfig(),
            $this->custom_config
        );
    }

    public function getDefaultConfig(): array
    {
        return [
            'requestConfig' => [
                'url' => [
                    $this->getUrl()
                ],
                'method' => property_exists(static::class, 'method') ? $this->method : 'GET',
                'options' => [
                    'returntransfer' => true,
                ]
            ]
        ];
    }

    protected function getUrl(): string
    {
        return $this->service->url . $this->path;
    }

    /**
     * @return array
     * @throws ConnectException
     * @throws Exception
     */
    public function run()
    {
        if ($this->isBatch) {
            return $this->batch();
        } else {
            $this->trigger(static::EVENT_RUN);
            if ($this->validate()) {
                return $this->getResponse();
            } else {
                throw new Exception(Json::encode($this->errors, JSON_PRETTY_PRINT));
            }
        }
    }

    public function batch()
    {
        return $this->service->connection->batch();
    }

    public function trigger($name, Event $event = null)
    {
        \Yii::info($name, static::class);
        return parent::trigger($name, $event); // TODO: Change the autogenerated stub
    }

    /**
     * @return array
     * @throws ConnectException
     */
    public function getResponse(): array
    {
        /**
         * @var $request Query
         */
        $request = $this->connection->createRequest();
        $response = $request->send();
        if ($response->isOk) {
            return $response->getData() ?: [];
        } else {
            throw new ConnectException($response->toString());
        }
    }

    public function setAuth($data)
    {
        foreach ($this->getAuthKeys() as $no => $key) {
            if (is_numeric($no)) {
                $assoc_key = $key;
            } else {
                $assoc_key = $no;
            }
            if (ArrayHelper::keyExists($key, $data)) {
                $this->$assoc_key = $data[$key];
            } else {
                throw new ProfileException("Profile key '$key' does not exists");
            }
        }
    }

    public function getAuthKeys(): array
    {
        return [];
    }

    public function getAuth(): array
    {
        $result = [];
        foreach ($this->getAuthKeys() as $no => $key) {
            if (is_numeric($no)) {
                $assoc_key = $key;
            } else {
                $assoc_key = $no;
            }
            $result[$key] = $this->$assoc_key;
        }
        return $result;
    }

    public function getLogPath()
    {
        return Settings::LOG_BASE_PATH . '/' . $this->getServiceName();
    }
}
