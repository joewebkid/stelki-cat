<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'a1',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'SMS' => [
            'class' => 'app\components\informing\SMS'
        ],
        'Email' => [
            'class' => 'app\components\informing\Email'
        ],
        'DateTime' => [
            'class' => 'app\components\viewHelper\DateTime'
        ],
        'Resize' => [
            'class' => 'app\components\image\Resize'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'G8M0z6B6UDdQ19n9lDzhR9dl3ykPNxNZ',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'viewPath' => '@app/views/mail',
//            'htmlLayout'=>false,
//            'textLayout'=>false,
//
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.yandex.ru',
//                'username' => 'admin@mashino-mesta.ru',
//                'password' => 'n54vdz21',
//                'port' => '465',
//                'encryption' => 'ssl',
//            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'admin' => 'admin/index/index',
                'admin/<controller:[a-zA-Z\-]+>/<action:[a-zA-Z\-]+>' => 'admin/<controller>/<action>',
                // 'cabinet/index' => 'cabinet/index?per-page=3',
                // 'cabinet' => 'cabinet/index',
                'technology' => 'site/technology'
            ],
        ],
    ],
    'modules' => [
        'admin' => \app\modules\staff\StaffModule::class,
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['83.171.111.136'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['83.171.111.136', '127.0.0.1'],
    ];
}

return $config;
