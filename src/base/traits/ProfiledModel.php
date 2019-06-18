<?php

namespace connect\crm\base\traits;

use connect\crm\base\exception\ProfileDoesNotExists;
use connect\crm\base\Profile;
use connect\crm\base\query\exception\InvalidConfiguration;

/**
 * Trait ProfiledModelTrait
 * @property $profile BaseProfile
 * @package common\models\connect\traits
 */
trait ProfiledModel
{
    /**
     * @var $_profile Profile
     */
    protected $_profile;

    /**
     * @param $profile
     * @return ProfiledModel
     * @throws InvalidConfiguration
     * @throws ProfileDoesNotExists
     * @throws \connect\crm\base\exception\ProfileException
     */
    public function withProfile($profile): self
    {
        $profile = $this->getOrCreateProfile($profile);
        $this->setProfile($profile);
        return $this;
    }

    /**
     * @param $data
     * @return Profile|string
     * @throws InvalidConfiguration
     * @throws ProfileDoesNotExists
     */
    public function getOrCreateProfile(&$data): Profile
    {
        $className = static::getProfileClass();
        if (is_numeric($data)) {
            $profile = $className::findOne($data);
            if (empty($profile)) {
                throw new ProfileDoesNotExists("Profile ID $data does not exists");
            }
        } elseif (is_string($data)) {
            $profile = $className::find()->where(['like', 'title', $data])->one();
        } elseif (is_array($data)) {
            $profile = new $className($data);
        } elseif ($data instanceof $className) {
            $profile = &$data;
        } elseif ($data instanceof Profile) {
            if ($data->id) {
                $profile = $className::findOne($data->id);
            } else {
                $profile = new $className($data->getAttributes());
            }
        } else {
            throw new InvalidConfiguration("Data must be passed as ID, title, array of config or $className instance");
        }
        /**
         * @var $profile Profile
         */
        if (property_exists(static::class, '_service') && !empty($this->_service)) {
            $profile->service = $this->_service;
        }
        return $profile;
    }

    public function getProfile($create = true): Profile
    {
        if ($create && empty($this->_profile)) {
            $className = static::getProfileClass();
            $attributes = $this->getProfileAttributes();
            if (property_exists(static::class, '_service') && !empty($this->_service)) {
                $attributes['service'] = $this->_service;
            }
            $this->_profile = new $className($attributes);
        }
        return $this->_profile;
    }

    /**
     * @param Profile $profile
     * @throws \connect\crm\base\exception\ProfileException
     */
    public function setProfile(Profile &$profile)
    {
        $this->_profile = $profile;
        if (method_exists($this, 'setAuth')) {
            $this->setAuth($this->_profile->config);
        }
    }

    public function getProfileAttributes(): array
    {
        return [];
    }
}
