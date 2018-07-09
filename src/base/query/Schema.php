<?php

namespace semsty\connect\base\query;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\Service;
use semsty\connect\base\traits\ReferenceReflection;
use semsty\connect\base\traits\ServiceModel;
use yii\base\BaseObject;

/**
 * Class Schema
 * @property $info info
 * @property $service Service
 * @package common\models\connect\query\base
 */
class Schema extends BaseObject
{
    use ServiceModel, ReferenceReflection;

    const COLUMN_TYPE = 'type';
    const COLUMN_REQUIRED = 'required';
    const COLUMN_ENUMERATION = 'enumeration';

    const TYPE_CHAR = 'char';
    const TYPE_STRING = 'string';
    const TYPE_TEXT = 'text';
    const TYPE_SMALLINT = 'smallint';
    const TYPE_INTEGER = 'integer';
    const TYPE_BIGINT = 'bigint';
    const TYPE_FLOAT = 'float';
    const TYPE_DOUBLE = 'double';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_DATETIME = 'datetime';
    const TYPE_TIMESTAMP = 'timestamp';
    const TYPE_TIME = 'time';
    const TYPE_DATE = 'date';
    const TYPE_BINARY = 'binary';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_ARRAY = 'array';

    public $_info;

    public static function getServiceClass()
    {
        return static::getReferenceClass('\Service', Service::class, 1);
    }

    public function getInfo()
    {
        return $this->_info;
    }

    public function setInfo($data)
    {
        $this->_info = $data;
    }

    public function getFieldConstraints($name)
    {
        return ArrayHelper::merge($this->getFieldCustomConstraints($name), $this->getFieldStaticConstraints($name));
    }

    public function getFieldCustomConstraints($name)
    {
        return [];
    }

    public function getFieldStaticConstraints($name)
    {
        return $this->service->dictionaries->keys($name . 's');
    }

    public function getCustomFieldsRules()
    {
        return [];
    }

    public function getDefaultProxyFields()
    {
        return [];
    }
}
