<?php

namespace semsty\connect\base\data;

class ContextData extends BaseData
{
    const COUNT = 'count';
    const REVENUE = 'revenue';
    const UTM_SOURCE = 'utm_source';
    const UTM_MEDIUM = 'utm_medium';
    const UTM_CONTENT = 'utm_content';
    const UTM_CAMPAIGN = 'utm_campaign';
    const UTM_TERM = 'utm_term';
    const GA_CLIENT_ID = 'client_id';

    public static function utmTags(): array
    {
        return [
            static::UTM_SOURCE,
            static::UTM_MEDIUM,
            static::UTM_CONTENT,
            static::UTM_CAMPAIGN,
            static::UTM_TERM
        ];
    }
}
