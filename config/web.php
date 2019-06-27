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
            'class' => '\yii\rbac\DbManager'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EZGhHfbOf9W08K9fqwJ2yA6Jnyv9KFR1',
        ],
        'cache' => [
            //            'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true
        ],
        'rbac' => [
            'class' => '\app\components\RbacComponent'
        ],
        'user' => [
            'identityClass' => '\app\models\auth\Users',
            'enableAutoLogin' => true,
        ],
        'auth' => [
            'class' => '\app\components\AuthComponent'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'noreply@pic66.ru',
                'password' => 'M6K-CLm-imn-BX7',
                'port' => 587,
                'encryption' => 'tls'
            ],
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
            'rules' => [
                 '/' => 'uploadphoto/index',
            ],
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
        'allowedIPs' => ['127.0.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1'],
    ];
}

return $config;
