<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => "catalog",
    "language" => "Ru-ru",
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'zvcbzcbzxc',
            'baseUrl' => "",
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTrasport',
                'scheme' => 'smtps',
                'host' => 'smpt.mail.ru',
                'username' => 'iv2-22-web@mail.ru',
                'password' => 'khxGl62GAbFo05UcpU3z',
                'port' => 465,
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'baseUrl' => '@web',
                'basePath' => '@webroot',
                'path' => 'img',
                'name' => 'image',
                'plugin' => [
                    'Sluggable' => [
                        'lowercase' => false,
                    ]
                ]
            ],

        ]
    ],

    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            "defaultRoute" => "order"
        ],

        'account' => [
            'class' => 'app\modules\account\Module',
            "defaultRoute" => "account-order"
        ],

        'admin-lte' => [
            'class' => 'app\modules\adminlte\Module',
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
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
