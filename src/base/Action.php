<?php

namespace semsty\connect\base;

use semsty\connect\base\exception\ConnectException;
use semsty\connect\base\exception\Exception;
use semsty\connect\base\exception\ProfileException;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\query\Connection;
use semsty\connect\base\query\Query;
use semsty\connect\base\traits\ProfiledModel;
use semsty\connect\base\traits\ReferenceReflection;
use semsty\connect\base\traits\ServiceModel;
use yii\base\Model;

/**
 * Class Action
 * @property $connection
 * @property $service Service
 * @property $profile Profile
 * @package semsty\connect\base\action
 */
class Action extends Model
{
    use ServiceModel, ProfiledModel, ReferenceReflection;

    const ID = 0; //in service id
    const NAME = 'base-action';

    const EVENT_RUN = 'run';
    public $custom_config = [];
    protected $path;

    public static function getProfileClass()
    {
        return static::getReferenceClass('Profile', Profile::class);
    }

    public static function getServiceClass()
    {
        return static::getReferenceClass('Service', Service::class);
    }

    /**
     * @return array
     * @throws ConnectException
     * @throws Exception
     */
    public function run()
    {
        $this->trigger(static::EVENT_RUN);
        if ($this->validate()) {
            return $this->getResponse();
        } else {
            throw new Exception($this->errors);
        }
    }

    public function trigger($name, \yii\base\Event $event = null)
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
