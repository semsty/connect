<?php

return [
    'controllerMap' => [
        'pgsql-migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'db' => 'db',
            'migrationNamespaces' => [
                'semsty\connect\base\db\migrations',
            ],
        ]
    ],
];
