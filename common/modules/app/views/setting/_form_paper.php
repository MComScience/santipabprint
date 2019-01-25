<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 9:47
 */
use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\modules\app\models\TblPaperType;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-paper']); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'paper_type_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TblPaperType::find()->asArray()->all(), 'paper_type_id', 'paper_type_name'),
                    'options' => ['placeholder' => 'เลือกประเภท...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                ])->label('ประเภท'.Html::starRequired()); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <?= $form->field($model, 'paper_name')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off'
                ])->label($model->getAttributeLabel('paper_name').Html::starRequired()); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'paper_description')->textarea([
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
$('#form-paper').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-paper-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
autosize($('textarea'));
JS
);
?>