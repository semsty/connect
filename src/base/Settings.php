<?php

namespace semsty\connect\base;

use semsty\connect\amocrm\Service as AmoCRM;
use semsty\connect\custom\Service as Custom;
use yii\base\BaseObject;

class Settings extends BaseObject
{
    const PATH_WILDCARD = '*';
    const PATH_DELIMITER = '.';
    const LOG_BASE_PATH = '@connect_log';

    public static function getServices($with_id = true): array
    {
        $services = [
            Custom::class,
            AmoCRM::class
        ];
        if ($with_id) {
            $result = [];
            foreach ($services as $no => $class) {
                $result[$class::SERVICE_ID] = $class;
            }
        } else {
            $result = $services;
        }
        return $result;
    }
}
