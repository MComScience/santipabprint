<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 26/11/2561
 * Time: 19:04
 */

namespace kidz\bootstraptoggle;

class BootstrapToggleAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/bootstrap-toggle';
    public $css = [
        'css/bootstrap-toggle.min.css',
    ];
    public $js = [
        'js/bootstrap-toggle.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}