<?php
return [
    'adminNews' => [
        'type' => 2,
        'description' => 'Administrate news',
    ],
    'adminUsers' => [
        'type' => 2,
        'description' => 'Administrate users',
    ],
    'moderator' => [
        'type' => 1,
        'description' => 'Moderator',
        'children' => [
            'adminNews',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'children' => [
            'moderator',
            'adminUsers',
        ],
    ],
];
