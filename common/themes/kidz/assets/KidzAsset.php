<?php
namespace kidz\assets;

use yii\web\AssetBundle;

class KidzAsset extends AssetBundle
{
    public $sourcePath = '@kidz/assets/dist';

    public $css = [
        'plugins/rs-plugin/css/settings.min.css',
        'plugins/selectbox/select_option1.min.css',
        'plugins/owl-carousel/owl.carousel.min.css',
        'plugins/fancybox/jquery.fancybox.min.css',
        'plugins/isotope/isotope.min.css',
        'plugins/animate/animate.min.css',
        'css/app.min.css',
        'css/default.min.css',
        'options/optionswitch.min.css'
    ];

    public $js = [
        'plugins/rs-plugin/js/jquery.themepunch.plugins.min.js',
        'plugins/rs-plugin/js/jquery.themepunch.revolution.min.js',
        'plugins/selectbox/jquery.selectbox-0.1.3.min.js',
        'plugins/owl-carousel/owl.carousel.min.js',
        'plugins/waypoint/jquery.waypoints.min.js',
        'plugins/counter-up/jquery.counterup.min.js',
        'plugins/isotope/isotope.min.js',
        'plugins/fancybox/jquery.fancybox.min.js',
        'plugins/isotope/isotope-triger.min.js',
        'plugins/countdown/jquery.syotimer.min.js',
        'plugins/velocity/velocity.min.js',
        'plugins/smoothscroll/SmoothScroll.min.js',
        'plugins/wow/wow.min.js',
        'js/app.min.js',
        'options/optionswitcher.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'kidz\assets\FontAwesomeAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}