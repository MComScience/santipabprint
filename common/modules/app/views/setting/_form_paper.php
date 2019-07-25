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
use wbraganca\dynamicform\DynamicFormWidget;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-paper']); ?>
<div class="row">
    <div class="col-sm-4">
        <?= $form->field($model, 'paper_type_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TblPaperType::find()->asArray()->all(), 'paper_type_id', 'paper_type_name'),
            'options' => ['placeholder' => 'เลือกประเภทกระดาษ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'theme' => Select2::THEME_BOOTSTRAP,
        ])->label('ประเภทกระดาษ'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <?= $form->field($model, 'paper_name')->textInput([
            'placeholder' => '',
            'autocomplete' => 'off'
        ])->label($model->getAttributeLabel('paper_name')); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'paper_gram')->textInput([
            'placeholder' => '',
            'autocomplete' => 'off',
            'type' => 'number',
            'min' => 0
        ])->label($model->getAttributeLabel('paper_gram')); ?>
    </div>
</div>
<?php
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 10, // the maximum times, an element can be added (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $modelsDetails[0],
    'formId' => 'form-paper',
    'formFields' => [
        'paper_detail_id',
        'paper_id',
        'paper_size',
        'paper_width',
        'paper_length',
        'paper_price',
        'stk_flag'
    ],
]);
?>
<div class="box box-info">
    <div class="box-header">
        <i class="fa fa-file-text-o"></i>
        <h3 class="box-title">
            รายละเอียดสินค้า
        </h3>
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-default btn-sm add-item">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /. tools -->
    </div>
    <div class="box-body">
        <div class="container-items"><!-- widgetBody -->
            <?php foreach ($modelsDetails as $i => $modelsDetail): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    <div class="pull-right" style="padding: 10px;">
                        <button type="button" class="remove-item btn btn-danger btn-xs">
                            <i class="glyphicon glyphicon-minus"></i>
                        </button>
                        <button type="button" class="btn btn-info btn-xs add-item">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$modelsDetail->isNewRecord) {
                            echo Html::activeHiddenInput($modelsDetail, "[{$i}]paper_detail_id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?=
                                $form->field($modelsDetail, "[{$i}]paper_size")->textInput([
                                    'placeholder' => 'S1, S2, L',
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?=
                                $form->field($modelsDetail, "[{$i}]paper_width")->textInput([
                                    'placeholder' => '',
                                ]);
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?=
                                $form->field($modelsDetail, "[{$i}]paper_length")->textInput([
                                    'placeholder' => '',
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?=
                                $form->field($modelsDetail, "[{$i}]paper_price")->textInput([
                                    'placeholder' => '',
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= 
                                $form->field($modelsDetail, "[{$i}]stk_flag")->radioList([
                                    'N' => 'ไม่ใช่สติ๊กเกอร์',
                                    'Y' => 'สติ๊กเกอร์'
                                ],[]); 
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= Html::activeHiddenInput($modelsDetail, "[{$i}]paper_id"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php DynamicFormWidget::end(); ?>
<div class="row">
    <div class="col-sm-12 text-right">
        <?= Html::btnCancelModal() ?>
        <?= Html::btnSubmitModal() ?>
    </div>
</div>
<?php /*
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'paper_width')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off',
                ])->label($model->getAttributeLabel('paper_width')); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'paper_length')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off',
                ])->label($model->getAttributeLabel('paper_length')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'paper_price')->textInput([
                    'placeholder' => '',
                    'autocomplete' => 'off',
                ])->label($model->getAttributeLabel('paper_price')); ?>
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
    <!-- /.box-footer -->
</div>
*/?>
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
$("#grid-paper-pjax").on("pjax:success", function() {
    $.pjax.reload({container: "#pjax-menu"});
});
JS
);
?>