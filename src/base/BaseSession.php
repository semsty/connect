<?php

namespace connect\crm\base;

use connect\crm\base\db\ActiveRecord;
use connect\crm\base\helpers\Json;
use connect\crm\base\traits\ReferenceReflection;
use connect\crm\base\traits\ServiceModel;
use yii\db\ActiveQuery;

/**
 * Class Session
 * @property $profile_id
 * @property $profile
 * @property $service_id
 * @property $service
 * @property $config
 * @property $auth
 * @property $is_active
 * @package es\connect
 */
class BaseSession extends ActiveRecord
{
    use ServiceModel, ReferenceReflection;

    public static function getServiceClass()
    {
        return static::getReferenceClass('Service', Service::class);
    }

    public function rules(): array
    {
        return [
            [['service_id', 'profile_id', 'created_at', 'updated_at'], 'integer'],
            [['is_active'], 'boolean'],
            [['config_json'], 'string'],
            [['config', 'auth'], 'safe']
        ];
    }

    public function getAuth(): array
    {
        return $this->profile->config;
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

    public function setConfigPartially($name, $value)
    {
        $config = $this->getConfig();
        $config[$name] = $value;
        $this->setConfig($config);
    }

    public function getConfig(): array
    {
        return $this->getJsonField('config_json') ?? [];
    }

    public function setConfig($value)
    {
        return $this->setJsonField('config_json', $value);
    }

    public function activate(): bool
    {
        \Yii::info('Create: ' . Json::encode($this), static::class);
        $this->is_active = true;
        return $this->save();
    }

    public function deactivate(): bool
    {
        \Yii::info('Destruct: ' . Json::encode($this), static::class);
        $this->is_active = false;
        return $this->save();
    }
}
