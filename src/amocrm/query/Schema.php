<?php

namespace semsty\connect\amocrm\query;

use semsty\connect\amocrm\dict\Data;
use semsty\connect\amocrm\dict\Entities;
use semsty\connect\amocrm\dict\Types;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\query\Schema as BaseSchema;

class Schema extends BaseSchema
{
    const CUSTOM_FIELD_ID = 'id';
    const CUSTOM_FIELD_NAME = 'name';
    const CUSTOM_FIELD_CODE = 'code';

    const COLUMN_ENUMERATION = 'enums';

    public function setInfo($data)
    {
        parent::setInfo($data);
        foreach ($this->_info['custom_fields'] as $entity => $custom_fields) {
            foreach ($custom_fields as $no => $custom_field) {
                $this->_info['custom_fields'][$entity][$no]['type'] = Types::dictFieldTypes()[$custom_field['type_id']];
                $this->_info['custom_fields'][$entity][$no]['code'] = strtolower($custom_field['code']);
                $this->_info['custom_fields'][$entity][$no]['name'] = mb_strtolower(str_replace(' ', '-', $custom_field['name']));
            }
        }
    }

    public function isFieldRequired($name)
    {
        return $this->getFieldAttribute($name, static::COLUMN_REQUIRED);
    }

    public function getFieldAttribute($name, $attribute)
    {
        $constraints = $this->getFieldConstraints($name);
        if ($constraints) {
            return ArrayHelper::getValue($constraints, $attribute);
        }
    }

    public function getFieldConstraints($name)
    {
        return ArrayHelper::merge($this->getFieldStaticConstraints($name), $this->getFieldCustomConstraints($name));
    }

    public function getFieldStaticConstraints($name)
    {
        list($entityName, $fieldName) = explode('.', $name);
        $constraints = ArrayHelper::getValue($this->service->dictionaries->get($entityName . '.system.fields'), $fieldName, []);
        if ($fieldName == 'status_id') {
            $constraints[static::COLUMN_ENUMERATION] = ArrayHelper::map($this->info['leads_statuses'], 'id', 'name');
        }
        return $constraints;
    }

    public function getFieldCustomConstraints($name)
    {
        list($entityName, $fieldName) = explode('.', $name);
        $info = ArrayHelper::getValue($this->info, 'custom_fields', []);
        if (substr($entityName, -1) != 's') {
            $entityName .= 's';
        }
        if (ArrayHelper::keyExists($entityName, $info)) {
            foreach ([static::CUSTOM_FIELD_ID, static::CUSTOM_FIELD_NAME, static::CUSTOM_FIELD_CODE] as $label) {
                $label_info = ArrayHelper::index($info[$entityName], $label);
                if ($constraints = ArrayHelper::getValue($label_info, $fieldName, [])) {
                    return $constraints;
                }
            }
        }
        return [];
    }

    public function getFieldsType($name)
    {
        return $this->getFieldAttribute($name, static::COLUMN_TYPE);
    }

    public function getDefaultProxyFields(): array
    {
        $result = [];
        foreach ([Entities::LEAD, Entities::CONTACT] as $entity_name) {
            foreach ($this->info['custom_fields'][Entities::getEntityTypePluralize($entity_name)] as $entity_field) {
                foreach (Data::dictContextAttributes() as $context_field) {
                    if ($this->compareFieldByName($entity_field, $context_field)) {
                        $result[$entity_name][$context_field] = $entity_field[static::CUSTOM_FIELD_ID];
                    }
                }
                if ($entity_name == Entities::CONTACT) {
                    foreach ([Data::PHONE_NUMBER, Data::EMAIL, Data::MARK] as $context_field) {
                        if ($this->compareFieldByName($entity_field, $context_field)) {
                            $result[$context_field] = $entity_field[static::CUSTOM_FIELD_ID];
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function compareFieldByName($field, $expect)
    {
        foreach ([static::CUSTOM_FIELD_NAME, static::CUSTOM_FIELD_CODE, static::CUSTOM_FIELD_ID] as $identifier) {
            $comparable = strtolower(str_replace('_alytics', '', $field[$identifier]));
            if ($comparable == $expect) {
                return true;
            }
        }
    }
}
