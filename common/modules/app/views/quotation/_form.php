<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\app\models\TblQuotation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-quotation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quotation_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quotation_customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quotation_customer_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quotation_customer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quotation_customer_tel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
