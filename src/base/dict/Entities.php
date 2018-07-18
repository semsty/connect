<?php

namespace connect\crm\base\dict;

use connect\crm\base\helpers\ArrayHelper;

class Entities extends Dictionary
{
    const DICT_NAME = 'entities';

    const ENTITY = 'entity';
    const CONTACT = 'contact';
    const LEAD = 'lead';
    const DEAL = 'deal';
    const NOTE = 'note';
    const COMPANY = 'company';
    const TASK = 'task';
    const CALL = 'call';
    const WEBHOOK = 'webhook';
    const CUSTOM_FIELD = 'custom_field';
    const ORDER = 'order';

    const COMPANY_PLURALIZE = 'companies';

    const TRANSACTION = 'transaction';

    public static function getEntityTypePluralize($entity_type)
    {
        return ArrayHelper::getValue(static::dictEntityTypesPluralize(), $entity_type);
    }

    public static function dictEntityTypesPluralize()
    {
        $types = static::dictEntityTypes();
        foreach ($types as $entity_type => $entity_name) {
            $pluralize = '' . str_replace('-', '_', strtoupper($entity_type)) . '_PLURALIZE';
            if (defined("static::$pluralize")) {
                $types[$entity_type] = constant("static::$pluralize");
            } else {
                $types[$entity_type] = $entity_type . 's';
            }
        }
        return $types;
    }

    public static function dictEntityTypes()
    {
        return [
            static::CONTACT => 'contact',
            static::LEAD => 'lead',
            static::DEAL => 'deal',
            static::NOTE => 'note',
            static::COMPANY => 'company',
            static::TASK => 'task',
            static::CALL => 'call',
            static::CUSTOM_FIELD => 'custom-field',
            static::ORDER => 'order'
        ];
    }

    public static function dictEntityTypesIds()
    {
        return [1, 2, 3, 4, 5, 6, 7];
    }
}
