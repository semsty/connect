<?php

namespace semsty\connect\base\dict;

use yii\base\UnknownMethodException;

class Dictionaries extends Collection
{
    protected $_instance_class = Dictionary::class;

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
