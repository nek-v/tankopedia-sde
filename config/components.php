<?php

return [
    'components' => [
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                    'maxFileSize' => 512,
                    'maxLogFiles' => 5
                ]
            ]
        ],
    ]
];
