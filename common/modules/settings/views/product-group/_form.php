<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblProductGroup */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title ?></h3>
            </div>
            <div class="tbl-product-group-form">

                <?php $form = ActiveForm::begin(); ?>
                <div class="box-body">

                    <?= $form->field($model, 'product_group_id')->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                    ])->hint('<small class="label bg-yellow">Notice! ในการสร้างกลุ่มสินค้าใหม่ ระบบจะรันเลขกลุ่มสินค้าให้อัตโนมัติ</small>')
                        ->label('รหัสกลุ่มสินค้า <button type="button" 
                        class="btn btn-xs btn-default"
                        data-toggle="popover" 
                        data-placement="right"
                        data-html="true"
                        data-content="<small>ตัวอย่างเลขกลุ่มสินค้า</small> <span class=\'label bg-yellow\'>PG.0001</span>">
                          <i class="glyphicon glyphicon-question-sign"></i>
                    </button>') ?>

                    <?= $form->field($model, 'product_group_name')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'ตัวอย่าง เช่น บรรจุภัณฑ์'
                    ]) ?>

                    <?php if (!Yii::$app->request->isAjax): ?>
                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS
$(function () {
  $('[data-toggle="popover"]').popover()
})
JS
)
?>
