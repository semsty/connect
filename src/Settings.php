<?php

namespace semsty\connect;

use semsty\connect\amocrm\Service as AmoCRM;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\bitrix24\Service as Bitrix24;
use semsty\connect\custom\Service as Custom;
use yii\base\BaseObject;

class Settings extends BaseObject
{
    const PATH_WILDCARD = '*';
    const PATH_DELIMITER = '.';
    const LOG_BASE_PATH = '@connect_log';

    public static function getServicesNames(): array
    {
        $result = [];
        foreach (static::getServices() as $id => $class) {
            $result[$class::NAME] = $class;
        }
        return $result;
    }

    public static function getServices($with_id = true): array
    {
        $services = [
            Custom::class,
            AmoCRM::class,
            Bitrix24::class
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

    public static function getAction($name, $merge = false, $collapse = false)
    {
        if (is_numeric($name)) {
            foreach (static::getActions($merge, $collapse) as $key => $action) {
                if ($action::ID == $name) {
                    return $action::className();
                }
            }
        } else {
            return ArrayHelper::getValue(static::getActions($merge, $collapse), $name);
        }
    }

    public static function getActions($merge = false, $collapse = false)
    {
        $result = [];
        foreach (static::getServices() as $service) {
            if ($actions = $service::getActions($merge, $collapse)) {
                $result[$service::NAME] = $actions;
            }
        }
        if ($collapse) {
            $result = ArrayHelper::implodeKeysRecursive($result);
        }
        return $result;
    }

}
