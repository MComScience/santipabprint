<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 14:39
 */
use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use kartik\widgets\ColorInput;
?>
<style type="text/css">
    span#tblfoilcolor-foil_color_code-cont {
        width: 70px;
    }
</style>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-foil-color']); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <?= $form->field($model, 'foil_color_name')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off'
                ])->label($model->getAttributeLabel('foil_color_name').Html::starRequired()); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'foil_color_code')->widget(ColorInput::classname(), [
                    'options' => ['placeholder' => 'Select color ...'],
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'foil_color_description')->textarea([
                    'rows' => 3
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
$this->registerJsFile(
    '@web/js/autosize.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJs(<<<JS
$('#form-foil-color').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-foil-color-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
autosize($('textarea'));
$("#grid-foil-color-pjax").on("pjax:success", function() {
    $.pjax.reload({container: "#pjax-menu"});
});
JS
);
?>