<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Kurs Łowiecki',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'pl-PL',
    'sourceLanguage' => 'en-US',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],
            'enableFlashMessages' => true,
            'mailer' => [
                'sender' => ['babejsza@gmail.com' => 'Marcin Babecki'],
                'welcomeSubject' => 'Welcome subject',
                'confirmationSubject' => 'Confirmation subject',
                'reconfirmationSubject' => 'Email change subject',
                'recoverySubject' => 'Recovery subject',
            ],
            'controllerMap' => [
                'admin' => 'app\controllers\user\AdminController'
            ],
        ],
    ],
    'components' => [

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'le7xZz0zf1dSS2U5UJrEBz4m6S85XTSb',
            //'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'user' => [
//            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
//            'enableSession' => false,
//            'loginUrl' => ['site/login'],
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'babejsza',
                'password' => '1984Rok1',
                'port' => '465',
                'encryption' => 'ssl',
            ],
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'user/admin/update/<id:\d+>' => 'user/admin/update',
                'user/admin/update-profile/<id:\d+>' => 'user/admin/update-profile',
                'user/admin/info/<id:\d+>' => 'user/admin/info',
                'user/admin/block/<id:\d+>' => 'user/admin/block',
                'user/admin/delete/<id:\d+>' => 'user/admin/delete',
                'user/admin/confirm/<id:\d+>' => 'user/admin/confirm',
                'user/admin/index/<sort:.*>' => 'user/admin/index',
                'user/admin/index/<sort:.*>/<_pjax>' => 'user/admin/index',
                'questionlist/<page:\d+>/<perpage:\d+>' => 'questionlist/index',
                'questionlist/<page:\d+>' => 'questionlist/index',
                'study' => 'study/index',
                'study/new' => 'study/new',
                'study/continue' => 'study/continue',
                'study/next' => 'study/next',
                'GET, POST study/do' => 'study/do'
            ]
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
                ],
                'user' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
                ],
                'questions' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@bower/bootstrap/dist',
                    'css' => ['css/bootstrap.min.css'],
                    'js' => ['js/bootstrap.min.js']
                ]
            ]
        ]
//        'authClientCollection' => [
//            'class'   => \yii\authclient\Collection::className(),
//            'clients' => [
//                'facebook' => [
//                    'class'        => 'dektrium\user\clients\Facebook',
//                    'clientId'     => 'APP_ID',
//                    'clientSecret' => 'APP_SECRET',
//                ],
//            ],
//        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
