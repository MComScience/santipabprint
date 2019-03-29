<?php
use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-group']); ?>
<div class="box">
    <div class="box-body">
        <div class="col-sm-4 col-sm-offset-4">
            <?= $form->field($model, 'icon')->widget(Upload::classname(), [
                'url' => ['upload-icon'],
                'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                'id' => 'group-icon'
            ]); ?>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'catalog_type_name')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off'
                ])->label($model->getAttributeLabel('catalog_type_name')); ?>
            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="row">
            <div class="col-sm-12 text-right">
                <?= Html::btnCancelModal() ?>
                <?= Html::btnSubmitModal() ?>
            </div>
        </div>
    </div>
    <!-- /.box-footer -->
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJsFile(
    '@web/js/form-before-submit.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJs(<<<JS
$('#form-group').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-group-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
JS
);
?>