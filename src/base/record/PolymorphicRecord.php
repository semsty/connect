<?php

namespace semsty\connect\base\record;

/**
 * Class PolymorphicRecord
 * @package common\models\connect\record\base
 */
class PolymorphicRecord extends ExternalRecord
{

    public static function find()
    {
        $query = parent::find();
        $query->andWhere(['type' => static::getStaticTypes()]);
        return $query;
    }

    public static function getStaticTypes(): array
    {
        return [
            static::DEFAULT_TYPE
        ];
    }
}
