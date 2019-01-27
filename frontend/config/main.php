<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','languagepicker'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'app/product/index',
    'controllerMap' => [
        'glide' => '\trntv\glide\controllers\GlideController'
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityCookie' => [
                'name'     => '_frontendIdentity',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'name' => 'FRONTENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                /* 'สินค้า' => 'app/product/index',*/
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['app/product'],
                    'patterns' => [
                        '<slug>' => 'quotation',
                    ],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@kidz/views',
                    '@dektrium/user/views' => '@kidz/user/views',
                ],
            ],
        ],
        'fileStorage' => [
            'class' => 'trntv\filekit\Storage',
            'baseUrl' => '@web/uploads',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@webroot/uploads'
            ],
            'as log' => [
                'class' => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ],
        ],
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => [
                'line' => [
                    'class' => 'common\clients\Line',
                    'clientId' => '1631959964',
                    'clientSecret' => 'a5b6a3136ae0eb30009c3612dcfbb578',
                    'returnUrl' => 'https://santipab.info/user/security/auth?authclient=line'
                ],
            ],
        ],
        'slugUrl' => [
            'class' => 'common\components\SlugUrl',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'linkAssets' => true,
            'bundles' => require __DIR__ . '/bundles.php',
        ],
        'glide' => [
            'class' => 'trntv\glide\components\Glide',
            'sourcePath' => '@webroot',
            'cachePath' => '@runtime/glide',
            'signKey' => false // "false" if you do not want to use HTTP signatures
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'user/registration/*',
            'user/recovery/*',
            'user/security/*',
            'webhook/*',
            'product/*',
            'app/product/*',
            'glide/*'
        ]
    ],
    'params' => $params,
];
