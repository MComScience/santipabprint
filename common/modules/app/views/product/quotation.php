<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/1/2562
 * Time: 9:19
 */

use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Json;
use kartik\form\ActiveForm;
use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

$this->title = $modelProduct['product_name'];

//style
$styles = [
    '@web/js/waitMe/waitMe.min.css',
    '@web/css/quotation.css',
    '@web/css/checkbox-style.css'
];
foreach ($styles as $style) {
    $this->registerCssFile($style, [
        'depends' => [
            \yii\bootstrap\BootstrapAsset::className(),
            \kidz\assets\KidzAsset::className(),
            \frontend\assets\AppAsset::className()
        ],
    ]);
}
?>
<div id="preloader" class="smooth-loader-wrapper">
    <div class="smooth-loader">
        <div class="loader">
            <span class="dot dot-1"></span>
            <span class="dot dot-2"></span>
            <span class="dot dot-3"></span>
            <span class="dot dot-4"></span>
        </div>
    </div>
</div>
<section class="whiteSection full-width clearfix qoutationSection" style="padding: 20px 0;">
    <div class="container">

        <!-- Section Title -->
        <div class="sectionTitle text-center">
            <h2 class="wow" style="margin-bottom: 5px;">
                <span class="shape shape-left bg-color-4"></span>
                <span>
                    <?= $modelProduct['product_name']; ?>
                </span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
        </div>
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-quotation']); ?>
        <div class="row">
            <div class="col-md-7 col-lg-8 order-1 order-md-0">
                <!-- Icon -->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <?=
                        Html::img(Yii::getAlias('@web/images/document.png'), [
                            'width' => '50px',
                            'class' => 'img-responsive center-block'
                        ]) . Html::tag('p', 'กำหนดหมวดหมู่งานพิมพ์', ['class' => 'text-center'])
                        ?>
                    </div>
                </div>
                <!-- End Icon -->
                <!-- Form -->
                <div class="tab-content product-content" id="panel-container">
                    <div role="tabpanel" class="tab-pane active" id="tab-form">
                        <?= $this->render('_form', [
                            'option' => $option,
                            'modelProduct' => $modelProduct,
                            'modelQuotation' => $modelQuotation,
                            'model' => $model,
                            'queryBuilder' => $queryBuilder,
                            'form' => $form
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-4">
                <!-- Icon -->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <p class="text-center" style="line-height: 15px">
                            <?= Html::img(Yii::getAlias('@web/images/checklist.png'), [
                                'width' => '50px',
                                'class' => 'img-responsive center-block',
                                'style' => 'margin-bottom: 5px;'
                            ]) . Html::tag('span', 'รายละเอียด', ['class' => 'text-center']) ?>
                        </p>
                    </div>
                </div>
                <!-- Panel -->
                <div class="panel panel-info product-panel">
                    <div class="panel-body">
                        <?= $this->render('_quotation-details', [
                            'option' => $option,
                            'modelProduct' => $modelProduct,
                            'modelQuotation' => $modelQuotation,
                            'model' => $model,
                            'queryBuilder' => $queryBuilder
                        ]); ?>
                    </div>
                </div>
                <p>
                    <?= Html::submitButton(($update ? 'แก้ไข' : Icon::show('cart-plus') . 'เพิ่มลงตระกร้า'), [
                        'class' => 'btn btn-primary btn-block btn-add-to-cart',
                        'data-loading-text' => ($update ? 'อัพเดทรายการ...' : 'เพิ่มลงตระกร้า...'),
                        //'onclick' => ($update ? 'return onSubmit("อัพเดทสินค้าเรียบร้อย");' : 'return onSubmit("เพิ่มสินค้าเรียบร้อย");')
                    ]) ?>
                    <?= Html::a(Icon::show('file-text-o') . 'ใบเสนอราคา', ['/app/product/download','p' => $modelProduct['product_id']], [
                        'class' => 'btn btn-info btn-block',
                        'id' => 'btn-download-quotation',
                        'role' => 'modal-remote'
                        //'onclick' => 'return DownloadQO();'
                    ]) ?>
                </p>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>
<?php
$this->registerJsFile(
    '@web/js/waitMe/waitMe.min.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \kidz\assets\KidzAsset::className()
    ]]
);
$this->registerJsFile(
    '@web/js/quo-print.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \kidz\assets\KidzAsset::className()
    ]]
);
$this->registerJs(<<<JS
var \$form = $("#form-quotation");
onSubmit = function() {
    \$form.yiiActiveForm('validate', true);
};
DownloadQO = function() {
    var data = \$form.serialize(), \$btn = $('#btn-download-quotation').button('loading');
    $.ajax({
        url: \$form.attr('action'),
        type: \$form.attr('method'),
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
};
/*
getInput = function (name, value) {
    return $('<textarea/>', {'name': name}).val(value).hide();
};
Download = function () {
    var yiiLib = window.yii, dataObj = {}, \$csrf, \$input = \$form.find('input, select');
    \$form.serializeArray().map(function (f) {
        dataObj[f.name] = f.value;
    });
    \$csrf = yiiLib ? getInput(yiiLib.getCsrfParam() || '_csrf', yiiLib.getCsrfToken() || null) : null;
    
    var \$f = $('<form/>', {
        'action': '/app/product/download',
        'target': '_popup',//'_self',
        'method': 'post',
        css: {'display': 'none'}
    }).append(\$csrf)
        .append(getInput('data', JSON.stringify(dataObj)))
        .appendTo('body')
        .submit()
        .remove();
}*/
\$form.on('beforeSubmit', function() {
    var data = \$form.serialize();
    return false; // prevent default submit
});
JS
);
foreach ($validates as $validate) {
    $this->registerJs("\$form.yiiActiveForm('add'," . Json::encode($validate) . ");");
}
?>
