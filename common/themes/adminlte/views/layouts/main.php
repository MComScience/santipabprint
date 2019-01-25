<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 9:07
 */
$themeAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte');
$this->registerCssFile("@web/css/settings.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
?>
<?php $this->beginContent('@adminlte/views/layouts/_base.php', ['class' => 'hold-transition skin-blue sidebar-mini']); ?>
<!-- Site wrapper -->
<div class="wrapper">
    <?= $this->render('_header', ['themeAsset' => $themeAsset]); ?>
    <?= $this->render('_sidebar', ['themeAsset' => $themeAsset]); ?>
    <?= $this->render('_content', ['content' => $content, 'themeAsset' => $themeAsset]); ?>
    <?= $this->render('_footer', ['themeAsset' => $themeAsset]); ?>
</div>
<!-- ./wrapper -->
<?php $this->endContent(); ?>
