<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\app\models\TblQuotationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-quotation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'quotation_id') ?>

    <?= $form->field($model, 'quotation_customer_name') ?>

    <?= $form->field($model, 'quotation_customer_address') ?>

    <?= $form->field($model, 'quotation_customer_email') ?>

    <?= $form->field($model, 'quotation_customer_tel') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
