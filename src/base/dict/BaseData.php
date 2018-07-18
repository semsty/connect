<?php

namespace connect\crm\base\dict;

use connect\crm\base\helpers\ArrayHelper;

class BaseData extends Dictionary
{
    const DICT_NAME = 'data';

    const COUNT = 'count';
    const REVENUE = 'revenue';
    const UTM_SOURCE = 'utm_source';
    const UTM_MEDIUM = 'utm_medium';
    const UTM_CONTENT = 'utm_content';
    const UTM_CAMPAIGN = 'utm_campaign';
    const UTM_TERM = 'utm_term';
    const GA_CLIENT_ID = 'client_id';
    const PHONE_NUMBER = 'phone_number';
    const EMAIL = 'email';
    const NAME = 'name';
    const CONTACT_NAME = self::NAME;
    const ID = 'id';
    const PROFILE_ID = 'external_profile_id';
    const MARK = 'mark';
    const DATE_CREATE = 'date_create';
    const CLIENT_ID_DATE = 'client_id_date';

    const EMPTY_NOT_SET = '(not set)';
    const EMPTY_DASH = '-';
    const EMPTY_DASH_2 = '–';
    const EMPTY_LINE = '';
    const EMPTY_NONE = 'none';

    const CLIENT_ID_PATTERN = '/((GA1)[\.]{1}(?<subdomains>[\d]{1})[\.]{1}|^)(?<id>[\d]{4,}){1}[\.]{1}(?<timestamp>[\d]{4,}){1}$/';

    const GROUP_ID = 'group_id';
    const CAMPAIGN_ID = 'campaign_id';
    const AD_ID = 'ad_id';
    const KEYWORD_ID = 'keyword_id';
    const TARGET_TYPE = 'target_type';

    const ENTITY = 'entity';

    public static function dictAdwordsContextAttributes(): array
    {
        return [
            static::GROUP_ID,
            static::CAMPAIGN_ID,
            static::AD_ID,
            static::KEYWORD_ID,
            static::TARGET_TYPE
        ];
    }

    public static function dictEmptyValues(): array
    {
        return [
            static::EMPTY_NOT_SET,
            static::EMPTY_DASH,
            static::EMPTY_DASH_2,
            static::EMPTY_LINE,
            static::EMPTY_NONE
        ];
    }

    public static function dictAttributesMap(): array
    {
        return array_combine(Data::dictAttributesKeys(), static::dictAttributesKeys());
    }

    public static function dictAttributesKeys(): array
    {
        return ArrayHelper::merge(
            static::dictContextAttributes(),
            static::dictUserAttributes(),
            static::dictTransactionAttributes(),
            static::dictServiceAttributes()
        );
    }

    public static function dictContextAttributes(): array
    {
        return ArrayHelper::merge(static::dictUtmTags(), [
            static::GA_CLIENT_ID
        ]);
    }

    public static function dictUtmTags(): array
    {
        return [
            static::UTM_SOURCE,
            static::UTM_MEDIUM,
            static::UTM_CONTENT,
            static::UTM_CAMPAIGN,
            static::UTM_TERM
        ];
    }

    public static function dictUserAttributes(): array
    {
        return [
            static::PHONE_NUMBER,
            static::EMAIL,
            static::NAME
        ];
    }

    public static function dictTransactionAttributes(): array
    {
        return [
            static::COUNT,
            static::REVENUE
        ];
    }

    public static function dictServiceAttributes(): array
    {
        return [
            static::ID,
            static::PROFILE_ID
        ];
    }

    public static function dictStatAttributesMap(): array
    {
        return array_combine(Data::dictStatAttributes(), static::dictStatAttributes());
    }

    public static function dictStatAttributes(): array
    {
        return ArrayHelper::merge(
            static::dictContextAttributes(),
            static::dictTransactionAttributes(),
            [
                static::ID,
                static::DATE_CREATE
            ]
        );
    }
}
