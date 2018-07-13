<?php

namespace semsty\connect\base\traits;

use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

trait ExtraAttributesModel
{
    protected $_extra_attributes = [];

    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $e) {
            if (ArrayHelper::keyExists($name, $this->_extra_attributes)) {
                return $this->_extra_attributes[$name];
            }
            throw $e;
        }
    }

    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (UnknownPropertyException $e) {
            $this->_extra_attributes[$name] = $value;
        }
    }
}