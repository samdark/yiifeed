<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'yiifeed-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii', 'queue'],
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationNamespaces' => [
                'yii\queue\db\migrations',
            ],
        ],
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
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
        'mutex' => \yii\mutex\MysqlMutex::class,
        'urlManager' => array_merge(
            $params['components.urlManager'],
            [
                'baseUrl' => '',
                'hostInfo' => $params['siteAbsoluteUrl']
            ]
        ),
        'queue' => $params['components.queue'],
    ],
    'params' => $params,
];
