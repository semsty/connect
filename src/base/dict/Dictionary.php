<?php

namespace semsty\connect\base\dict;

use yii\base\BaseObject;
use yii\base\UnknownMethodException;

/**
 * Class Dictionary
 * @property $name
 * @package common\models\connect\dict\base
 */
class Dictionary extends BaseObject
{
    const DICT_NAME = 'dict';
    const DICT_NAME_DELIMITERS = '\-\_\.';

    public function values($name)
    {
        return array_values($this->get($name));
    }

    public function get($name)
    {
        $method_name = 'dict' . ucwords($name, static::DICT_NAME_DELIMITERS);
        $method_name = preg_replace('([' . static::DICT_NAME_DELIMITERS . ']+)', '', $method_name);
        if (method_exists(static::class, $method_name)) {
            return $this->$method_name();
        } else {
            throw new UnknownMethodException();
        }
    }

    public function keys($name)
    {
        return array_keys($this->get($name));
    }

    public function getName()
    {
        return static::DICT_NAME;
    }
}
