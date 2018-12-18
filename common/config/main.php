<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@kidz'   => '@common/themes/kidz',
        '@kidz/user' => '@kidz/modules/yii2-user',
        '@kidz/bootstraptoggle' => '@kidz/widgets/yii2-bootstrap-toggle/src',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'บริษัท สันติภาพแพ็คพริ้นท์ จำกัด',
    # ตั้งค่าการใช้งานภาษาไทย (Language)
    'language' => 'th', // ตั้งค่าภาษาไทย
    # ตั้งค่า TimeZone ประเทศไทย
    'timeZone' => 'Asia/Bangkok', // ตั้งค่า TimeZone
    //'sourceLanguage' => 'th-TH',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /*'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => 'redis'
        ],*/
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'defaultTimeZone' => 'Asia/Bangkok',
            'timeZone' => 'Asia/Bangkok'
        ],
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            'languages' => ['en' => 'English (US)', 'th' => 'ภาษาไทย'],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableFlashMessages' => true,
            'enableGeneratingPassword' => false,
            'enableConfirmation' => true,
            'enablePasswordRecovery' => true,
            'enableAccountDelete' => false,
            'enableRegistration' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],
            'urlPrefix' => 'auth',
            'modelMap' => [
                'User' => 'kidz\user\models\User',
                'Profile' => 'kidz\user\models\Profile',
                'RegistrationForm' => 'kidz\user\models\RegistrationForm',
                'Account' => 'kidz\user\models\Account',
            ],
            'controllerMap' => [
                'settings' => [
                    'class' => 'kidz\user\controllers\SettingsController',
                ],
                'admin' => [
                    'class' => 'kidz\user\controllers\AdminController',
                ],
                'registration' => [
                    'class' => 'kidz\user\controllers\RegistrationController',
                    //'layout' => '@kidz/views/layouts/main-login',
                ],
                'recovery' => [
                    'class' => 'kidz\user\controllers\RecoveryController',
                    //'layout' => '@kidz/views/layouts/main-login',
                ],
                'security' => [
                    'class' => 'kidz\user\controllers\SecurityController',
                    //'layout' => '@kidz/views/layouts/main-login',
                ],
            ],
        ],
        'file' => [
            'class' => 'common\modules\file\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'top-menu', //'left-menu', 'right-menu' and 'top-menu'
            'menus' => [
                'menu' => null,
                'user' => null, // disable menu
            ],
        ],
    ],
];
