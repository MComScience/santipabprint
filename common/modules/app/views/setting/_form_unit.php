<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 18:45
 */
use kartik\form\ActiveForm;
use adminlte\helpers\Html;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-unit']); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'unit_name')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off'
                ])->label($model->getAttributeLabel('unit_name').Html::starRequired()); ?>
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
$('#form-unit').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-unit-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
JS
);
?>