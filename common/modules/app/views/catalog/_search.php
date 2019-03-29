<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\app\models\TblCatalogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-catalog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'catalog_id') ?>

    <?= $form->field($model, 'catalog_name') ?>

    <?= $form->field($model, 'catalog_detail') ?>

    <?= $form->field($model, 'catalog_type_id') ?>

    <?= $form->field($model, 'image_path') ?>

    <?php // echo $form->field($model, 'image_base_url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
