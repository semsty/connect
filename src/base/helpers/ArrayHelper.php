<?php

namespace semsty\connect\base\helpers;

use semsty\connect\base\Settings;
use yii\helpers\ArrayHelper as BaseArrayHelper;
use yii\helpers\ReplaceArrayValue;
use yii\helpers\UnsetArrayValue;

class ArrayHelper extends BaseArrayHelper
{
    const PATH_WILDCARD = Settings::PATH_WILDCARD;
    const PATH_DELIMITER = Settings::PATH_DELIMITER;

    public static function umerge($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if ($v instanceof UnsetArrayValue) {
                    unset($res[$k]);
                } elseif ($v instanceof ReplaceArrayValue) {
                    $res[$k] = $v->value;
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = self::umerge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }

        return $res;
    }

    public static function diffRecursive($a, $b)
    {
        $r = [];
        foreach ($a as $k => $v) {
            if (array_key_exists($k, $b)) {
                if (is_array($v)) {
                    $diff = static::diffRecursive($v, $b[$k]);
                    if (count($diff)) {
                        $r[$k] = $diff;
                    }
                } else {
                    if ($v != $b[$k]) {
                        $r[$k] = $v;
                    }
                }
            } else {
                $r[$k] = $v;
            }
        }
        return $r;
    }

    public static function parsePath($path)
    {
        return explode(static::PATH_DELIMITER, $path);
    }

    public static function implodeKeysRecursive(array $array, &$result = [], $path = '', $associative = true): array
    {
        foreach ($array as $k => $v) {
            if (is_array($v) && ($associative ? static::isAssociative($v) : true)) {
                static::implodeKeysRecursive($v, $result, $path . $k . static::PATH_DELIMITER, $associative);
                continue;
            }
            $result[$path . $k] = $v;
        }
        return $result;
    }

    public static function explodeKeysRecursive(array $array): array
    {
        $result = [];
        foreach ($array as $k => $v) {
            static::setValue($result, $k, $v);
        }
        return $result;
    }
}
