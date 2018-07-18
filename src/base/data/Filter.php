<?php

namespace connect\crm\base\data;

use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class Filter extends BaseObject
{
    const CONDITION_AND = 'and';
    const CONDITION_OR = 'or';

    const FILTER_EQUAL = '=';
    const FILTER_NOT_EQUAL = '!=';
    const FILTER_MORE = '>';
    const FILTER_LESS = '<';
    const FILTER_MORE_OR_EQUAL = '>=';
    const FILTER_LESS_OR_EQUAL = '<=';
    const FILTER_IN = 'in';
    const FILTER_NOT_IN = '!in';
    const FILTER_EMPTY = 'empty';
    const FILTER_NOT_EMPTY = '!empty';
    const FILTER_CONTAIN = 'contain';
    const FILTER_NOT_CONTAIN = '!contain';
    const FILTER_PARTIALLY_CONTAIN = 'partially-contain';

    const INTERNAL_CHECK_MARK = 'internal:';

    public static function getFilterNames()
    {
        return array_combine(static::getFilters(), static::getFilters());
    }

    public static function getFilters()
    {
        return [
            static::FILTER_EQUAL,
            static::FILTER_NOT_EQUAL,
            static::FILTER_MORE,
            static::FILTER_MORE_OR_EQUAL,
            static::FILTER_LESS,
            static::FILTER_LESS_OR_EQUAL,
            static::FILTER_IN,
            static::FILTER_NOT_IN,
            static::FILTER_EMPTY,
            static::FILTER_NOT_EMPTY,
            static::FILTER_CONTAIN,
            static::FILTER_NOT_CONTAIN,
            static::FILTER_PARTIALLY_CONTAIN
        ];
    }

    /**
     * @param $data
     * @param $filter
     * @param $mode
     * @return bool
     * Filter example:
     * [
     *     "or" => [
     *         [
     *             "and" => [
     *                 [
     *                     "name" => "some name",
     *                 ],
     *                 [
     *                     "price" => "25",
     *                 ]
     *             ]
     *         ],
     *         [
     *             "id" => ["in" => [2, 5, 9]],
     *             "price" => [
     *                 ">" => 10,
     *                 "<" => 50
     *             ]
     *         ]
     *     ]
     * ]
     */
    public static function filter($data, $filter, $mode = self::CONDITION_AND): bool
    {
        $result = [];
        foreach ($filter as $attribute => $attribute_filters) {
            if (ArrayHelper::isIn($attribute, static::getConditions())) {
                $result[] = static::filter($data, $attribute_filters, $attribute);
            } else {
                if (is_array($attribute_filters)) {
                    if (ArrayHelper::isAssociative($attribute_filters)) {
                        $attribute_filters = [$attribute_filters];
                    }
                    foreach ($attribute_filters as $attribute_filter) {
                        foreach ($attribute_filter as $filter_key => $filter_value) {
                            $result[] = static::checkFilter(
                                ArrayHelper::getValue($data, $attribute),
                                $filter_key,
                                static::getExpectedValue($data, $filter_value)
                            );
                        }
                    }
                } else {
                    $result[] = static::checkFilter(
                        ArrayHelper::getValue($data, $attribute),
                        static::FILTER_EQUAL,
                        static::getExpectedValue($data, $attribute_filters)
                    );
                }
            }
        }
        switch ($mode) {
            case static::CONDITION_OR:
                return ArrayHelper::isIn(true, $result);
            case static::CONDITION_AND:
                return !ArrayHelper::isIn(false, $result);
        }
    }

    public static function getConditions()
    {
        return [static::CONDITION_AND, static::CONDITION_OR];
    }

    public static function checkFilter($value, $filter, $expected)
    {
        switch (static::normalizeFilter($filter)) {
            case static::FILTER_EQUAL:
                return $value == $expected;
            case static::FILTER_NOT_EQUAL:
                return $value != $expected;
            case static::FILTER_MORE:
                return $value > $expected;
            case static::FILTER_MORE_OR_EQUAL:
                return $value >= $expected;
            case static::FILTER_LESS:
                return $value < $expected;
            case static::FILTER_LESS_OR_EQUAL:
                return $value <= $expected;
            case static::FILTER_IN:
                return in_array($value, $expected);
            case static::FILTER_NOT_IN:
                return !in_array($value, $expected);
            case static::FILTER_CONTAIN:
                return in_array($expected, $value);
            case static::FILTER_NOT_CONTAIN:
                return !in_array($expected, $value);
            case static::FILTER_PARTIALLY_CONTAIN:
                return !empty(array_intersect([$expected], $value));
            case static::FILTER_EMPTY:
                return empty($value);
            case static::FILTER_NOT_EMPTY:
                return !empty($value);
        }
    }

    public static function normalizeFilter($filter)
    {
        $filter = str_replace(['_', ' '], ['-', '-'], strtolower($filter));
        if ($normalized = ArrayHelper::getValue(static::getFilterControls(), $filter)) {
            $filter = $normalized;
        }
        return $filter;
    }

    public static function getFilterControls()
    {
        return [
            'lt' => static::FILTER_LESS,
            'less' => static::FILTER_LESS,
            'gt' => static::FILTER_MORE,
            'greater' => static::FILTER_MORE,
            'lte' => static::FILTER_LESS_OR_EQUAL,
            'gte' => static::FILTER_MORE_OR_EQUAL,
            'eq' => static::FILTER_EQUAL,
            'equal' => static::FILTER_EQUAL,
            'neq' => static::FILTER_NOT_EQUAL,
            'not-equal' => static::FILTER_NOT_EQUAL,
            'in' => static::FILTER_IN,
            'nin' => static::FILTER_NOT_IN,
            'not-in' => static::FILTER_NOT_IN,
            'not-empty' => static::FILTER_NOT_EMPTY
        ];
    }

    public static function getExpectedValue($data, $value)
    {
        if (is_string($value) && (strpos($value, static::INTERNAL_CHECK_MARK) !== false)) {
            $value = ArrayHelper::getValue($data, str_replace(static::INTERNAL_CHECK_MARK, '', $value));
        }
        return $value;
    }
}
