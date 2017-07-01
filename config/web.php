<?php
$config = [
    'id' => 'finApp',
    'basePath' => __DIR__ . '/../',
    'controllerNamespace' => 'app\controllers',
    'viewPath' => __DIR__ . '/../views',
    'defaultRoute' => 'main/index',
    'bootstrap' => ['debug'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'q9SJqq0Sp5X9OFw6motfn4TghGCAZPhW'
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => ['authentication/login'],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                    ]
                ]
            ],
        ],
        'mailer' => require(__DIR__ . '/mailer.php'),
    ],
];