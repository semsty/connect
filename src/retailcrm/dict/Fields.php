<?php

namespace connect\crm\retailcrm\dict;

use connect\crm\base\dict\Dictionary;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\retailcrm\query\Schema;

class Fields extends Dictionary
{
    const DICT_NAME = 'fields';

    public static function dictOrderSystemFields()
    {
        $dict = ArrayHelper::merge(static::dictCommonSystemFields(), [
            'firstName' => [
                Schema::COLUMN_NAME => 'Имя',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'lastName' => [
                Schema::COLUMN_NAME => 'Фамилия',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'patronymic' => [
                Schema::COLUMN_NAME => 'Отчетство',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'number' => [
                Schema::COLUMN_NAME => 'Номер',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'phone' => [
                Schema::COLUMN_NAME => 'Телефон',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'additionalPhone' => [
                Schema::COLUMN_NAME => 'Дополнительный телефон',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'email' => [
                Schema::COLUMN_NAME => 'Email',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'status' => [
                Schema::COLUMN_NAME => 'Статус',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'orderType' => [
                Schema::COLUMN_NAME => 'Тип',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'orderMethod' => [
                Schema::COLUMN_NAME => 'Способ',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'managerComment' => [
                Schema::COLUMN_NAME => 'Комментарий менеджера',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'customerComment' => [
                Schema::COLUMN_NAME => 'Комментарий клиента',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'delivery' => [
                Schema::COLUMN_NAME => 'Доставка',
                Schema::COLUMN_TYPE => Schema::TYPE_ARRAY,
                Schema::COLUMN_REQUIRED => false
            ],
            'customer' => [
                Schema::COLUMN_NAME => 'Клиент',
                Schema::COLUMN_TYPE => Schema::TYPE_ARRAY,
                Schema::COLUMN_REQUIRED => false
            ]
        ]);
        return static::setAdditionalColumnFields($dict, Entities::ORDER);
    }

    public static function dictCommonSystemFields()
    {
        return [
            'externalId' => [
                Schema::COLUMN_NAME => 'Внешний ID',
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ],
            'createdAt' => [
                Schema::COLUMN_NAME => 'Дата создания',
                Schema::COLUMN_TYPE => Schema::TYPE_DATETIME,
                Schema::COLUMN_REQUIRED => false
            ],
            'managerId' => [
                Schema::COLUMN_NAME => 'Менеджер',
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ]
        ];
    }

    public static function setAdditionalColumnFields($dict, $entity)
    {
        foreach ($dict as $code => $values) {
            $dict[$code][Schema::COLUMN_ENTITY] = $entity;
            $dict[$code][Schema::COLUMN_CODE] = $code;
        }
        return $dict;
    }

    public static function dictCustomerSystemFields()
    {
        $dict = ArrayHelper::merge(static::dictCommonSystemFields(), [
            'firstName' => [
                Schema::COLUMN_NAME => 'Имя',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'lastName' => [
                Schema::COLUMN_NAME => 'Фамилия',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'patronymic' => [
                Schema::COLUMN_NAME => 'Отчетство',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'email' => [
                Schema::COLUMN_NAME => 'Email',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'phones' => [
                Schema::COLUMN_NAME => 'Телефон',
                Schema::COLUMN_TYPE => Schema::TYPE_ARRAY,
                Schema::COLUMN_REQUIRED => false
            ]
        ]);
        return static::setAdditionalColumnFields($dict, Entities::CUSTOMER);
    }

    public static function dictNoteSystemFields()
    {
        $dict = [
            'text' => [
                Schema::COLUMN_NAME => 'Текст',
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'customer' => [
                'id' => [
                    Schema::COLUMN_NAME => 'Customer ID',
                    Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                    Schema::COLUMN_REQUIRED => false
                ],
                'externalId' => [
                    Schema::COLUMN_NAME => 'Customer ExternalID',
                    Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                    Schema::COLUMN_REQUIRED => false
                ]
            ]
        ];
        return static::setAdditionalColumnFields($dict, Entities::NOTE);
    }
}
