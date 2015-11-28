<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'tankopedia-sde',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'maxFileSize' => 512,
                    'maxLogFiles' => 5
                ]
            ]
        ]
    ],
    'params' => $params,
];

return $config;
