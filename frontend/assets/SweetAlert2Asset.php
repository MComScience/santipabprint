<?php
namespace app\assets;

use yii\web\AssetBundle;

class SweetAlert2Asset extends AssetBundle
{
    public $sourcePath = '@bower/sweetalert2';
    
    public $css = [
        'dist/sweetalert2.min.css',
    ];

    public $js = [
        'dist/sweetalert2.all.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}