<?php

namespace semsty\connect\bitrix24\dict;

use semsty\connect\base\dict\Dictionary;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\bitrix24\query\Schema;

class Fields extends Dictionary
{
    const DICT_NAME = 'fields';

    const FIELD_PHONE = 'PHONE';
    const FIELD_EMAIL = 'EMAIL';

    public static function dictDealRequiredFields()
    {
        return static::dictEntityFilteredFields(Entities::DEAL, 'isRequired');
    }

    public static function dictEntityFilteredFields($entity, $filter)
    {
        if (!is_callable($filter)) {
            $filter = function ($item) use ($filter) {
                return $item[$filter];
            };
        }
        return array_filter(call_user_func([static::className(), 'dict' . ucfirst($entity) . 'SystemFields']), $filter);
    }

    public static function dictDealReadOnlyFields()
    {
        return static::dictEntityFilteredFields(Entities::DEAL, 'isReadOnly');
    }

    public static function dictDealImmutableFields()
    {
        return static::dictEntityFilteredFields(Entities::DEAL, 'isImmutable');
    }

    public static function dictDealMultipleFields()
    {
        return static::dictEntityFilteredFields(Entities::DEAL, 'isMultiple');
    }

    public static function dictDealDynamicFields()
    {
        return static::dictEntityFilteredFields(Entities::DEAL, 'isDynamic');
    }

    public static function dictLeadRequiredFields()
    {
        return static::dictEntityFilteredFields(Entities::LEAD, 'isRequired');
    }

    public static function dictLeadReadOnlyFields()
    {
        return static::dictEntityFilteredFields(Entities::LEAD, 'isReadOnly');
    }

    public static function dictLeadImmutableFields()
    {
        return static::dictEntityFilteredFields(Entities::LEAD, 'isImmutable');
    }

    public static function dictLeadMultipleFields()
    {
        return static::dictEntityFilteredFields(Entities::LEAD, 'isMultiple');
    }

    public static function dictLeadDynamicFields()
    {
        return static::dictEntityFilteredFields(Entities::LEAD, 'isDynamic');
    }

    public static function dictContactRequiredFields()
    {
        return static::dictEntityFilteredFields(Entities::CONTACT, 'isRequired');
    }

    public static function dictContactReadOnlyFields()
    {
        return static::dictEntityFilteredFields(Entities::CONTACT, 'isReadOnly');
    }

    public static function dictContactImmutableFields()
    {
        return static::dictEntityFilteredFields(Entities::CONTACT, 'isImmutable');
    }

    public static function dictContactMultipleFields()
    {
        return static::dictEntityFilteredFields(Entities::CONTACT, 'isMultiple');
    }

    public static function dictContactDynamicFields()
    {
        return static::dictEntityFilteredFields(Entities::CONTACT, 'isDynamic');
    }

    public static function dictDealSystemFields()
    {
        return ArrayHelper::merge(static::dictCommonSystemFields(), [
            'TITLE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => true,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'TYPE_ID' => [
                Schema::COLUMN_TYPE => 'crm_status',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
                'statusType' => 'DEAL_TYPE'
            ],
            'CATEGORY_ID' => [
                Schema::COLUMN_TYPE => 'crm_category',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => true,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'STAGE_ID' => [
                Schema::COLUMN_TYPE => 'crm_status',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
                'statusType' => 'DEAL_STAGE'
            ],
            'STAGE_SEMANTIC_ID' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'IS_NEW' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'IS_RECURRING' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'PROBABILITY' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'CURRENCY_ID' => [
                Schema::COLUMN_TYPE => 'crm_currency',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'OPPORTUNITY' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DOUBLE,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'TAX_VALUE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DOUBLE,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'CONTACT_ID' => [
                Schema::COLUMN_TYPE => 'crm_contact',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
                'isDeprecated' => true
            ],
            'CONTACT_IDS' => [
                Schema::COLUMN_TYPE => 'crm_contact',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false
            ],
            'QUOTE_ID' => [
                Schema::COLUMN_TYPE => 'crm_quote',
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'BEGINDATE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DATE,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'CLOSEDATE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DATE,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'CLOSED' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'LEAD_ID' => [
                Schema::COLUMN_TYPE => 'crm_lead',
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'ADDITIONAL_INFO' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'LOCATION_ID' => [
                Schema::COLUMN_TYPE => 'location',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ]
        ]);
    }

    public static function dictCommonSystemFields()
    {
        return [
            'ID' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'DATE_CREATE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DATETIME,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'DATE_MODIFY' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DATETIME,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'MODIFY_BY_ID' => [
                Schema::COLUMN_TYPE => 'user',
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false
            ],
            'UTM_SOURCE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'UTM_MEDIUM' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'UTM_CAMPAIGN' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'UTM_CONTENT' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'UTM_TERM' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'COMPANY_ID' => [
                Schema::COLUMN_TYPE => 'crm_company',
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'OPENED' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'COMMENTS' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ASSIGNED_BY_ID' => [
                Schema::COLUMN_TYPE => 'user',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'CREATED_BY_ID' => [
                Schema::COLUMN_TYPE => 'user',
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ORIGINATOR_ID' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ORIGIN_ID' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ]
        ];
    }

    public static function dictLeadSystemFields()
    {
        return ArrayHelper::merge(static::dictCommonSystemFields(), [
            'TITLE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => true,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'HONORIFIC' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'NAME' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'SECOND_NAME' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'LAST_NAME' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'BIRTHDATE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DATE,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'COMPANY_TITLE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'SOURCE_ID' => [
                Schema::COLUMN_TYPE => 'crm_status',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
                'statusType' => 'SOURCE',
            ],
            'SOURCE_DESCRIPTION' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'STATUS_ID' => [
                Schema::COLUMN_TYPE => 'crm_status',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
                'statusType' => 'STATUS',
            ],
            'STATUS_DESCRIPTION' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'STATUS_SEMANTIC_ID' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'POST' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_2' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_CITY' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_POSTAL_CODE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_REGION' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_PROVINCE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_COUNTRY' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_COUNTRY_CODE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'CURRENCY_ID' => [
                Schema::COLUMN_TYPE => 'crm_currency',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'OPPORTUNITY' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DOUBLE,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'HAS_PHONE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'HAS_EMAIL' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'HAS_IMOL' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'COMPANY_ID' => [
                'isReadOnly' => true,
            ],
            'CONTACT_ID' => [
                Schema::COLUMN_TYPE => 'crm_contact',
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'IS_RETURN_CUSTOMER' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'DATE_CLOSED' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DATETIME,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'PHONE' => [
                Schema::COLUMN_TYPE => 'crm_multifield',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ],
            'EMAIL' => [
                Schema::COLUMN_TYPE => 'crm_multifield',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ],
            'WEB' => [
                Schema::COLUMN_TYPE => 'crm_multifield',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ],
            'IM' => [
                Schema::COLUMN_TYPE => 'crm_multifield',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ]
        ]);
    }

    public static function dictContactSystemFields()
    {
        return ArrayHelper::merge(static::dictCommonSystemFields(), [
            'HONORIFIC' => [
                Schema::COLUMN_TYPE => 'crm_status',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
                'statusType' => 'HONORIFIC',
            ],
            'NAME' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => true,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'SECOND_NAME' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => true,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'LAST_NAME' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => true,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'PHOTO' => [
                Schema::COLUMN_TYPE => 'file',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'BIRTHDATE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_DATE,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'TYPE_ID' => [
                Schema::COLUMN_TYPE => 'crm_status',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
                'statusType' => 'CONTACT_TYPE',
            ],
            'SOURCE_ID' => [
                Schema::COLUMN_TYPE => 'crm_status',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
                'statusType' => 'SOURCE',
            ],
            'SOURCE_DESCRIPTION' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'POST' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_2' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_CITY' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_POSTAL_CODE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_REGION' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_PROVINCE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_COUNTRY' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ADDRESS_COUNTRY_CODE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'EXPORT' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'HAS_PHONE' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'HAS_EMAIL' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'HAS_IMOL' => [
                Schema::COLUMN_TYPE => Schema::TYPE_CHAR,
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'COMPANY_ID' => [
                'isDeprecated' => true,
            ],
            'COMPANY_IDS' => [
                Schema::COLUMN_TYPE => 'crm_company',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ],
            'LEAD_ID' => [
                Schema::COLUMN_TYPE => 'crm_lead',
                'isRequired' => false,
                'isReadOnly' => true,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'ORIGIN_VERSION' => [
                Schema::COLUMN_TYPE => Schema::TYPE_STRING,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'FACE_ID' => [
                Schema::COLUMN_TYPE => Schema::TYPE_INTEGER,
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => false,
                'isDynamic' => false,
            ],
            'PHONE' => [
                Schema::COLUMN_TYPE => 'crm_multifield',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ],
            'EMAIL' => [
                Schema::COLUMN_TYPE => 'crm_multifield',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ],
            'WEB' => [
                Schema::COLUMN_TYPE => 'crm_multifield',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ],
            'IM' => [
                Schema::COLUMN_TYPE => 'crm_multifield',
                'isRequired' => false,
                'isReadOnly' => false,
                'isImmutable' => false,
                'isMultiple' => true,
                'isDynamic' => false,
            ]
        ]);
    }
}
