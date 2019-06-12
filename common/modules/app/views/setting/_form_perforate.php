<?php

use adminlte\helpers\Html;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-perforate']); ?>
<div class="row">
    <div class="col-sm-4">
        <?= Html::activeHiddenInput($model, 'perforate_id') ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?=
        $form->field($model, 'perforate_name')->textInput([
            'placeholder' => 'รูปแบบ',
        ]);
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
    'model' => $modelsPerforateOptions[0],
    'formId' => 'form-perforate',
    'formFields' => [
        'perforate_option_id',
        'perforate_option_name',
        'perforate_option_description',
        
    ],
]);
?>
<div class="box box-info">
    <div class="box-header">
        <i class="fa fa-file-text-o"></i>
        <h3 class="box-title">
            รูปแบบ tag/ที่คั่น
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
            <?php foreach ($modelsPerforateOptions as $i => $modelsPerforateOption): ?>
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
                        if (!$modelsPerforateOption->isNewRecord) {
                            echo Html::activeHiddenInput($modelsPerforateOption, "[{$i}]perforate_option_id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?=
                                $form->field($modelsPerforateOption, "[{$i}]perforate_option_name")->textInput([
                                    'placeholder' => '',
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10">
                                <?=
                                $form->field($modelsPerforateOption, "[{$i}]perforate_option_description")->textarea([
                                    'rows' => 3
                                ])
                                ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <?= Html::activeHiddenInput($modelsPerforateOption, "[{$i}]perforate_id"); ?>
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
    '@web/js/form-before-submit.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/autosize.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJs(<<<JS
$('#form-perforate').formBeforeSubmit({
    swal: true,
    pjax: {id: '#grid-perforate-pjax'},
    modal: {id: '#ajaxCrudModal'}
});
$('#ajaxCrudModal .modal-footer').hide();
autosize($('textarea'));
JS
);
?>