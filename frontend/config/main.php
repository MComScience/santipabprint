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
    'bootstrap' => ['log', 'languagepicker'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'controllerMap' => [
        'glide' => '\trntv\glide\controllers\GlideController'
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityCookie' => [
                'name' => '_frontendIdentity',
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
                // 'สินค้า' => 'app/product/index',
                // '<slug>' => 'app/product/quotation',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user',
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                    ],
                    'extraPatterns' => [
                        'OPTIONS {id}' => 'options',
                        // รายชื่อผู้ใช้งาน
                        'GET index' => 'index',
                        'OPTIONS index' => 'options',
                        // เข้าสู่ระบบ
                        'POST login' => 'login',
                        'OPTIONS login' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/product',
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                    ],
                    'extraPatterns' => [
                        'OPTIONS {id}' => 'options',

                        'GET index' => 'index',
                        'OPTIONS index' => 'options',

                        'POST product-categories' => 'product-categories',
                        'OPTIONS product-categories' => 'options',

                        'POST category' => 'category',
                        'OPTIONS category' => 'options',

                        'POST product-options' => 'product-options',
                        'OPTIONS product-options' => 'options',

                        'POST bill-floor-option' => 'bill-floor-option',
                        'OPTIONS bill-floor-option' => 'options',

                        'POST calculate-price' => 'calculate-price',
                        'OPTIONS calculate-price' => 'options',

                        'POST download' => 'download',
                        'OPTIONS download' => 'options',

                        'GET catalog' => 'catalog',
                        'OPTIONS catalog' => 'options',
                    ]
                ],

                '<controller:(about|login|product)>' => 'site/index',
                '<controller:(\w|-)+>/' => '<controller>/index',
                '<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:(\w|-)+>' => '<controller>/<action>'
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
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'line' => [
                    'class' => 'common\clients\Line',
                    'clientId' => '1631959964',
                    'clientSecret' => 'a5b6a3136ae0eb30009c3612dcfbb578',
                    'returnUrl' => 'https://admin.santipab.info/user/security/auth?authclient=line'
                ],
                /* 'doh' => [
                    'class' => 'common\components\DohClient',
                    'clientId' => '107ab872a61892ac6e7c1a3c80e89ceac52d894c',
                    'clientSecret' => '467841be3a3805a5a13a4aaad53ac22247e97744',
                    'returnUrl' => 'http://santipab.local/user/security/auth?authclient=doh'
                ], */
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
            'signKey' => '4XBqD5icTH/ST9HVgOSfhr+kssBGFi5GE3RI84n/DE6WqfB/rd/twPdLxo+yAnv6BJ92OqCxr7sjhqzw9rIiXg==' // "false" if you do not want to use HTTP signatures
        ],
        /*'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->format == 'html') {
                    return $response;
                }
                $responseData = $response->data;
                if (is_string($responseData) && json_decode($responseData)) {
                    $responseData = json_decode($responseData, true);
                }
                if ($response->statusCode >= 200 && $response->statusCode <= 299) {
                    $response->data = [
                        'success' => true,
                        'status' => $response->statusCode,
                        'data' => $responseData,
                    ];
                } else {
                    $response->data = [
                        'success' => false,
                        'status' => $response->statusCode,
                        'data' => $responseData,
                    ];
                }
                return $response;
            },
        ]*/
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
            'glide/*',
            'app/api/*',
            'v1/*'
        ]
    ],
    'params' => $params,
];
