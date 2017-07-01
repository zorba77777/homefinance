<?php
return [
    'id' => 'appConsole',
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