<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 15/10/2562
 * Time: 13:30
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblPackageType;
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use kartik\widgets\SwitchInput;
use yii\jui\JuiAsset;

SweetAlert2Asset::register($this);
JuiAsset::register($this);

$this->title = 'บันทึกสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/app/setting/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
.action {
    text-align: right;
    display: inline-block;
}
table#table-dynamic-form tbody tr td.arrows:hover {
    cursor: move;
}
.upload-kit,
.field-tblproduct-icon label,
.field-tblproduct-icon .hint-block {
    display: flex;
    justify-content: center;
    align-items: center;
}
CSS
)
?>

<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'dynamic-form']); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">สินค้า</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?=
                $form->field($model, 'icon')->widget(Upload::classname(), [
                    'url' => ['upload-icon'],
                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                    'id' => 'product-icon',
                    'maxFileSize' => 1 * 1024 * 1024, // 1Mb
                ])->hint('<span class="text-danger">**ขนาดไฟล์: ไม่เกิน 1MB</span> ,ชนิดไฟล์: gif, jpeg, png')->label('ภาพตัวอย่างสินค้า');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <?=
                $form->field($model, 'product_name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'ชื่อสินค้า'
                ])
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <?=
                $form->field($model, 'product_category_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TblProductCategory::find()->asArray()->all(), 'product_category_id', 'product_category_name'),
                    'options' => ['placeholder' => 'เลือกหมวดหมู่'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                ])->label('หมวดหมู่');
                ?>
            </div>
            <div class="col-sm-6 col-sm-12">
                <?=
                $form->field($model, 'package_type_id')->widget(DepDrop::classname(), [
                    'data' => ArrayHelper::map(TblPackageType::find()->where(['product_category_id' => $model['product_category_id']])->asArray()->all(), 'package_type_id', 'package_type_name'),
                    'pluginOptions' => [
                        'depends' => ['tblproduct-product_category_id'],
                        'placeholder' => 'Select...',
                        'url' => Url::to(['/app/setting/sub-product-category'])
                    ],
                    'type' => DepDrop::TYPE_SELECT2,
                    'options' => ['placeholder' => 'Select ...'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                ])->label('ประเภทสินค้า');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <?=
                $form->field($model, 'product_description')->widget(\yii\redactor\widgets\Redactor::className(), [
                    'clientOptions' => [
                        'plugins' => ['clips', 'fontcolor', 'imagemanager']
                    ]
                ])
                ?>
            </div>
        </div>
        <!--begin:Dynamic Form-->
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 100, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $modelSettings[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'full_name',
                'address_line1',
                'address_line2',
                'city',
                'state',
                'postal_code',
            ],
        ]); ?>
        <div class="table-responsive">
            <div class="panel panel-default <?= $isCreate ? 'hidden' : '' ?>">
                <div class="panel-heading">
                    <i class="fa fa-cogs"></i> กำหนดตัวเลือก
                    <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i>
                        เพิ่มรายการ
                    </button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body"><!-- widgetContainer -->
                    <table class="table table-bordered" style="margin-bottom: 0">
                        <thead>
                        <tr>
                            <th style="width: 35px;">#</th>
                            <th style="width: 110px;">#</th>
                            <th style="width: 25%">ตัวเลือก</th>
                            <th style="width: 20%">ชื่อตัวเลือก</th>
                            <th>ข้อมูลตัวเลือก</th>
                            <th style="width: 10%"></th>
                        </tr>
                        </thead>
                    </table>
                    <table class="table table-condensed table-hover" style="margin-bottom: 0" id="table-dynamic-form">
                        <tbody class="container-items">
                        <?php foreach ($modelSettings as $index => $modelSetting): ?>
                            <tr class="item">
                                <td class="arrows">
                                    <i class="fa fa-arrows"></i>
                                </td>
                                <td style="width: 35px;">
                                    <?php /* $form->field($modelSetting, "[{$index}]filed_active")->checkbox()->label('') */ ?>
                                    <?= $form->field($modelSetting, "[{$index}]filed_active", ['showLabels' => false])->widget(SwitchInput::classname(), [
                                        'pluginOptions' => [
                                            'size' => 'mini',
                                            'onText' => 'Active',
                                            'offText' => 'Inactive'
                                        ]
                                    ]) ?>
                                </td>
                                <td style="width: 25%;vertical-align: middle;">
                                    <?= $form->field($modelSetting, "[{$index}]field_name", ['showLabels' => false])->widget(Select2::classname(), [
                                        'data' => $fieldNameOptions,
                                        'options' => ['placeholder' => 'เลือกรายการ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'width' => '250px'
                                        ],
                                        // 'theme' => Select2::THEME_BOOTSTRAP,
                                        'pluginEvents' => [
                                            "change" => "function(e) { handleChangeFieldName(e) }",
                                        ],
                                        'size' => Select2::SIZE_SMALL
                                    ]); ?>
                                </td>
                                <td style="width: 20%;vertical-align: middle;">
                                    <?= $form->field($modelSetting, "[{$index}]field_label", ['showLabels' => false])->textInput([
                                        'placeholder' => '',
                                        'class' => 'input-sm',
                                        'style' => 'width: 170px'
                                    ]); ?>
                                </td>
                                <td style="vertical-align: middle;">
                                    <?= $form->field($modelSetting, "[{$index}]field_option_values", ['showLabels' => false])->widget(Select2::classname(), [
                                        'data' => $modelSetting['field_option'],
                                        'options' => [
                                            'placeholder' => 'เลือกรายการ...',
                                            'multiple' => true
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'width' => '400px'
                                        ],
                                        'size' => Select2::SIZE_SMALL
                                        // 'theme' => Select2::THEME_BOOTSTRAP
                                    ]); ?>
                                </td>
                                <td style="width: 10%;text-align: center;vertical-align: middle;white-space: nowrap">
                                    <span class="title-field hidden"></span>
                                    <p class="action-control">
                                        <button type="button" class=" remove-item btn btn-danger btn-xs">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class=" add-item btn btn-success btn-xs">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </p>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php /*
        <?php foreach ($modelSettings as $index => $modelSetting): ?>
            <div class="item panel panel-default"><!-- widgetBody -->
                <div class="panel-body">
                    <div class="text-center">
                        <span class="panel-title-address text-center">ตัวเลือกที่: <?= ($index + 1) ?></span>
                    </div>

                    <div class="action pull-right">
                        <button type="button" class=" remove-item btn btn-danger btn-xs">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class=" add-item btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>

                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div><!-- end:row -->

                    <div class="row hidden">
                        <div class="col-sm-6">
                            <?= $form->field($modelSetting, "[{$index}]field_option")->widget(Select2::classname(), [
                                'data' => [
                                    'paper_size' => 'ขนาด',
                                    'paper' => 'กระดาษ',
                                    'print_color' => 'สีที่พิมพ์',
                                    'coating' => 'เคลือบ',
                                    'dicut' => 'ไดคัท',
                                    'fold' => 'วิธีพับ',
                                    'foil_color' => 'สีฟอยล์',
                                    'book_binding' => 'วิธีเข้าเล่ม',
                                    'perforate' => 'มุมที่เจาะ'
                                ],
                                'options' => ['placeholder' => 'Select a state ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'pluginEvents' => [
                                    "change" => "function(e) { handleChangeFieldOption(e) }",
                                ]
                            ]); ?>
                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div><!-- end:row -->

                </div>
            </div>
        <?php endforeach; ?>
 */ ?>
                </div>
            </div>
        </div>
        <?php DynamicFormWidget::end(); ?>
        <!--end:Dynamic Form-->

    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-sm-12 text-right">
                <?=
                Html::a(Icon::show('close') . 'Close', ['product'], [
                    'class' => 'btn btn-danger',
                ])
                ?>
                <?=
                Html::submitButton(Icon::show('save') . 'Save', [
                    'class' => 'btn btn-success'
                ])
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$this->registerJs($this->render('@app/web/js/product-dynamic-form.js'));
?>
