<?php

namespace semsty\connect\retailcrm\dict;

use semsty\connect\base\dict\Data as BaseData;

class Data extends BaseData
{
    const REVENUE = 'totalSumm';
    const UTM_SOURCE = 'source.source';
    const UTM_MEDIUM = 'source.medium';
    const UTM_CONTENT = 'source.content';
    const UTM_CAMPAIGN = 'source.campaign';
    const UTM_TERM = 'source.term';
    const GA_CLIENT_ID = 'clientId';
    const DATE_CREATE = 'createdAt';
    const STATUS = 'status';

    const EAV_ATTRIBUTES_KEY = 'customFields';
}