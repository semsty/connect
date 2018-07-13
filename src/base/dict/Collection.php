<?php

namespace semsty\connect\base\dict;

use yii\base\BaseObject;
use yii\base\InvalidCallException;

class Collection extends BaseObject implements \IteratorAggregate, \ArrayAccess, \Countable
{
    public $readOnly = true;

    protected $_instance_class = BaseObject::class;
    protected $_models;

    public function __construct($models = [], $config = [])
    {
        foreach ($models as $model) {
            if (!($model instanceof $this->_instance_class)) {
                $instance = new $model();
                $this->_models[$instance->name] = $instance;
            }
        }
        parent::__construct($config);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_models);
    }

    public function count()
    {
        return $this->getCount();
    }

    public function getCount()
    {
        return count($this->_models);
    }

    public function getValue($name, $defaultValue = null)
    {
        return isset($this->_models[$name]) ? $this->_models[$name]->value : $defaultValue;
    }

    public function removeAll()
    {
        if ($this->readOnly) {
            throw new InvalidCallException('The collection is read only.');
        }
        $this->_models = [];
    }

    public function toArray()
    {
        return $this->_models;
    }

    public function fromArray(array $array)
    {
        $this->_models = $array;
    }

    public function offsetExists($name)
    {
        return $this->has($name);
    }

    public function has($name)
    {
        return isset($this->_models[$name]);
    }

    public function offsetGet($name)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        return isset($this->_models[$name]) ? $this->_models[$name] : null;
    }

    public function offsetSet($name, $model)
    {
        $this->add($model);
    }

    public function add($model)
    {
        if ($this->readOnly) {
            throw new InvalidCallException('The collection is read only');
        }
        $this->_models[$model->name] = $model;
    }

    public function offsetUnset($name)
    {
        $this->remove($name);
    }

    public function remove($model)
    {
        if ($this->readOnly) {
            throw new InvalidCallException('The collection is read only');
        }
        if ($model instanceof $this->_instance_class) {
            unset($this->_models[$model->name]);
        }
    }
}
