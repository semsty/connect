<?php

namespace connect\crm\amocrm\dict;

use connect\crm\base\dict\Dictionary;

class Types extends Dictionary
{
    const DICT_NAME = 'types';

    const ELEMENT_TYPE_CONTACT = 1;
    const ELEMENT_TYPE_LEAD = 2;
    const ELEMENT_TYPE_COMPANY = 3;
    const ELEMENT_TYPE_TASK = 4;
    const ELEMENT_TYPE_CUSTOMER = 12;

    const FIELD_TYPE_TEXT = 1;
    const FIELD_TYPE_NUMERIC = 2;
    const FIELD_TYPE_CHECKBOX = 3;
    const FIELD_TYPE_SELECT = 4;
    const FIELD_TYPE_MULTISELECT = 5;
    const FIELD_TYPE_DATE = 6;
    const FIELD_TYPE_URL = 7;
    const FIELD_TYPE_MULTITEXT = 8;
    const FIELD_TYPE_TEXTAREA = 9;
    const FIELD_TYPE_RADIOBUTTON = 10;
    const FIELD_TYPE_STREETADDRESS = 11;
    const FIELD_TYPE_SMART_ADDRESS = 13;
    const FIELD_TYPE_BIRTHDAY = 14;

    const CALL_TYPE_INBOUND = 'inbound';
    const CALL_TYPE_OUTBOUND = 'outbound';

    const EVENT_TYPE_LEAD_STATUS_CHANGES = 'lead_status_changed';

    const NOTE_TYPE_DEAL_CREATED = 1;
    const NOTE_TYPE_CONTACT_CREATED = 2;
    const NOTE_TYPE_DEAL_STATUS_CHANGED = 3;
    const NOTE_TYPE_COMMON = 4;
    const NOTE_TYPE_CALL_IN = 10;
    const NOTE_TYPE_CALL_OUT = 11;
    const NOTE_TYPE_COMPANY_CREATED = 12;
    const NOTE_TYPE_TASK_RESULT = 13;
    const NOTE_TYPE_SYSTEM = 25;
    const NOTE_TYPE_SMS_IN = 102;
    const NOTE_TYPE_SMS_OUT = 103;

    const TASK_TYPE_CALL = 1;
    const TASK_TYPE_MEETING = 2;
    const TASK_TYPE_WRITE_MAIL = 3;

    const SYSTEM_STATUS_SUCCESS = 142;
    const SYSTEM_STATUS_CLOSED = 143;

    public static function dictElementTypes()
    {
        return [
            static::ELEMENT_TYPE_CONTACT => 'contact',
            static::ELEMENT_TYPE_LEAD => 'lead',
            static::ELEMENT_TYPE_COMPANY => 'company',
            static::ELEMENT_TYPE_TASK => 'task',
            static::ELEMENT_TYPE_CUSTOMER => 'customer'
        ];
    }

    public static function dictFieldTypes()
    {
        return [
            static::FIELD_TYPE_TEXT => 'text',
            static::FIELD_TYPE_NUMERIC => 'numeric',
            static::FIELD_TYPE_CHECKBOX => 'checkbox',
            static::FIELD_TYPE_SELECT => 'select',
            static::FIELD_TYPE_MULTISELECT => 'multiselect',
            static::FIELD_TYPE_DATE => 'date',
            static::FIELD_TYPE_URL => 'url',
            static::FIELD_TYPE_MULTITEXT => 'multifield',
            static::FIELD_TYPE_TEXTAREA => 'textarea',
            static::FIELD_TYPE_RADIOBUTTON => 'radiobutton',
            static::FIELD_TYPE_STREETADDRESS => 'streetaddress',
            static::FIELD_TYPE_SMART_ADDRESS => 'smart-address',
            static::FIELD_TYPE_BIRTHDAY => 'birthday'
        ];
    }

    public static function dictCallTypes()
    {
        return [
            static::CALL_TYPE_INBOUND => 'inbound',
            static::CALL_TYPE_OUTBOUND => 'outbound'
        ];
    }

    public static function dictCustomFieldEntityTypes()
    {
        return [
            static::ELEMENT_TYPE_CONTACT => 'contact',
            static::ELEMENT_TYPE_LEAD => 'lead',
            static::ELEMENT_TYPE_COMPANY => 'company',
            static::ELEMENT_TYPE_CUSTOMER => 'customer'
        ];
    }

    public static function dictTaskEntityTypes()
    {
        return static::dictNoteEntityTypes();
    }

    public static function dictNoteEntityTypes()
    {
        return [
            static::ELEMENT_TYPE_CONTACT => 'contact',
            static::ELEMENT_TYPE_LEAD => 'lead',
            static::ELEMENT_TYPE_COMPANY => 'company',
            static::ELEMENT_TYPE_TASK => 'task'
        ];
    }

    public static function dictNoteTypes()
    {
        return [
            static::NOTE_TYPE_DEAL_CREATED => 'deal-created',
            static::NOTE_TYPE_CONTACT_CREATED => 'contact-created',
            static::NOTE_TYPE_DEAL_STATUS_CHANGED => 'deal-status-changed',
            static::NOTE_TYPE_COMMON => 'common',
            static::NOTE_TYPE_CALL_IN => 'call-in',
            static::NOTE_TYPE_CALL_OUT => 'call-out',
            static::NOTE_TYPE_COMPANY_CREATED => 'company-created',
            static::NOTE_TYPE_TASK_RESULT => 'task-result',
            static::NOTE_TYPE_SYSTEM => 'system',
            static::NOTE_TYPE_SMS_IN => 'sms-in',
            static::NOTE_TYPE_SMS_OUT => 'sms-out'
        ];
    }

    public static function dictTaskTypes()
    {
        return [
            static::TASK_TYPE_CALL => 'call',
            static::TASK_TYPE_MEETING => 'meeting',
            static::TASK_TYPE_WRITE_MAIL => 'write-mail',
        ];
    }

    public static function dictSystemStatuses()
    {
        return [
            static::SYSTEM_STATUS_SUCCESS,
            static::SYSTEM_STATUS_CLOSED
        ];
    }
}
