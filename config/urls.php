<?php

return [
    [
        'pattern' => 'news/<id:\d+>/<slug>',
        'route' => 'news/view',
        'defaults' => ['slug' => ''],
    ],
    'news' => 'news/view',
    
    'user' => 'user/view',

    'about' => 'site/about',
    'logout' => 'site/logout',
    'login' => 'site/login',
    'signup' => 'site/signup',
    'auth' => 'site/auth',
    
    'api/v1/profile' => 'api/v1/default/profile',
    [
        'class' => \yii\rest\UrlRule::class,
        'controller' => 'api/v1/news',
        'only' => ['index', 'view'],
    ],
    [
        'class' => \yii\rest\UrlRule::class,
        'controller' => 'api/v1/user',
        'only' => ['index', 'view'],
    ],
];
