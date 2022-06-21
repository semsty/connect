<?php

namespace connect\crm\base\data;

use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class Filter extends BaseObject
{
    const CONDITION_AND = 'and';
    const CONDITION_OR = 'or';

    const NEGATION_PREFIX = 'not-';
    const NEGATION_PREFIX_SHORT = '!';

    const FILTER_EQUAL = '=';
    const FILTER_NOT_EQUAL = self::NEGATION_PREFIX_SHORT . '=';
    const FILTER_MORE = '>';
    const FILTER_LESS = '<';
    const FILTER_MORE_OR_EQUAL = '>=';
    const FILTER_LESS_OR_EQUAL = '<=';
    const FILTER_IN = 'in';
    const FILTER_NOT_IN = self::NEGATION_PREFIX_SHORT . 'in';
    const FILTER_EMPTY = 'empty';
    const FILTER_NOT_EMPTY = self::NEGATION_PREFIX_SHORT . 'empty';
    const FILTER_CONTAIN = 'contain';
    const FILTER_NOT_CONTAIN = self::NEGATION_PREFIX_SHORT . 'contain';
    const FILTER_PARTIALLY_CONTAIN = 'partially-contain';
    const FILTER_STRPOS = 'strpos';
    const FILTER_NOT_STRPOS = self::NEGATION_PREFIX_SHORT . 'strpos';
    const FILTER_STRIPOS = 'stripos';
    const FILTER_NOT_STRIPOS = self::NEGATION_PREFIX_SHORT . 'stripos';
    const FILTER_STARTS_WITH = 'starts-with';
    const FILTER_NOT_STARTS_WITH = self::NEGATION_PREFIX_SHORT . 'starts-with';
    const FILTER_ENDS_WITH = 'ends-with';
    const FILTER_NOT_ENDS_WITH = self::NEGATION_PREFIX_SHORT . 'ends-with';

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
            static::FILTER_PARTIALLY_CONTAIN,
            static::FILTER_STRPOS,
            static::FILTER_NOT_STRPOS,
            static::FILTER_STRIPOS,
            static::FILTER_NOT_STRIPOS,
            static::FILTER_STARTS_WITH,
            static::FILTER_NOT_STARTS_WITH,
            static::FILTER_ENDS_WITH,
            static::FILTER_NOT_ENDS_WITH
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
    public static function filter($data, $filter, $mode = self::CONDITION_AND, $i = 1): bool
    {
        $result = [];
        foreach ($filter as $attribute => $attribute_filters) {
            if (!static::isFilterControl($attribute) && is_array($attribute_filters) && !ArrayHelper::isAssociative($filter)) {
                $result[] = static::filter($data, $attribute_filters, $mode, $i + 1);
            } else {
                if (ArrayHelper::isIn($attribute, static::getConditions())) {
                    $result[] = static::filter($data, $attribute_filters, $attribute, $i + 1);
                } else {
                    if (is_array($attribute_filters)) {
                        if (ArrayHelper::isAssociative($attribute_filters)) {
                            $attribute_filters = [$attribute_filters];
                        }
                        foreach ($attribute_filters as $middle_key => $attribute_filter) {
                            foreach ($attribute_filter as $filter_key => $filter_value) {
                                if (ArrayHelper::isIn($filter_key, static::getConditions())) {
                                    $result[] = static::filter($data, $filter_value, $filter_key, $i + 1);
                                } else {
                                    $result[] = static::checkFilter(
                                        ArrayHelper::getValue($data, $attribute),
                                        $filter_key,
                                        static::getExpectedValue($data, $filter_value)
                                    );
                                }
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
                return in_array($expected, $value ?? []);
            case static::FILTER_NOT_CONTAIN:
                return !in_array($expected, $value ?? []);
            case static::FILTER_PARTIALLY_CONTAIN:
                return !empty(array_intersect([$expected], $value ?? []));
            case static::FILTER_EMPTY:
                return empty($value);
            case static::FILTER_NOT_EMPTY:
                return !empty($value);
            case static::FILTER_STRPOS:
                return mb_strpos($value, $expected) !== false;
            case static::FILTER_NOT_STRPOS:
                return mb_strpos($value, $expected) === false;
            case static::FILTER_STRIPOS:
                return mb_stripos($value, $expected) !== false;
            case static::FILTER_NOT_STRIPOS:
                return mb_stripos($value, $expected) === false;
            case static::FILTER_STARTS_WITH:
                return mb_stripos($value, $expected) === 0;
            case static::FILTER_NOT_STARTS_WITH:
                return mb_stripos($value, $expected) !== 0;
            case static::FILTER_ENDS_WITH:
                return mb_strtolower(mb_substr($value, mb_strlen($value) - mb_strlen($expected))) == mb_strtolower($expected);
            case static::FILTER_NOT_ENDS_WITH:
                return mb_strtolower(mb_substr($value, mb_strlen($value) - mb_strlen($expected))) != mb_strtolower($expected);
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

    public static function isFilterControl(string $operator): bool
    {
        $short_filters = static::getFilters();
        foreach ($short_filters as $short_filter) {
            $filters[] = str_replace(static::NEGATION_PREFIX_SHORT, static::NEGATION_PREFIX, $short_filter);
        }
        return ArrayHelper::isIn($operator, ArrayHelper::merge(static::getFilterControls(), $filters, $short_filters));
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
            static::NEGATION_PREFIX . 'eq' => static::FILTER_NOT_EQUAL,
            static::NEGATION_PREFIX . 'equal' => static::FILTER_NOT_EQUAL,
            'in' => static::FILTER_IN,
            'nin' => static::FILTER_NOT_IN,
            static::NEGATION_PREFIX . 'in' => static::FILTER_NOT_IN,
            static::NEGATION_PREFIX . 'empty' => static::FILTER_NOT_EMPTY,
            'strpos' => static::FILTER_STRPOS,
            static::NEGATION_PREFIX . 'strpos' => static::FILTER_NOT_STRPOS,
            'stripos' => static::FILTER_STRIPOS,
            static::NEGATION_PREFIX . 'stripos' => static::FILTER_NOT_STRIPOS,
            'starts-with' => static::FILTER_STARTS_WITH,
            static::NEGATION_PREFIX . 'starts-with' => static::FILTER_NOT_STARTS_WITH,
            'ends-with' => static::FILTER_ENDS_WITH,
            static::NEGATION_PREFIX . 'ends-with' => static::FILTER_NOT_ENDS_WITH
        ];
    }

    public static function getExpectedValue($data, $value)
    {
        if (is_string($value) && (strpos($value, static::INTERNAL_CHECK_MARK) !== false)) {
            $value = ArrayHelper::getValue($data, str_replace(static::INTERNAL_CHECK_MARK, '', $value));
        }
        return $value;
    }

    /**
     * @param array $filter
     * @return array inverted filter
     */
    public static function inverse(array $filter): array
    {
        $inverse = [];
        foreach ($filter as $attribute => $attribute_filters) {
            if (ArrayHelper::isIn($attribute, static::getConditions())) {
                $mode = $attribute == static::CONDITION_AND ? static::CONDITION_OR : static::CONDITION_AND;
                $inverse[$mode] = ArrayHelper::merge($inverse[$mode], static::inverse($attribute_filters));
            } else {
                if (is_array($attribute_filters)) {
                    foreach ($attribute_filters as $filter => $value) {
                        if (strpos($filter, static::NEGATION_PREFIX) === false && strpos($filter, static::NEGATION_PREFIX_SHORT) === false) {
                            $inverted = static::NEGATION_PREFIX . $filter;
                        } else {
                            $inverted = str_replace([static::NEGATION_PREFIX_SHORT, static::NEGATION_PREFIX], '', $filter);
                        }
                        $inverse[static::CONDITION_OR][$attribute][$inverted] = $value;
                    }
                } else {
                    /**
                     * default filter case
                     */
                    $inverse[static::CONDITION_OR][$attribute][static::FILTER_NOT_EQUAL] = $attribute_filters;

                }
            }
        }
        return $inverse;
    }
}
