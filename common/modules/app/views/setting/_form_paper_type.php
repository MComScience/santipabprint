<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/1/2562
 * Time: 21:16
 */
use kartik\form\ActiveForm;
use adminlte\helpers\Html;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-paper-type']); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'paper_type_name')->textInput([
                    'placeholder' => 'เช่น กระดาษปอนด์',
                    'autocomplete' => 'off'
                ])->label($model->getAttributeLabel('paper_type_name').Html::starRequired()); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'paper_type_flag')->radioList($model->getFlagOptions(),[

                ]); ?>
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
$('#form-paper-type').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-paper-type-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
JS
);
?>