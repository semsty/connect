<?php

namespace semsty\connect\amocrm\dict;

use semsty\connect\amocrm\query\Schema;
use semsty\connect\base\dict\Dictionary;
use semsty\connect\base\helpers\ArrayHelper;

class Fields extends Dictionary
{
    const DICT_NAME = 'fields';

    public static function dictLeadSystemFields()
    {
        return ArrayHelper::merge(static::dictCommonSystemFields(), [
            'name' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => true
            ],
            'status_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ],
            'pipeline_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ],
            'sale' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ],
            'contacts_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'company_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ],
            'tags' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ]
        ]);
    }

    public static function dictCommonSystemFields()
    {
        return [
            'created_at' => [
                Schema::COLUMN_TYPE => Schema::TYPE_TIMESTAMP,
                Schema::COLUMN_REQUIRED => false
            ],
            'updated_at' => [
                Schema::COLUMN_TYPE => Schema::TYPE_TIMESTAMP,
                Schema::COLUMN_REQUIRED => false
            ],
            'responsible_user_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ]
        ];
    }

    public static function dictCompanySystemFields()
    {
        return static::dictContactSystemFields();
    }

    public static function dictContactSystemFields()
    {
        return ArrayHelper::merge(static::dictCommonSystemFields(), [
            'name' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => true
            ],
            'company_name' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'leads_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'customers_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'tags' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'company_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                Schema::COLUMN_REQUIRED => false
            ],
            'created_by' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ]
        ]);
    }

    public static function dictTaskSystemFields()
    {
        return ArrayHelper::merge(static::dictCommonSubEntitySystemFields(), [
            'task_type' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => true,
                Schema::COLUMN_ENUMERATION => Types::dictTaskTypes()
            ],
            'complete_till_at' => [
                Schema::COLUMN_TYPE => Schema::TYPE_TIMESTAMP,
                Schema::COLUMN_REQUIRED => false
            ],
            'is_completed' => [
                Schema::COLUMN_TYPE => Schema::TYPE_BOOLEAN,
                Schema::COLUMN_REQUIRED => false
            ],
            'created_by' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => false
            ]
        ]);
    }

    public static function dictCommonSubEntitySystemFields()
    {
        return ArrayHelper::merge(static::dictCommonSystemFields(), [
            'element_id' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => true
            ],
            'element_type' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => true,
                Schema::COLUMN_ENUMERATION => Types::dictNoteEntityTypes()
            ],
            'text' => [
                Schema::COLUMN_TYPE => Schema::TYPE_TEXT,
                Schema::COLUMN_REQUIRED => true
            ]
        ]);
    }

    public static function dictNoteSystemFields()
    {
        return ArrayHelper::merge(static::dictCommonSubEntitySystemFields(), [
            'note_type' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                Schema::COLUMN_REQUIRED => true,
                Schema::COLUMN_ENUMERATION => Types::dictNoteTypes()
            ],
            'params' => [
                Schema::COLUMN_TYPE => Schema::TYPE_ARRAY,
                Schema::COLUMN_REQUIRED => false
            ]
        ]);
    }
}
