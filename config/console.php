<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'migrate'=>[
            'class'=>'app\commands\MigrateController',
            'migrationLookup'=>[
                //Default migration dir automatic check
                '@app/modules/auth/migrations',
                // add other migration path here
            ]
        ]
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
        'auth' => require(__DIR__ . '/auth.php'),
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
