<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use common\modules\settings\models\TblProductGroup;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblProductType */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile("@web/css/checkbox-style.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); ?>
            <div class="box-body">

                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        <?= $form->field($model, 'icon')->widget(Upload::classname(), [
                            'id' => 'product-type-icon',
                            'url' => ['upload-icon'],
                            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                        ])->label('ไอคอน')
                        ->hint('<span class="label label-outline-warning bg-yellow">Notice! หากขนาดภาพใหญ่เกิน <strong>112x112</strong> ระบบจะปรับขนาดให้เหลือ <strong>112x112</strong> </span>')?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'product_type_id')->textInput([
                            'maxlength' => true,
                            'readonly' => true,
                        ])->hint('<small class="label bg-yellow">Notice! ระบบจะรันเลขประเภทสินค้าให้อัตโนมัติ</small>')
                            ->label('รหัสประเภทสินค้า <button type="button" 
                            class="btn btn-xs btn-default"
                            data-toggle="popover" 
                            data-placement="right"
                            data-html="true"
                            data-content="<small>ตัวอย่างรหัสประเภทสินค้า</small> <span class=\'label bg-yellow\'>PT.0001</span>">
                              <i class="glyphicon glyphicon-question-sign"></i>
                        </button>') ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'product_type_name')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'ตัวอย่าง เช่น กล่องกระดาษ'
                        ]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'product_group_id')->checkboxList(
                                ArrayHelper::map(TblProductGroup::find()->all(), 'product_group_id' ,'product_group_name'),
                                [
                                    'inline' => false,
                                    'item' => function($index, $label, $name, $checked, $value) {
                                        $template = Html::beginTag('div',['class' => 'checkbox']).Html::beginTag('label');
                                        $template .= Html::checkbox($name, $checked, ['value' => $value]);
                                        $template .= '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>';
                                        $template .= ucwords($label);
                                        $template .= Html::endTag('label').Html::endTag('div');
                                        return $template;
                                    }
                                ]
                        )->label('กลุ่มสินค้า') ?>
                    </div>
                </div>

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

<?php
$this->registerJs(<<<JS
$(function () {
  $('[data-toggle="popover"]').popover()
})
JS
)
?>
