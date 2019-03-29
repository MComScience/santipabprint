<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 14/1/2562
 * Time: 16:28
 */

use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\bootstrap\Tabs;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\web\View;
use kartik\widgets\TouchSpin;
use common\modules\settings\models\TblUnit;
use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

$this->registerCssFile('@web/js/waitMe/waitMe.min.css', [
    'depends' => [
        \yii\bootstrap\BootstrapAsset::className(),
        \kidz\assets\KidzAsset::className(),
        \frontend\assets\AppAsset::className()
    ],
]);
$this->registerCssFile('@web/css/quotation.css', [
    'depends' => [
        \yii\bootstrap\BootstrapAsset::className(),
        \kidz\assets\KidzAsset::className(),
        \frontend\assets\AppAsset::className()
    ],
]);
$this->registerJs(<<<JS
function format(state) {
    if (!state.id) return state.text; // optgroup
    return state.text;
}
JS
    , View::POS_HEAD);
$escape = new JsExpression("function(m) { return m; }");
$lineDashed = '<div class="padding-v-sm"><div class="line line-dashed"></div></div>';
$checkboxTemplate = '{input}
                    <div class="[ btn-group ]" style="width: 100%;">
                        <label for="tblquotationdetail-custom_paper" class="[ btn btn-info btn-sm ]" style="width: 20%">
                            <span class="[ glyphicon glyphicon-ok ]"></span>
                            <span> </span>
                        </label>
                        <label for="tblquotationdetail-custom_paper" class="[ btn btn-info btn-sm ]" style="width: 80%;">
                            กำหนดขนาดเอง
                        </label>
                    </div>{error}{hint}';
?>
    <section class="whiteSection full-width clearfix qoutationSection" style="padding: 20px 0;">
        <div class="container">
            <!-- Section Title -->
            <div class="sectionTitle text-center">
                <h2 class="wow" style="margin-bottom: 5px;">
                    <span class="shape shape-left bg-color-4"></span>
                    <span>
                    <?= $modelProduct['product_name'] ?>
                </span>
                <span class="shape shape-right bg-color-4"></span>
                </h2>
            </div>
            <!--<div class="row progress-wizard" style="border-bottom:0;">
                <div class="col-sm-4 col-xs-12 progress-wizard-step active">
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="checkout-step-1.html" class="progress-wizard-dot">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </a>
                    <div class="progressInfo">1. Personal info</div>
                </div>

                <div class="col-sm-4 col-xs-12 progress-wizard-step incomplete">
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="checkout-step-2.html" class="progress-wizard-dot">
                        <i class="fa fa-usd" aria-hidden="true"></i>
                    </a>
                    <div class="progressInfo">2. Payment Mathod</div>
                </div>

                <div class="col-sm-4 col-xs-12 progress-wizard-step incomplete">
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="checkout-step-3.html" class="progress-wizard-dot">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </a>
                    <div class="progressInfo">3. Confirmation</div>
                </div>
            </div>-->
            <div class="row">
                <div class="col-md-7 col-lg-8 order-1 order-md-0">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <?=
                            Html::img(Yii::getAlias('@web/images/document.png'), [
                                'width' => '50px',
                                'class' => 'img-responsive center-block'
                            ]) . '<p class="text-center">กำหนดหมวดหมู่งานพิมพ์</p>'
                            ?>
                        </div>
                    </div>
                    <?php
                    /*echo Tabs::widget([
                        'items' => [
                            [
                                'label' => Html::img(Yii::getAlias('@web/images/document.png'), [
                                        'width' => '50px'
                                    ]) . 'เลือกตัวเลือกของคุณ',
                                'active' => true,
                                'options' => ['id' => 'tab-form', 'style' => 'background-color: #f8f8f8;'],
                            ],
                        ],
                        'renderTabContent' => false,
                        'encodeLabels' => false,
                        'options' => [
                            'style' => 'border-bottom: 1px solid #bce8f1;',
                            'id' => 'tabs-product'
                        ]
                    ]);*/
                    ?>

                    <div class="tab-content product-content">
                        <div role="tabpanel" class="tab-pane active" id="tab-form">
                            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-quotation']); ?>
                            <div class="panel panel-info"
                                 style="/*border-top: inherit;*/border-top-left-radius: 0px;border-top-right-radius: 0px;">
                                <!--<div class="panel-heading bg-color-3 border-color-3">
                                    <h4 class="panel-title" style="color: #fff">
                                        เลือกตัวเลือกของคุณ
                                    </h4>
                                </div>-->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'paper_size_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($dataOptions['paperSizeOptions'], 'paper_size_id', 'paper_size_name'),
                                                'options' => ['placeholder' => 'เลือกขนาด'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'templateResult' => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup' => $escape,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('ขนาดสำเร็จ<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                        </div>
                                    </div>
                                    <!--<div class="padding-v-sm">
                                        <div class="line line-dashed"></div>
                                    </div>-->
                                    <div class="row custom-paper-size" style="display: none;">

                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'custom_paper_width')->textInput([
                                                'type' => 'number',
                                                'placeholder' => 'ความกว้าง'
                                            ])->label('กว้าง<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'custom_paper_height')->textInput([
                                                'type' => 'number',
                                                'placeholder' => 'ความสูง'
                                            ])->label('สูง<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'custom_paper_unit')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TblUnit::find()->asArray()->all(), 'unit_id', 'unit_name'),
                                                'options' => ['placeholder' => 'เลือกหน่วย'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('หน่วย<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                    </div>
                                    <!--<div class="padding-v-sm custom-paper-size" style="display: none">
                                        <div class="line line-dashed"></div>
                                    </div>-->
                                    <div class="row" style="display: none;">
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?=
                                            $form->field($modelQuotationDetail, 'quotation_qty')->textInput([
                                                'type' => 'number'
                                            ])->label('จำนวน<span class="text-danger">*</span>'); ?>
                                        </div>
                                    </div>

                                    <div class="padding-v-sm ">
                                        <div class="line line-dashed"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'first_page')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($dataOptions['printOptions'], 'print_option_id', 'print_option_name'),
                                                'options' => ['placeholder' => 'เลือกรูปแบบ'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'templateResult' => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup' => $escape,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('หน้าแรก<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'last_page')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($dataOptions['printOptions'], 'print_option_id', 'print_option_name'),
                                                'options' => ['placeholder' => 'เลือกรูปแบบ'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'templateResult' => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup' => $escape,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('หน้าหลัง<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                    </div>

                                    <div class="padding-v-sm ">
                                        <div class="line line-dashed"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'paper_type_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($dataOptions['paperTypeOptions'], 'paper_type_id', 'paper_type_name'),
                                                'options' => ['placeholder' => 'เลือกกระดาษ'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'templateResult' => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup' => $escape,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('กระดาษ<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6"
                                             style="display: <?= $modelSetting['coating'] ? '' : 'none' ?>">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'coating_option_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($dataOptions['coatingOptions'], 'coating_option_id', 'coating_option_name'),
                                                'options' => ['placeholder' => 'เลือกการเคลือบ'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'templateResult' => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup' => $escape,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('เคลือบ<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                    </div>


                                    <div class="padding-v-sm "
                                         style="display: <?= $modelSetting['dicut'] ? '' : 'none' ?>">
                                        <div class="line line-dashed"></div>
                                    </div>
                                    <div class="row" style="display: <?= $modelSetting['dicut'] ? '' : 'none' ?>">
                                        <div class="col-sm-6">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'dicut_option_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($dataOptions['dicutOptions'], 'dicut_option_id', 'dicut_option_name'),
                                                'options' => [
                                                    'placeholder' => 'เลือกไดคัท',
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'templateResult' => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup' => $escape,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('ไดคัท<span class="text-danger">*</span>')
                                                ->hint(Html::tag('small', 'หากไม่ไดคัท ให้เลือกตัวเลือก "ไม่ไดคัท"'));
                                            ?>
                                        </div>
                                    </div>

                                    <div class="padding-v-sm "
                                         style="display: <?= $modelSetting['fold'] ? '' : 'none' ?>">
                                        <div class="line line-dashed"></div>
                                    </div>
                                    <div class="row" style="display: <?= $modelSetting['fold'] ? '' : 'none' ?>">
                                        <div class="col-sm-6">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'fold_option_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($dataOptions['foldOptions'], 'fold_option_id', 'fold_option_name'),
                                                'options' => ['placeholder' => 'เลือกวิธีพับ'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'templateResult' => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup' => $escape,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('การพับ<span class="text-danger">*</span>')
                                                ->hint(Html::tag('small', 'หากไม่พับ ให้เลือกตัวเลือก "ไม่พับ"'));
                                            ?>
                                        </div>
                                    </div>

                                    <div class="padding-v-sm "
                                         style="display: <?= $modelSetting['foiling'] ? '' : 'none' ?>">
                                        <div class="line line-dashed"></div>
                                    </div>
                                    <span class="label label-info"
                                          style="display: <?= $modelSetting['foiling'] ? '' : 'none' ?>">ฟอยล์</span>
                                    <div class="row" style="display: <?= $modelSetting['foiling'] ? '' : 'none' ?>">
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'foiling_width')->textInput([
                                                'placeholder' => 'ความกว้าง',
                                                'type' => 'number'
                                            ])->label('กว้าง<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'foiling_height')->textInput([
                                                'placeholder' => 'ความสูง',
                                                'type' => 'number'
                                            ])->label('สูง<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'foiling_unit_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TblUnit::find()->asArray()->all(), 'unit_id', 'unit_name'),
                                                'options' => ['placeholder' => 'เลือกหน่วยฟอยล์'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('หน่วย<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'foiling_option_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($dataOptions['foilingOptions'], 'foiling_option_id', 'foiling_option_name'),
                                                'options' => ['placeholder' => 'เลือกสีฟอยล์'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'templateResult' => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup' => $escape,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('สี<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                    </div>

                                    <div class="padding-v-sm "
                                         style="display: <?= $modelSetting['embosser'] ? '' : 'none' ?>">
                                        <div class="line line-dashed"></div>
                                    </div>
                                    <span class="label label-info"
                                          style="display: <?= $modelSetting['embosser'] ? '' : 'none' ?>">ปั๊มนูน</span>
                                    <div class="row" style="display: <?= $modelSetting['embosser'] ? '' : 'none' ?>">
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'embosser_width')->textInput([
                                                'placeholder' => 'กว้าง',
                                                'type' => 'number'
                                            ])->label('ความกว้าง<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'embosser_height')->textInput([
                                                'placeholder' => 'ยาว',
                                                'type' => 'number'
                                            ])->label('ความยาว<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3">
                                            <?php
                                            echo $form->field($modelQuotationDetail, 'embosser_unit_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TblUnit::find()->asArray()->all(), 'unit_id', 'unit_name'),
                                                'options' => ['placeholder' => 'เลือกหน่วย'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'size' => Select2::MEDIUM,
                                            ])->label('หน่วย(ปั๊มนูน)<span class="text-danger">*</span>');
                                            ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= Html::activeHiddenInput($modelQuotationDetail, 'product_id') ?>
                                        </div>
                                    </div>
                                </div><!-- end panel body-->
                                <div class="panel-footer">
                                    <?= $modelProduct['product_description'] ?>
                                </div>
                            </div>


                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <p class="text-center" style="line-height: 15px">
                                <?= Html::img(Yii::getAlias('@web/images/checklist.png'), [
                                    'width' => '50px',
                                    'class' => 'img-responsive center-block',
                                    'style' => 'margin-bottom: 5px;'
                                ]) . '<span class="text-center">รายละเอียด</span>' ?>
                            </p>
                        </div>
                    </div>
                    <div class="panel panel-info product-panel">
                        <!--<div class="panel-heading">
                            <h4 class="panel-title">รายละเอียด</h4>
                        </div>-->
                        <div class="panel-body">
                            <ul class="quotation-detail" style="padding: 0">
                                <li>
                                    <span>ชื่อสินค้า</span>
                                    <span class="float-right"><?= $modelProduct['product_name'] ?></span>
                                </li>
                            </ul>
                            <ul class="quotation-detail" style="font-size: 11px;padding: 0;">
                                <li>
                                    <span>ขนาด</span>
                                    <span class="op_paper_size float-right">-</span>
                                </li>
                                <li>
                                    <span>จำนวน</span>
                                    <span class="op_qty float-right">0</span>
                                </li>
                                <li class="hide">
                                    <span>รูปแบบ</span>
                                    <span class="op_format float-right">-</span>
                                </li>
                                <li>
                                    <span>หน้าแรก</span>
                                    <span class="op_first_page float-right">-</span>
                                </li>
                                <li>
                                    <span>หน้าหลัง</span>
                                    <span class="op_last_page float-right">-</span>
                                </li>
                                <li>
                                    <span>กระดาษ</span>
                                    <span class="op_paper float-right">-</span>
                                </li>
                                <li class="hide">
                                    <span>สี</span>
                                    <span class="op_colors float-right">-</span>
                                </li>
                                <?php if ($modelSetting['dicut']) { ?>
                                    <li>
                                        <span>ไดคัท</span>
                                        <span class="op_dicut float-right">-</span>
                                    </li>
                                <?php } ?>
                                <?php if ($modelSetting['fold']) { ?>
                                    <li>
                                        <span>การพับ</span>
                                        <span class="op_book_binding float-right">-</span>
                                    </li>
                                <?php } ?>
                                <?php if ($modelSetting['coating']) { ?>
                                    <li>
                                        <span>การเคลือบ</span>
                                        <span class="op_refinement float-right">-</span>
                                    </li>
                                <?php } ?>
                                <?php if ($modelSetting['foiling']) { ?>
                                    <li>
                                        <span>ฟอยล์</span>
                                        <span class="op_foiling float-right">-</span>
                                    </li>
                                <?php } ?>
                                <?php if ($modelSetting['embosser']) { ?>
                                    <li>
                                        <span>ปั๊มนูน</span>
                                        <span class="op_embosser float-right">-</span>
                                    </li>
                                <?php } ?>
                                <li class="hide custom_format">
                                    <span>ขนาดกำหนดเอง</span>
                                    <span class="op_custom_format float-right">-</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p>
                        <?= Html::a(($update ? 'แก้ไข' : Icon::show('cart-plus') . 'เพิ่มลงตระกร้า'), 'javascript:void(0);', [
                            'class' => 'btn btn-primary btn-block btn-add-to-cart',
                            'data-loading-text' => ($update ? 'อัพเดทรายการ...' : 'เพิ่มลงตระกร้า...'),
                            'onclick' => ($update ? 'return onSubmit("อัพเดทสินค้าเรียบร้อย");' : 'return onSubmit("เพิ่มสินค้าเรียบร้อย");')
                        ]) ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

<?php
//plugin
$this->registerJsFile(
    '@web/js/waitMe/waitMe.min.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \kidz\assets\KidzAsset::className()
    ]]
);
//Script
$productId = \yii\helpers\Json::encode($modelProduct->product_id);
/*
$this->registerJs(<<<JS
isEmpty = function (v) {
    return v === undefined || v === null || v.length === 0;
};
var formData = {};
var \$form = $("#form-quotation");
//แสดงรายละเอียดสินค้า
previewOptions = function(type, elmId, elmClass, conditionTxt = '') {
    if (type === 'select') {
        var data = $(elmId).select2('data');
        if( !isEmpty($(elmId).val()) && !isEmpty(data[0].text) && data[0].text !== conditionTxt){
            $('span.'+elmClass).html(data[0].text.replace(/<p>(.*)<\/p>/g, ""));
        }else{
            $('span.'+elmClass).html('-');
        }
    } else if (type === 'input'){
        if( !isEmpty($(elmId).val())){
            $('span.'+elmClass).html($(elmId).val());
        }else{
            $('span.'+elmClass).html('-');
        }
    }
};
$('span.desc').hide();
//ขนาด
jQuery('#tblquotationdetail-paper_size_id').on('change', function() {
    var data = $(this).select2('data');
    var w = $('#tblquotationdetail-custom_paper_width');
    var h = $('#tblquotationdetail-custom_paper_height');
    //previewOptions('select', '#' + $(this)[0].id, 'op_paper_size', 'เลือกขนาด');
    if( !isEmpty($(this).val()) && !isEmpty(data[0].text) && data[0].text !== 'เลือกขนาด'){
        if ($(this).val() === 'custom_size') {
            $('span.op_paper_size').html('-');
            $('.custom-paper-size').show();
        } else {
            w.val(null);
            h.val(null);
            $('#tblquotationdetail-custom_paper_unit').val(null).trigger('change');
            $('.custom-paper-size').hide();
        }
        if ($(this).val() !== 'custom_size') {
            $('span.op_paper_size').html(data[0].text.replace(/<p>(.*)<\/p>/g, ""));
        }
    }
    if( isEmpty($(this).val())){
        w.val(null);
        h.val(null);
        $('#tblquotationdetail-custom_paper_unit').val(null).trigger('change');
        $('.custom-paper-size').hide();
        $('span.op_paper_size').html('-');
    }
});
//จำนวน
jQuery('#tblquotationdetail-quotation_qty').on('change keyup',function() {
    previewOptions('input', '#' + $(this)[0].id, 'op_qty');
});
//รูปแบบ
jQuery('#tblquotationdetail-print_option_id').on('change', function() {
    previewOptions('select', '#' + $(this)[0].id, 'op_format', 'เลือกแบบการพิมพ์');
});
//ประเภทกระดาษ
jQuery('#tblquotationdetail-paper_type_id').on('change', function() {
    previewOptions('select', '#' + $(this)[0].id, 'op_paper', 'เลือกประเภทกระดาษ');
});
//เคลือบ
jQuery('#tblquotationdetail-coating_option_id').on('change', function() {
    previewOptions('select', '#' + $(this)[0].id, 'op_refinement', 'เลือกการเคลือบ');
});
//ไดคัท
jQuery('#tblquotationdetail-dicut_option_id').on('change', function() {
    previewOptions('select', '#' + $(this)[0].id, 'op_dicut', 'เลือกไดคัท');
});
//การพับ
jQuery('#tblquotationdetail-fold_option_id').on('change', function() {
    previewOptions('select', '#' + $(this)[0].id, 'op_book_binding', 'เลือกวิธีพับ');
});
//ขนาดฟอยล์
jQuery('#tblquotationdetail-foiling_size').on('change keyup',function() {
    var dataColor = $('#tblquotationdetail-foiling_option_id').select2('data'),
        dataUnit = $('#tblquotationdetail-foiling_unit_id').select2('data'),
        txt = '-';
    if( !isEmpty($(this).val())){
        if (dataColor[0].text !== 'เลือกสีฟอยล์' && dataUnit[0].text !== 'เลือกหน่วยฟอยล์') {
            txt = 'ขนาด ' + $(this).val() + 
            '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "") + 
            ',&nbsp;' + dataColor[0].text.replace(/<p>(.*)<\/p>/g, "");
        } else {
            txt = 'ขนาด ' + $(this).val();
        }
    }
    $('span.op_foiling').html(txt);
});
//หน่วยฟอยล์
jQuery('#tblquotationdetail-foiling_unit_id').on('change', function() {
    var data = $(this).select2('data'),
        dataColor = $('#tblquotationdetail-foiling_option_id').select2('data'),
        foiSize = $('#tblquotationdetail-foiling_size').val(),
        txt = '-';
    if( !isEmpty($(this).val()) && !isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วยฟอยล์'){
        if (dataColor[0].text !== 'เลือกสีฟอยล์') {//ถ้าเลือกสีฟอยล์
            txt = 'ขนาด ' + foiSize + 
            '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "") + 
            ',&nbsp;' + dataColor[0].text.replace(/<p>(.*)<\/p>/g, "");
        } else {
            txt = 'ขนาด ' + foiSize + 
            '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        }
        $('span.op_foiling').html(txt);
    }else{
        if(!isEmpty(dataColor[0].text) && dataColor[0].text !== 'เลือกสีฟอยล์'){//ถ้าเลือกสีฟอยล์
            txt = 'ขนาด ' + foiSize +
            ',&nbsp;' + dataColor[0].text.replace(/<p>(.*)<\/p>/g, "");
            $('span.op_foiling').html(txt);
        }else{
            $('span.op_foiling').html('ขนาด ' + foiSize);
        }
    }
});
//สีฟอยล์
jQuery('#tblquotationdetail-foiling_option_id').on('change', function() {
    var data = $(this).select2('data'),
        foiSize = $('#tblquotationdetail-foiling_size').val(),
        dataUnit = $('#tblquotationdetail-foiling_unit_id').select2('data'),
        txt = '-';
    if( !isEmpty($(this).val()) && !isEmpty(data[0].text) && data[0].text !== 'เลือกสีฟอยล์'){
        
        if (dataUnit[0].text !== 'เลือกหน่วยฟอยล์') {
            txt = 'ขนาด ' + foiSize + 
            '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "") + 
            ',&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        } else {
            txt = 'ขนาด ' + foiSize + 
            '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        }
        $('span.op_foiling').html(txt);
    }else{
        if(!isEmpty(dataUnit[0].text) && dataUnit[0].text !== 'เลือกหน่วยฟอยล์'){//ถ้าเลือกหน่วยฟอยล์
            txt = 'ขนาด ' + foiSize + 
            '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "");
            $('span.op_foiling').html(txt);
        }else{
            $('span.op_foiling').html('ขนาด ' + foiSize);
        }
    }
});
//ปั๊มนูน
jQuery('#tblquotationdetail-embosser').on('change keyup',function() {
    var dataUnit = $('#tblquotationdetail-embosser_unit_id').select2('data'),
        txt = '-';
    if( !isEmpty($(this).val())){
        if (dataUnit[0].text !== 'เลือกหน่วย') {
            txt = 'ขนาด ' + $(this).val() + 
            '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "");
        } else {
            txt = 'ขนาด ' + $(this).val();
        }
    }
    $('span.op_embosser').html(txt);
});
//หน่วยปั๊มนูน
jQuery('#tblquotationdetail-embosser_unit_id').on('change', function() {
    var data = $(this).select2('data'),
        txt = '-';
    if( !isEmpty($(this).val()) && !isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วย'){
        txt = 'ขนาด ' + $('#tblquotationdetail-embosser').val() + 
            '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
    }else{
        txt = 'ขนาด ' + $('#tblquotationdetail-embosser').val();
    }
    $('span.op_embosser').html(txt);
});
//กว้าง
jQuery('#tblquotationdetail-custom_paper_width').on('change keyup',function() {
    var data = $('#tblquotationdetail-custom_paper_unit').select2('data');
    var w = $(this).val();
    var h = $('#tblquotationdetail-custom_paper_height').val();
    if( !isEmpty(w) && !isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วย'){
        var txt = w +'*'+ h + '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        $('span.op_paper_size').html(txt);
    }else if( !isEmpty(w) ){
        var txt = w +'*'+ h;
        $('span.op_paper_size').html(txt);
    }
});

//หน่วยปั๊มนูน
jQuery('#tblquotationdetail-custom_paper_unit').on('change', function() {
    var data = $(this).select2('data');
    var w = $('#tblquotationdetail-custom_paper_width').val();
    var h = $('#tblquotationdetail-custom_paper_height').val();
    if( !isEmpty($(this).val()) && !isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วย'){
        var txt = w +'*'+ h + '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        $('span.op_paper_size').html(txt);
    }else{
        var txt = w +'*'+ h;
        $('span.op_paper_size').html(txt);
    }
});

//สูง
jQuery('#tblquotationdetail-custom_paper_height').on('change keyup',function() {
    var data = $('#tblquotationdetail-custom_paper_unit').select2('data');
    var h = $(this).val();
    var w = $('#tblquotationdetail-custom_paper_width').val();
    if( !isEmpty(w) && !isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วย'){
        var txt = w +'*'+ h + '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        $('span.op_paper_size').html(txt);
    }else if( !isEmpty(w) ){
        var txt = w +'*'+ h;
        $('span.op_paper_size').html(txt);
    }
});

\$form.on('change', function() {
    var obj = {};
    \$form.serializeArray().map(function(x){
        obj[x.name.replace('TblQuotationDetail[', '').replace(']', '')] = x.value;
    });
    formData[$productId] = obj;
    if ('localStorage' in window && window.localStorage !== null) {
        var cacheData = localStorage.getItem('productOptions');
        if (!isEmpty(cacheData)){
            var options = $.extend(JSON.parse(cacheData), formData);
            localStorage.setItem('productOptions', JSON.stringify(options));
        } else {
            localStorage.setItem('productOptions', JSON.stringify(formData));
        }
    }
});

$(window).on('load', function(){
    if ('localStorage' in window && window.localStorage !== null) {
        var productOps = localStorage.getItem('productOptions');
        if (!isEmpty(productOps) && !isEmpty(JSON.parse(productOps))) {
            var dataObj = JSON.parse(productOps);
            if (!isEmpty(dataObj[{$productId}])){
                productOps =  dataObj[{$productId}];
                
                //หน่วย (กำหนดเอง)
                $('#tblquotationdetail-custom_paper_unit').val(productOps['custom_paper_unit']).trigger('change');
                //จำนวน
                $('#tblquotationdetail-quotation_qty').val(productOps['quotation_qty']).change();
                //รูปแบบ
                $('#tblquotationdetail-print_option_id').val(productOps['print_option_id']).trigger('change');
                //กระดาษ
                $('#tblquotationdetail-paper_type_id').val(productOps['paper_type_id']).trigger('change');
                //เคลือบ
                $('#tblquotationdetail-coating_option_id').val(productOps['coating_option_id']).trigger('change');
                //ไดคัท
                $('#tblquotationdetail-dicut_option_id').val(productOps['dicut_option_id']).trigger('change');
                //การพับ
                $('#tblquotationdetail-fold_option_id').val(productOps['fold_option_id']).trigger('change');
                //ขนาดฟอยล์
                $('#tblquotationdetail-foiling_size').val(productOps['foiling_size']).change();
                //หน่วยฟอยล์
                $('#tblquotationdetail-foiling_unit_id').val(productOps['foiling_unit_id']).trigger('change');
                //สีฟอยล์
                $('#tblquotationdetail-foiling_option_id').val(productOps['foiling_option_id']).trigger('change');
                //ขนาดปั๊มนูน
                $('#tblquotationdetail-embosser').val(productOps['embosser']).change();
                //หน่วยปั๊มนูน
                $('#tblquotationdetail-embosser_unit_id').val(productOps['embosser_unit_id']).trigger('change');
                //ขนาด
                $('#tblquotationdetail-paper_size_id').val(productOps['paper_size_id']).trigger('change');
                //กำหนดขนาดเอง
                if (productOps['paper_size_id'] === 'custom_size'){
                    $('.custom-paper-size').show();
                }else{
                    $('.custom-paper-size').hide();
                }
                //กว้าง กำหนดขนาดเอง
                $('#tblquotationdetail-custom_paper_width').val(productOps['custom_paper_width']).change();
                //สูง กำหนดขนาดเอง
                $('#tblquotationdetail-custom_paper_height').val(productOps['custom_paper_height']).change();
                $('span.desc').hide();
            }
        }
    }
}); 

$('button.custom-paper-size').on('click', function() {
    var data = {
        id: 1,
        text: 'Barn owl'
    };
    
    var newOption = new Option(data.text, data.id, false, false);
    $('#tblquotationdetail-paper_size_id').append(newOption).trigger('change');
    $('#tblquotationdetail-paper_size_id').val(data.id).trigger('change');
});

onSubmit = function(title = '') {
    var data = \$form.serialize();
    var \$btn = $('.btn-add-to-cart').button('loading');
    $.ajax({
        url: '/product/add-to-cart',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {
            \$btn.button('reset');
            // Implement successful
            if (response.success) {
                $('span.header-cart').html(response.count);
                localStorage.removeItem('productOptions');
                Swal({
                    title: title,
                    text: "",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'เลือกสินค้าต่อ',
                    cancelButtonText: 'ไปยังตระกร้าสินค้า'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '/product/index';
                    }else{
                        window.location.href = '/product/cart';
                    }
                });
            } else {
                Swal({
                    type: 'error',
                    title: 'Oops!',
                    text: 'กรุณากรอกข้อมูลให้ครบ',
                });
                $.each(response.validate, function (key, val) {
                    $(\$form).yiiActiveForm('updateAttribute', key, [val]);
                });
                //$("html, body").animate({scrollTop: 0}, "slow");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            \$btn.button('reset');
            Swal({
                type: 'error',
                title: textStatus,
                text: errorThrown,
            });
        }
    });
}
if ('localStorage' in window && window.localStorage !== null) {
    if (isEmpty(localStorage.getItem('productOptions'))) {
        \$form.trigger("change");
    }
}
JS
);
*/
$this->registerJs(<<<JS
var \$form = $("#form-quotation");
onSubmit = function (title = '') {
    var data = \$form.serialize();
    var \$btn = $('.btn-add-to-cart').button('loading');
    $.ajax({
        url: '/product/add-to-cart',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {
            \$btn.button('reset');
            // Implement successful
            if (response.success) {
                $('span.header-cart').html(response.count);
                localStorage.removeItem('productOptions');
                Swal({
                    title: title,
                    text: "",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'เลือกสินค้าต่อ',
                    cancelButtonText: 'ไปยังตระกร้าสินค้า'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '/product/index';
                    } else {
                        window.location.href = '/product/cart';
                    }
                });
            } else {
                Swal({
                    type: 'error',
                    title: 'Oops!',
                    text: 'กรุณากรอกข้อมูลให้ครบ',
                });
                $.each(response.validate, function (key, val) {
                    $(\$form).yiiActiveForm('updateAttribute', key, [val]);
                });
                //$("html, body").animate({scrollTop: 0}, "slow");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            \$btn.button('reset');
            Swal({
                type: 'error',
                title: textStatus,
                text: errorThrown,
            });
        }
    });
}
$('span.desc').hide();
JS
);
$this->registerJsFile(
    '@web/js/quotation.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>