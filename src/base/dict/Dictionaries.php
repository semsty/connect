<?php

namespace connect\crm\base\dict;

use yii\base\UnknownMethodException;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class Dictionaries extends Collection
{
    protected $_instance_class = Dictionary::class;

    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $e) {
            if (ArrayHelper::getValue($this->_models, $name)) {
                return $this->_models[$name];
            }
            throw $e;
        }
    }

    public function values($name, $first = true, $default = null)
    {
        return array_values($this->get($name, $default, $first));
    }

    public function get($name, $first = true, $default = null)
    {
        $results = [];
        foreach ($this->_models as $dictionary) {
            /**
             * @var $dictionary Dictionary
             */
            try {
                $results[] = $dictionary->get($name);
            } catch (UnknownMethodException $e) {
                continue;
            }
        }
        if ($results) {
            if ($first) {
                return $results[0];
            }
            return $results;
        }
        return $default;
    }

    public function keys($name, $first = true, $default = null)
    {
        return array_keys($this->get($name, $first, $default));
    }
}
