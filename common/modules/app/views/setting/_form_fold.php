<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 14:15
 */
use kartik\form\ActiveForm;
use adminlte\helpers\Html;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-fold']); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <?= $form->field($model, 'fold_name')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off'
                ])->label($model->getAttributeLabel('fold_name').Html::starRequired()); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'fold_count')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off',
                    'type' => 'number'
                ])->label($model->getAttributeLabel('fold_count').Html::starRequired()); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'fold_description')->textarea([
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
$(function () {
  $('[data-toggle="popover"]').popover()
});
$('#form-fold').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-fold-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
autosize($('textarea'));
JS
);
?>