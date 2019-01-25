<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 16:18
 */
namespace adminlte\assets;

use yii\web\AssetBundle;

class FancyboxAsset extends AssetBundle
{
    public $sourcePath = '@bower/fancybox/dist';

    public $css = [
        'jquery.fancybox.min.css'
    ];

    public $js = [
        'jquery.fancybox.min.js'
    ];

    public $depends = [
        'adminlte\assets\AdminLTEAsset',
    ];
}