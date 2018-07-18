<?php

define('YII_DEBUG', true);
$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@semsty/connect', dirname(__DIR__) . '/src');
Yii::setAlias('@tests', __DIR__);
Yii::setAlias('@connect_log', '@tests/app/runtime/log');

$config = require(__DIR__ . '/app/config/main.php');
$app = new \yii\console\Application($config);
