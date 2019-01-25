<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 18:58
 */
use kartik\form\ActiveForm;
use adminlte\helpers\Html;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-book-binding']); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <?= $form->field($model, 'book_binding_name')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off'
                ])->label($model->getAttributeLabel('book_binding_name').Html::starRequired()); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'book_binding_description')->textarea([
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
$('#form-book-binding').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-book-binding-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
autosize($('textarea'));
JS
);
?>
