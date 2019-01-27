<?php
namespace kidz\assets;

use yii\web\AssetBundle;

class AjaxCrudAsset extends AssetBundle
{
    public $sourcePath = '@kidz/assets/ajaxcrud';

    public $css = [
        'css/ajaxcrud.min.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kidz\assets\KidzAsset',
    ];

    public function init()
    {
        $this->js = YII_DEBUG ? [
            'js/ModalRemote.js',
            'js/ajaxcrud.js',
        ] : [
            'js/ModalRemote.min.js',
            'js/ajaxcrud.min.js',
        ];
        parent::init();
    }
}