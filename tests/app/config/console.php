<?php

return [
    'controllerMap' => [
        'pgsql-migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'db' => 'db',
            'migrationNamespaces' => [
                'connect\crm\base\db\migrations',
            ],
        ]
    ],
];
