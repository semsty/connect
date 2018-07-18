<?php

namespace connect\crm\bitrix24\dict;

use connect\crm\base\dict\Data as BaseData;

class Data extends BaseData
{
    const ID = 'ID';
    const PHONE_NUMBER = 'PHONE.0.VALUE';
    const REVENUE = 'OPPORTUNITY';
    const UTM_SOURCE = 'UTM_SOURCE';
    const UTM_MEDIUM = 'UTM_MEDIUM';
    const UTM_CAMPAIGN = 'UTM_CAMPAIGN';
    const UTM_CONTENT = 'UTM_CONTENT';
    const UTM_TERM = 'UTM_TERM';
    const GA_CLIENT_ID = 'CLIENT_ID';
    const DATE_CREATE = 'DATE_CREATE';

    const USER_FIELD_PREFIX = 'UF_CRM_';
}
