<?php

return [
    'adminEmail' => 'sam+yiifeed@rmcreative.ru',
    'notificationEmail' => 'noreply@yiifeed.com',
    'supportEmail' => 'noreply@yiifeed.com',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    
    'components.urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => require __DIR__ . '/urls.php',
    ],
    'components.queue' => [
        'class' => \yii\queue\db\Queue::class,
        'channel' => 'default'
    ],
];
