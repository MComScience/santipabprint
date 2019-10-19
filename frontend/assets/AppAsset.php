<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'bundle/site.css',
        'bundle/mobilemenu.css',
        'https://fonts.googleapis.com/css?family=Prompt:400',
        'css/loader.css'
    ];
    public $js = [
        // 'bundle/app.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
