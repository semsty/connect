<?php
$config = [
    'id' => 'connecr-app',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                getenv('POSTGRES_HOST') ?: 'localhost',
                getenv('POSTGRES_PORT') ?: 5432,
                getenv('POSTGRES_DB') ?: 'app_db'
            ),
            'username' => getenv('POSTGRES_USER'),
            'password' => getenv('POSTGRES_PASSWORD'),
            'charset' => 'utf8'
        ],
        'connect' => [
            'class' => \connect\crm\Connect::class
        ]
    ],
];

return $config;
