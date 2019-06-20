<?php

$params = require __DIR__ . '/params.php';
$db = file_exists(__DIR__ . '/db_local.php') ? (require __DIR__ . '/db_local.php') : (require __DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@pho' => 'web/img/orders/',
        '@RetailLink' => 'https://pic66.retailcrm.ru',
        '@RetailToken' => 'IFaqAmOElF74tUqdiCCmr0jlGYjXpc7E'
        /** доступно только 2 метода. скромные */
    ],
    'components' => [
        'authManager' => [
            'class' => \yii\rbac\DbManager::class
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EZGhHfbOf9W08K9fqwJ2yA6Jnyv9KFR1',
        ],
        'activity' => ['class' => \app\components\ActivityComponent::class],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'rbac' => [
            'class' => \app\components\RbacComponent::class
        ],
        'user' => [
            'identityClass' => \app\models\auth\Users::class,
            //            'enableAutoLogin' => true,
        ],
        'auth' => [
            'class' => \app\components\AuthComponent::class
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning'
                    ],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '82.151.209.202'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '82.151.209.202'],
    ];
}

return $config;
