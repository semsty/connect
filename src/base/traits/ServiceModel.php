<?php

namespace semsty\connect\base\traits;

use semsty\connect\base\Service;

/**
 * Trait ServiceModel
 * @package semsty\connect\base\traits
 */
trait ServiceModel
{
    /**
     * @var $_service Service
     */
    protected $_service;

    public function getService(): Service
    {
        if (empty($this->_service)) {
            $className = static::getServiceClass();
            $attributes = $this->getServiceAttributes();
            if (property_exists(static::class, '_profile') && !empty($this->_profile)) {
                $attributes['profile'] = $this->_profile;
            }
            $this->_service = new $className($attributes);
        }
        return $this->_service;
    }

    /**
     * @param $service Service
     */
    public function setService(&$service)
    {
        $this->_service = $service;
    }

    public function getServiceAttributes(): array
    {
        return [];
    }

    public function getServiceName(): string
    {
        $class = static::getServiceClass();
        return $class::NAME;
    }
}
