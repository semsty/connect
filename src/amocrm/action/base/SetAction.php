<?php

namespace connect\crm\amocrm\action\base;

use connect\crm\base\traits\RecipientAction;
use yii\helpers\ArrayHelper;

/**
 * Class SetAction
 * @property $data
 * @package connect\crm\amocrm\action\base
 */
class SetAction extends Action
{
    use RecipientAction;

    public $method = 'POST';
    public $data = [];

    public static function getEncodedFields()
    {
        return [];
    }

    public function getDefaultConfig(): array
    {
        return ArrayHelper::merge(parent::getDefaultConfig(), [
            'requestConfig' => [
                'format' => 'json',
                'data' => $this->getData()
            ]
        ]);
    }

    public function getData()
    {
        $query = [];
        foreach ($this->data as $mode => $mode_data) {
            foreach ($mode_data as $no => $data) {
                foreach ($data as $field_name => $field_value) {
                    $this->setFieldData($query[$mode], $no, $field_name, $field_value, $mode == 'update');
                }
            }
        }
        $query = $query[$mode];
        if ($mode == 'update') {
            $this->method = 'PATCH';
        }
        return $query;
    }

    public function setFieldData(&$mode, $no, $field_name, $field_value, $update = false)
    {
        if (ArrayHelper::isIn($field_name, static::getSystemFields())) {
            if (ArrayHelper::isIn($field_name, static::getSystemNumericFields())) {
                $field_value = (int)$field_value;
            }
            $mode[$no][$field_name] = $field_value;
            return;
        } elseif (!is_numeric($field_name)) {
            if (($field_id = $this->getFieldIdByName($field_name)) || ($field_id = $this->getFieldIdByName($field_name, 'code'))) {
                $field_name = $field_id;
            }
        }
        if (is_array($field_value)) {
            foreach ($field_value as $value_no => $multiple_field_value) {
                $this->setFieldEnumType($field_value[$value_no], $field_name);
            }
            $values = $field_value;
        } else {
            $values = [
                ['value' => $field_value]
            ];
            $this->setFieldEnumType($values[0], $field_name);
        }
        if ($update) {
            $mode[$no]['updated_at'] = strtotime('now');
        }
        $mode[$no]['custom_fields_values'][] = [
            'field_id' => $field_name,
            'values' => array_values($values)
        ];
    }

    public static function getSystemNumericFields()
    {
        return [
            'responsible_user_id'
        ];
    }

    public static function getSystemFields()
    {
        return [
            'id', 'name', 'last_modified', 'responsible_user_id', '_embedded'
        ];
    }

    public function getFieldIdByName($field_name, $key = 'name')
    {
        if ($field_info = $this->getFieldInfo($field_name, $key)) {
            return $field_info['id'];
        }
    }

    public function getFieldInfo($field_id, $key = 'id')
    {
        if ($info = $this->getEntityInfo()) {
            foreach ($info as $field_info) {
                if ($field_info[$key] == $field_id) {
                    return $field_info;
                }
            }
        }
    }

    public function getEntityInfo()
    {
        if ($this->service->schema->info) {
            return ArrayHelper::getValue(
                $this->service->schema->info,
                'custom_fields.' . $this->getEntityPluralizeName()
            );
        }
    }

    public function setFieldEnumType(&$values, $field_name)
    {
        if ($field_info = $this->getFieldInfo($field_name)) {
            if ($field_info['type'] == 'multitext' && !ArrayHelper::keyExists('enum', $values)) {
                $enums_keys = ArrayHelper::getColumn($field_info['enums'], 'value');
                $values['enum_code'] = array_shift($enums_keys);
            }
        }
    }

    public function run()
    {
        $data = parent::run();
        return $data['_embedded'][$this->getEntityPluralizeName()];
    }
}
