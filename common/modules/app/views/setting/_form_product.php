<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 20:40
 */

use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Tabs;
use common\modules\app\models\TblProductCategory;
use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

$this->title = 'บันทึกสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/app/setting/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/checkbox-style.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$template = $template = Html::beginTag('div', ['class' => 'checkbox']) . Html::beginTag('label');
$template .= "{input}\n";
$template .= Html::tag('span', Icon::show('ok', ['framework' => Icon::BSG, 'class' => 'cr-icon']), ['class' => 'cr']);
$template .= "{label}\n";
$template .= Html::endTag('label') . Html::endTag('div') . "\n{error}\n{hint}";
$this->registerCss(<<<CSS
.padding-v-sm {
     padding-top: 0px;
     padding-bottom: 10px;
 }

.line-dashed {
    background-color: transparent;
    border-bottom: 1px dashed #dee5e7 !important;
}
#form-product .checkbox label, #form-product input.form-control {
    font-size: 12px;
}
CSS
);
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-product']); ?>
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
            <div class="col-sm-5">
                <?= $form->field($model, 'icon')->widget(Upload::classname(), [
                    'url' => ['upload-icon'],
                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                    'id' => 'product-icon'
                ]); ?>
            </div>
            <div class="col-sm-7">
                <?= $form->field($model, 'files')->widget(Upload::className(), [
                    'url' => ['upload-file'],
                    'maxFileSize' => 100 * 1024 * 1024, // 10 MiB
                    'maxNumberOfFiles' => 20,
                    //'sortable' => true,
                    'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                    'id' => 'files-uploads'
                ])->hint('<span class="text-danger">**ขนาดไฟล์: ไม่เกิน 10MB/ไฟล์</span> ,ชนิดไฟล์: gif, jpeg, png')->label('ภาพตัวอย่างสินค้า'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-12">
                <?= $form->field($model, 'product_category_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TblProductCategory::find()->asArray()->all(), 'product_category_id', 'product_category_name'),
                    'options' => ['placeholder' => 'เลือกหมวดหมู่'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                ]); ?>

                <?= $form->field($model, 'product_name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'ชื่อสินค้า'
                ]) ?>
                <p>
                    <span class="badge badge-primary">กำหนดตัวเลือก</span>
                </p>
                <p>
                    <small>
                        <em class="text-info">
                            เป็นการกำหนดตัวเลือกเพื่อที่จะนำไปแสดงบนฟอร์มกรอกข้อมูลใบเสนอราคา
                        </em>

                    </small>
                <ul class="list-unstyled">
                    <li>
                        <ul>
                            <li>
                                <code>"Required" หมายถึง บังคับให้ลูกค้าเลือกตัวเลือกนั้นๆ หรือกรอกข้อมูลนั้นๆ </code>
                            </li>
                        </ul>
                    </li>
                </ul>
                </p>
                <?php foreach ($attributes as $attr => $item): ?>
                    <div class="row">
                        <div class="col-md-4">
                            <?php if ($attr === 'land_orient') {
                                echo Html::tag('p', Html::tag('code', 'สำหรับปฏิทิน'));
                            } ?>
                            <div class="checkbox">
                                <label for="<?= "options-$attr-value"; ?>">
                                    <?php
                                    $value = $model->getOptionValue($attr, 'value', '');
                                    echo Html::input('hidden', "Options[$attr][value]", 0, []);
                                    echo Html::checkbox("Options[$attr][value]", (empty($value) ? false : true), [
                                        'value' => empty($value) ? 1 : $value,
                                        'id' => "options-$attr-value",
                                        'class' => 'checkbox-option',
                                        'data-clicked' => "tab-$attr"
                                    ]);
                                    ?>
                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                    <?= $modelOption->getAttributeLabel($attr) ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php if (ArrayHelper::isIn($attr, ['land_orient'])) {
                                echo '<br>';
                            } ?>
                            <?php
                            echo Html::input('text', "Options[$attr][label]", $model->getOptionValue($attr, 'label', $modelOption->getAttributeLabel($attr)), [
                                'class' => 'form-control'
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php if (ArrayHelper::isIn($attr, ['land_orient'])) {
                                echo '<br>';
                            } ?>
                            <div class="checkbox">
                                <label for="<?= "options-$attr-required"; ?>">
                                    <?php
                                    $value = $model->getOptionValue($attr, 'required', '');
                                    echo Html::input('hidden', "Options[$attr][required]", 0, []);
                                    echo Html::checkbox("Options[$attr][required]", (empty($value) ? false : true), [
                                        'value' => empty($value) ? 1 : $value,
                                        'id' => "options-$attr-required"
                                    ]) ?>
                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                    <?= $modelOption->getAttributeLabel('required') ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="padding-v-sm ">
                        <div class="line line-dashed"></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-sm-6 col-sm-12">
                <?= $form->field($model, 'product_description')->widget(\yii\redactor\widgets\Redactor::className(), [
                    'clientOptions' => [
                        'plugins' => ['clips', 'fontcolor', 'imagemanager']
                    ]
                ]) ?>
                <p>
                    <span class="badge badge-primary">
                        ข้อมูลทั่วไป
                    </span>
                </p>
                <p>
                    <small>
                        <em class="text-info">
                            กำหนดตัวเลือกข้อมูลสินค้า
                        </em>
                    </small>
                </p>
                <div class="nav-tabs-custom">
                    <?php
                    echo Tabs::widget([
                        'items' => [
                            [
                                'label' => 'ขนาด',
                                'active' => true,
                                'options' => ['id' => 'tab-paper-size'],
                                'headerOptions' => ['class' => 'tab-paper-size']
                            ],
                            [
                                'label' => 'หน้าพิมพ์',
                                'options' => ['id' => 'tab-before-print'],
                                'headerOptions' => ['class' => 'tab-before_print']
                            ],
                            [
                                'label' => 'หลังพิมพ์',
                                'options' => ['id' => 'tab-after-print'],
                                'headerOptions' => ['class' => 'tab-after_print']
                            ],
                            [
                                'label' => 'กระดาษ',
                                'options' => ['id' => 'tab-paper'],
                                'headerOptions' => ['class' => 'tab-paper']
                            ],
                            [
                                'label' => 'เคลือบ',
                                'options' => ['id' => 'tab-coating'],
                                'headerOptions' => ['class' => 'tab-coating_id']
                            ],
                            [
                                'label' => 'ไดคัท',
                                'options' => ['id' => 'tab-diecut'],
                                'headerOptions' => ['class' => 'tab-diecut_id']
                            ],
                            [
                                'label' => 'อื่นๆ',
                                'items' => [
                                    [
                                        'label' => 'วิธีพับ',
                                        'url' => '#tab-fold',
                                        'linkOptions' => ['data-toggle' => 'tab'],
                                        'options' => ['class' => 'tab-fold_id']
                                    ],
                                    [
                                        'label' => 'สีฟอยล์',
                                        'url' => '#tab-foil-color',
                                        'linkOptions' => ['data-toggle' => 'tab'],
                                        'options' => ['class' => 'tab-foil_color_id']
                                    ],
                                    [
                                        'label' => 'วิธีเข้าเล่ม',
                                        'url' => '#tab-book-binding',
                                        'linkOptions' => ['data-toggle' => 'tab'],
                                        'options' => ['class' => 'tab-book_binding_id']
                                    ],
                                    [
                                        'label' => 'พิมพ์หน้าหลัง',
                                        'url' => '#tab-page-option1',
                                        'linkOptions' => ['data-toggle' => 'tab'],
                                        'options' => ['class' => 'tab-page-option1']
                                    ],
                                    [
                                        'label' => 'พิมพ์หน้าเดียว',
                                        'url' => '#tab-page-option2',
                                        'linkOptions' => ['data-toggle' => 'tab'],
                                        'options' => ['class' => 'tab-page-option2']
                                    ],
                                ],
                            ],
                        ],
                        'renderTabContent' => false,
                        'encodeLabels' => false,
                    ]);
                    ?>
                    <?= $this->render('_tab_content', [
                        'modelProduct' => $model,
                        'gridBuilder' => $gridBuilder
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 border-right">

            </div>
            <div class="col-md-6 col-sm-12">

            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="row">
            <div class="col-sm-12 text-right">
                <?= Html::a(Icon::show('close') . 'กลับ', ['product'], [
                    'class' => 'btn btn-default',
                ]) ?>
                <?= Html::submitButton(Icon::show('save') . 'บันทึก', [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$this->registerJsFile(
    '@web/js/product-setting.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
