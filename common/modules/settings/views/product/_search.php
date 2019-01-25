<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\search\TblProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'product_type_id') ?>

    <?= $form->field($model, 'product_name') ?>

    <?= $form->field($model, 'product_description') ?>

    <?= $form->field($model, 'product_icon_path') ?>

    <?php // echo $form->field($model, 'product_icon_base_url') ?>

    <?php // echo $form->field($model, 'product_status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
