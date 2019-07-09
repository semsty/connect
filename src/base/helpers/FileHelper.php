<?php

namespace connect\crm\base\helpers;

use connect\crm\base\exception\Exception;
use yii\helpers\FileHelper as BaseFileHelper;

class FileHelper extends BaseFileHelper
{
    public static function writeFile($path, $text, $flag = FILE_APPEND)
    {
        if (!is_array($path)) {
            $path = [$path];
        }
        foreach ($path as $item) {
            $item = \Yii::getAlias($item);
            static::fileCreate($item);
            file_put_contents($item, $text, $flag);
        }
    }

    /**
     * @param $path
     * @throws Exception
     */
    public static function fileCreate($path)
    {
        $path = \Yii::getAlias($path);
        $exploded = explode('/', $path);
        unset($exploded[count($exploded) - 1]);
        $dir = implode('/', $exploded);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!file_exists($path)) {
            $resource = fopen($path, 'w');
            if (!$resource) {
                throw new Exception("unable to create $path");
            }
        }
    }

    public static function getContent($path)
    {
        $path = \Yii::getAlias($path);
        if (file_exists($path)) {
            return file_get_contents($path);
        }
    }
}
