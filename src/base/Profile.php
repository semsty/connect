<?php

namespace semsty\connect\base;

use semsty\connect\base\db\ActiveRecord;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\traits\ReferenceReflection;
use semsty\connect\base\traits\ServiceModel;

/**
 * Class Profile
 * @property $id
 * @property $service
 * @property $service_id
 * @property $config
 * @package connect\base
 */
class Profile extends ActiveRecord
{
    use ServiceModel, ReferenceReflection;

    public static function getAuthorizationAttributes(): array
    {
        return [];
    }

    public function rules()
    {
        $rules = [
            [['service_id'], 'required'],
            [['service_id', 'created_at', 'updated_at'], 'integer'],
            [['config_json', 'title'], 'string'],
            [['config'], 'safe']
        ];
        if ($required_keys = static::getRequiredKeys()) {
            return ArrayHelper::merge($rules, [
                [$required_keys, 'required'],
                [$required_keys, 'safe']
            ]);
        } else {
            return $rules;
        }
    }

    public static function getRequiredKeys(): array
    {
        return [];
    }

    public function getService(): Service
    {
        if (empty($this->_service)) {
            $className = $this->getServiceClassById();
            return new $className(['profile' => $this]);
        }
        return $this->_service;
    }

    public function getServiceClassById(): string
    {
        if ($this->service_id) {
            return Settings::getServices()[$this->service_id];
        } else {
            return $this->getServiceClass();
        }
    }

    public static function getServiceClass(): string
    {
        return static::getReferenceClass('Service', Service::class);
    }

    public function __get($name)
    {
        if (ArrayHelper::isIn($name, static::getRequiredKeys())) {
            return $this->getConfig()[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (ArrayHelper::isIn($name, static::getRequiredKeys())) {
            $this->setConfigPartially($name, $value);
        } else {
            parent::__set($name, $value);
        }
    }

    public function getConfig(): array
    {
        $config = $this->getJsonField('config_json');
        return $config ?? [];
    }

    public function setConfigPartially($name, $value)
    {
        $config = $this->getConfig();
        $config[$name] = $value;
        $this->setConfig($config);
    }

    public function setConfig($value)
    {
        return $this->setJsonField('config_json', $value);
    }

    public function init()
    {
        parent::init();
        $class = $this->getServiceClass();
        $this->service_id = $class::ID;
    }
}
