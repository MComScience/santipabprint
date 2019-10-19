<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 16/10/2562
 * Time: 20:19
 */
$this->title = Yii::$app->name;

$this->registerCssFile("@web/css/element-ui.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()]
]);
$this->registerJsFile(
    'https://d.line-scdn.net/liff/1.0/sdk.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/vue/app.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(), 
        \yii\web\YiiAsset::className()
    ]]
);

?>
<div v-if="loadingPage" class="page-loader">Loading...</div>
