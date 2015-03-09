<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii', 'nodeSocket'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'aliases' => [
        '@YiiNodeSocket' => '@vendor/yii-node-socket/lib/php',
        '@nodeWeb' => '@vendor/yii-node-socket/lib/js'
    ],
    'controllerMap' => [
        'node-socket' => '\YiiNodeSocket\NodeSocketCommand',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'nodeSocket' => [
            'class' => '\YiiNodeSocket\NodeSocket',
            'host' => 'realtimechat',
            'allowedServerAddresses' => [
                "realtimechat",
                "127.0.0.1"
            ],
            'origin' => '*:*',
            'sessionVarName' => 'PHPSESSID',
            'port' => 3001,
            'socketLogFile' => '/var/log/node-socket.log',
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
