<?php

namespace semsty\connect\bitrix24\query;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\query\Schema as BaseSchema;

class Schema extends BaseSchema
{
    const LIST_LABEL = 'listLabel';
    const FILTER_LABEL = 'filterLabel';
    const FORM_LABEL = 'formLabel';

    public function getFieldConstraints($name)
    {
        return ArrayHelper::merge($this->getFieldCustomConstraints($name), $this->getFieldStaticConstraints($name));
    }

    public function getFieldCustomConstraints($name)
    {
        list($entityName, $fieldName) = explode('.', $name);
        $fieldName = strtoupper($fieldName);
        $constraints = ArrayHelper::getValue($this->info[$entityName], $fieldName, []);
        if (empty($constraints)) {
            foreach ([static::FILTER_LABEL, static::LIST_LABEL, static::FORM_LABEL] as $label) {
                $info = ArrayHelper::index($this->info[$entityName], $label);
                if ($constraints = ArrayHelper::getValue($info, $fieldName, [])) {
                    return $constraints;
                }
            }
        };
        return $constraints;
    }

    public function getFieldStaticConstraints($name)
    {
        list($entityName, $fieldName) = explode('.', $name);
        return ArrayHelper::getValue($this->service->dictionaries->get($entityName . '.system.fields'), strtoupper($fieldName), []);
    }
}
