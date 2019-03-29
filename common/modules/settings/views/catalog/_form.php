<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblCatalog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-catalog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'catalog_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catalog_detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'catalog_type_id')->textInput() ?>

    <?= $form->field($model, 'image_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_base_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
