<?php

namespace semsty\connect\retailcrm\query;

use semsty\connect\base\dict\Data;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\query\Schema as BaseSchema;
use semsty\connect\retailcrm\dict\Entities;

class Schema extends BaseSchema
{
    const COLUMN_NAME = 'name';
    const COLUMN_CODE = 'code';
    const COLUMN_ENTITY = 'entity';

    public function getFieldConstraints($name)
    {
        return ArrayHelper::merge($this->getFieldStaticConstraints($name), $this->getFieldCustomConstraints($name));
    }

    public function getFieldStaticConstraints($name)
    {
        $name = explode('.', $name);
        $entityName = $name[0];
        $fieldName = ArrayHelper::getValue($name, 1);
        $entity_info = $this->service->dictionaries->get($entityName . '.system.fields');
        if ($fieldName == '*') {
            return $entity_info;
        }
        return ArrayHelper::getValue($entity_info, $fieldName, []);
    }

    public function getFieldCustomConstraints($name)
    {
        $info = ArrayHelper::getValue($this->info, 'custom-dictionaries', []);
        foreach ([static::COLUMN_CODE, static::COLUMN_NAME] as $label) {
            $label_info = ArrayHelper::index($info, $label);
            if ($constraints = ArrayHelper::getValue($label_info, $name, [])) {
                return $constraints;
            }
        }
        return [];
    }

    public function getDefaultProxyFields()
    {
        return [
            Data::PHONE_NUMBER => 'phones.0.number',
            Data::EMAIL => Data::EMAIL,
            Data::MARK => Data::MARK,
            Entities::ORDER => [
                Data::UTM_SOURCE => 'source.source',
                Data::UTM_MEDIUM => 'source.medium',
                Data::UTM_CONTENT => 'source.content',
                Data::UTM_TERM => 'source.term',
                Data::UTM_CAMPAIGN => 'source.campaign',
                Data::GA_CLIENT_ID => Data::GA_CLIENT_ID,
            ],
            Entities::CUSTOMER => [
                Data::UTM_SOURCE => 'source.source',
                Data::UTM_MEDIUM => 'source.medium',
                Data::UTM_CONTENT => 'source.content',
                Data::UTM_TERM => 'source.term',
                Data::UTM_CAMPAIGN => 'source.campaign',
                Data::GA_CLIENT_ID => Data::GA_CLIENT_ID,
            ]
        ];
    }
}
