<?php

namespace connect\crm;

use connect\crm\base\exception\InvalidConfiguration;
use connect\crm\base\exception\ProfileDoesNotExists;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\Profile;
use yii\base\Component;

/**
 * Class Connect
 * @property $profile
 * @package connect\crm
 */
class Connect extends Component
{
    public $profile;
    protected $_services = [];

    public function __get($name)
    {
        if (ArrayHelper::keyExists($name, Settings::getServicesNames())) {
            if (!ArrayHelper::keyExists($name, $this->_services)) {
                $class = Settings::getServicesNames()[$name];
                $this->_services[$name] = new $class;
            }
            return $this->_services[$name];
        }
        return parent::__get($name);
    }

    public function getServiceClass($key)
    {
        if (is_numeric($key)) {
            return Settings::getServices()[$key];
        } elseif (is_string($key)) {
            return Settings::getServicesNames()[$key];
        }
    }


    public function getActions($merge = false, $collapse = false)
    {
        return Settings::getActions($merge, $collapse);
    }

    /**
     * @param mixed $profile
     * @param $db
     * @return mixed
     * @throws InvalidConfiguration
     * @throws ProfileDoesNotExists
     */
    public function byProfile($profile, $db = true)
    {
        $class = Profile::class;
        if ($db) {
            if (!$this->profile = Profile::findOne($profile)) {
                throw new ProfileDoesNotExists("Profile does not exists: $profile");
            }
        } else {
            if ($id = ArrayHelper::getValue($profile, 'service_id')) {
                $class = ArrayHelper::getValue(Settings::getServices(), $id);
                $class = $class::getProfileClass();
            }
            $this->profile = new $class($profile);
        }
        if ($this->profile) {
            if ($class = ArrayHelper::getValue(Settings::getServices(), $this->profile->service_id)) {
                $service = new $class(['profile' => &$this->profile]);
                return $service;
            }
            throw new InvalidConfiguration("Service not found");
        }
    }
}