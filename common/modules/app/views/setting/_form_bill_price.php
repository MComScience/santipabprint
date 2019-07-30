<?php

use adminlte\helpers\Html;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblPaper;
?>

<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-bill-price']); ?>
<div class="row">
    <div class="col-sm-4">
        <?= Html::activeHiddenInput($model, 'bill_price_id') ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?=
        $form->field($model, 'paper_size_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TblPaperSize::find()->asArray()->all(), 'paper_size_id', 'paper_size_name'),
            'options' => ['placeholder' => 'เลือกประเภทกระดาษ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'theme' => Select2::THEME_BOOTSTRAP,
        ])->label('ขนาดกระดาษ');
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?=
        $form->field($model, 'paper_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TblPaper::find()->asArray()->all(), 'paper_id', 'paper_name'),
            'options' => ['placeholder' => 'เลือกกระดาษ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'theme' => Select2::THEME_BOOTSTRAP,
        ])->label('กระดาษ');
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?=
        $form->field($model, 'bill_floor')->textInput([
            'placeholder' => '',
            'autocomplete' => 'off'
        ])->label($model->getAttributeLabel('bill_floor'));
        ?>
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
    'formId' => 'form-bill-price',
    'formFields' => [
        'bill_detail_id',
        'bill_price_id',
        'bill_detail_qty',
        'bill_detail_price'
    ],
]);
?>
<div class="box box-info">
    <div class="box-header">
        <i class="fa fa-file-text-o"></i>
        <h3 class="box-title">
            รายละเอียดราคา
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
                            echo Html::activeHiddenInput($modelsDetail, "[{$i}]bill_detail_id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?=
                                $form->field($modelsDetail, "[{$i}]bill_detail_qty")->textInput([
                                    'placeholder' => '',
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10">
                                <?=
                                $form->field($modelsDetail, "[{$i}]bill_detail_price")->textInput([
                                    'placeholder' => '',
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <?= Html::activeHiddenInput($modelsDetail, "[{$i}]bill_price_id"); ?>
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
<?php ActiveForm::end(); ?>

<?php
$this->registerJsFile(
        '@web/js/form-before-submit.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
        '@web/js/autosize.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJs(<<<JS
$('#form-bill-price').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-bill-price-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
autosize($('textarea'));
$("#grid-bill-price-pjax").on("pjax:success", function() {
    $.pjax.reload({container: "#pjax-menu"});
});
JS
);
?>