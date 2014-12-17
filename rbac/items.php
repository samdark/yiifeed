<?php
return [
    'createNews' => [
        'type' => 2,
        'description' => 'Create a news',
    ],
    'updateNews' => [
        'type' => 2,
        'description' => 'Update news',
    ],
    'addUserNews' => [
        'type' => 2,
        'description' => 'User add news',
    ],
    'listNews' => [
        'type' => 2,
        'description' => 'Show list news',
    ],
    'deleteNews' => [
        'type' => 2,
        'description' => 'Delete news',
    ],
    'adminListNews' => [
        'type' => 2,
        'description' => 'Show list news',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'children' => [
            'addUserNews',
            'listNews',
        ],
    ],
    'moderator' => [
        'type' => 1,
        'description' => 'Модератор',
        'children' => [
            'createNews',
            'updateNews',
            'listNews',
            'adminListNews',
            'deleteNews',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'children' => [
            'updateNews',
            'moderator',
        ],
    ],
];
