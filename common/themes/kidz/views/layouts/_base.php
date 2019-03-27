<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 22:36
 */

use yii\helpers\Html;
use frontend\assets\AppAsset as FrontendAsset;
use backend\assets\AppAsset as BackendAsset;
use kidz\assets\KidzAsset;
use kidz\assets\AjaxCrudAsset;

if (Yii::$app->id == 'app-frontend') {
    FrontendAsset::register($this);
} else {
    BackendAsset::register($this);
}
/* Theme Asset */
KidzAsset::register($this);
AjaxCrudAsset::register($this);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->title,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'บริษัท สันติภาพแพ็คพริ้นท์ จำกัด',
]);
$this->registerMetaTag([
    'name' => 'og:description',
    'content' => 'บริษัท สันติภาพแพ็คพริ้นท์ จำกัด ผลิตสิ่งพิมพ์และบรรจุภัณฑ์ ให้บริการครบวงจร',
]);
$this->registerMetaTag([
    'name' => 'og:description',
    'content' => $this->title,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'MComScience',
]);
$this->registerMetaTag([
    'name' => 'og:image',
    'content' => \yii\helpers\Url::base(true).'/images/santipab_logo.png',
]);
$this->registerMetaTag([
    'name' => 'twitter:description',
    'content' => 'บริษัท สันติภาพแพ็คพริ้นท์ จำกัด ผลิตสิ่งพิมพ์และบรรจุภัณฑ์ ให้บริการครบวงจร',
]);
$this->registerMetaTag([
    'name' => 'twitter:image',
    'content' => \yii\helpers\Url::base(true).'/images/santipab_logo.png',
]);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Icons -->
        <link rel="shortcut icon" href="<?= Yii::getAlias('@web/images/favicon.ico') ?>">
        <?= Html::csrfMetaTags() ?>
        <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title) . ' | ' . Yii::$app->name.' ผลิตสิ่งพิมพ์และบรรจุภัณฑ์ ให้บริการครบวงจร' : Yii::$app->name); ?></title>
        <?php $this->head() ?>
    </head>
    <?= Html::beginTag('body', ['class' => $class]); ?>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    <?= Html::endTag('body') ?>
    </html>
<?php $this->endPage() ?>