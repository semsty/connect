<?php

namespace connect\crm\bitrix24\action;

use connect\crm\base\traits\RecipientAction;
use connect\crm\bitrix24\action\base\Action;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

class Add extends Action
{
    use RecipientAction;

    const ID = 3;
    const NAME = 'create';

    public $data = [];
    public $entity = 'deal';

    public function getPath(): string
    {
        return 'rest/crm.' . $this->entity . '.add';
    }

    public function getDefaultConfig(): array
    {
        return ArrayHelper::merge(parent::getDefaultConfig(), [
            'requestConfig' => [
                'data' => $this->getData()
            ]
        ]);
    }

    public function getData()
    {
        $query = ['fields' => []];
        foreach ($this->data as $field_name => $field_value) {
            if ($this->getEntityInfo()) {
                $field_name = $this->getFieldName($field_name);
                if (ArrayHelper::keyExists($field_name, $this->getEntityInfo()) || static::checkSuffix($field_name)) {
                    $this->setFieldData($query, $field_name, $field_value);
                } else {
                    throw new ErrorException('Field ' . $field_name . ' does not exists in ' . $this->entity);
                }
            } else {
                $query['fields'][$field_name] = $field_value;
            }
        }
        return $query;
    }

    public function getEntityInfo()
    {
        return ArrayHelper::getValue($this->service->schema->info, $this->entity, []);
    }

    public function getFieldName($field_name)
    {
        $field_name = strtoupper($field_name);
        if (!ArrayHelper::keyExists($field_name, $this->getEntityInfo())) {
            foreach ($this->getEntityInfo() as $system_name => $data) {
                if (is_array($data) && ArrayHelper::keyExists('listLabel', $data)) {
                    if (strtolower($data['listLabel']) == strtolower($field_name)) {
                        $field_name = $system_name;
                    }
                }
            }
        }
        return $field_name;
    }

    public static function checkSuffix($field_name)
    {
        foreach (static::getFieldsWithSuffix() as $field) {
            $pattern = '/' . $field . '_(' . implode('|', static::getSuffixes($field)) . ')$/';
            $check = preg_match($pattern, $field_name, $matches);
            if ($check) {
                return true;
            }
        }
    }

    public static function getFieldsWithSuffix()
    {
        return [
            'PHONE', 'WEB', 'EMAIL', 'IM'
        ];
    }

    public static function getSuffixes($field = null)
    {
        $common = [
            'WORK', 'HOME', 'OTHER',
        ];
        $specific = [
            'PHONE' => ['MOBILE']
        ];
        return ArrayHelper::merge($common, ArrayHelper::getValue($specific, $field, []));
    }

    public function setFieldData(&$query, $name, $value)
    {
        $this->checkIsReadOnly($name);
        if ($this->getEntityInfo()[$name]['isMultiple'] && !is_array($value)) {
            $value = [$value];
        }
        if (is_array($value)) {
            $this->setMultipleField($query, $name, $value);
        } else {
            if (ArrayHelper::keyExists($name, $this->getEntityInfo()) && ArrayHelper::keyExists('items', $this->getEntityInfo()[$name])) {
                $this->setEnumField($name, $value);
            }
            $query['fields'][$name] = $value;
        }
    }

    public function checkIsReadOnly($field_name)
    {
        if ($this->getEntityInfo()[$field_name]['isReadOnly']) {
            throw new ErrorException('Field ' . $field_name . ' is read only');
        }
    }

    public function setMultipleField(&$query, $name, $multiple_value)
    {
        foreach ($multiple_value as $value) {
            if ($this->getEntityInfo()[$name]['isMultiple']) {
                if (empty($query['fields'][$name])) {
                    $query['fields'][$name] = [];
                }
                if (ArrayHelper::keyExists('items', $this->getEntityInfo()[$name])) {
                    $this->setEnumField($name, $value);
                }
                $query['fields'][$name][] = $value;
            } else {
                throw new ErrorException('Field ' . $name . ' not multiple');
            }
        }
        $query['fields'][$name] = array_values($query['fields'][$name]);
    }

    public function setEnumField($name, &$value)
    {
        $map = ArrayHelper::map($this->getEntityInfo()[$name]['items'], 'VALUE', 'ID');
        if (!ArrayHelper::keyExists($value, $map)) {
            throw new ErrorException('Value ' . $value . ' does not exist in list field ' . $name);
        }
        if ($map[$value]) {
            $value = $map[$value];
        }
    }
}
