<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 9:03
 */

use yii\helpers\Html;
use frontend\assets\AppAsset as FrontendAsset;
use backend\assets\AppAsset as BackendAsset;
use adminlte\assets\AdminLTEAsset;

if (Yii::$app->id == 'app-frontend') {
    FrontendAsset::register($this);
} else {
    BackendAsset::register($this);
}
/* Theme Asset */
AdminLTEAsset::register($this);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Yii::$app->name,
]);
$this->registerMetaTag([
    'name' => 'description',
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
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <!-- Icons -->
        <link rel="shortcut icon" href="<?= Yii::getAlias('@web/images/favicon.ico') ?>">
        <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
        <?= Html::csrfMetaTags() ?>
        <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title) . ' | ' . Yii::$app->name : Yii::$app->name); ?></title>
        <?php $this->head() ?>
    </head>
    <?= Html::beginTag('body', ['class' => $class]); ?>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    <?= Html::endTag('body') ?>
    </html>
<?php $this->endPage() ?>