<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/1/2562
 * Time: 14:31
 */

use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use kartik\widgets\Select2;
use common\modules\app\models\TblUnit;
use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-paper-size']); ?>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-8">
                    <?= $form->field($model, 'paper_size_name')->textInput([
                        'placeholder' => 'เช่น A4, A5',
                        'autocomplete' => 'off'
                    ])->label($model->getAttributeLabel('paper_size_name').Html::starRequired()); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <?= $form->field($model, 'paper_size_description')->textarea([
                        'rows' => 3
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'paper_size_width')->textInput([
                        'type' => 'number'
                    ]); ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'paper_size_height')->textInput([
                        'type' => 'number'
                    ]); ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'paper_unit_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TblUnit::find()->asArray()->all(), 'unit_id', 'unit_name'),
                        'options' => ['placeholder' => 'เลือกหน่วย...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'theme' => Select2::THEME_BOOTSTRAP,
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
$('#form-paper-size').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-paper-size-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
autosize($('textarea'));
JS
);
?>