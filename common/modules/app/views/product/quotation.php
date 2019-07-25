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
    '@web/bundle/waitMe.css',
    '@web/bundle/quotation.css',
    '@web/bundle/checkboxStyle.css'
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
$this->registerCss(<<<CSS
.icon-container {
    margin: 10px;
    display: inline-block;
}
.list-item-content {
    margin: 10px;
    display: inline-block;
}
.list-price-content {
    display: inline-block;
    float: right;
    margin: 21px 10px;
    font-weight: 700;
}
.list-price-content h4 {
    display: inline-block;
    margin-right: 10px;
    margin-top: 5px;
}
.list-price-content i {
    display: inline-block;
    float: right;
}
.list-group-item {
    cursor: pointer;
}
/* .list-group a:hover {
    background-color: #3ecdf1;
    color: #fff;
} */
/* .list-group a:hover h3, .list-group a:hover h4, .list-group a:hover p {
    color: #fff;
} */
.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
    background-color: #9cd584 !important;
    color: #fff !important;
    border-color: #9cd584;
}
.list-group a:focus h3, .list-group a:focus h4, .list-group a:focus p {
    color: #fff !important;
}
.list-group-item.active h3, .list-group-item.active:focus h3, .list-group-item.active:hover h3,
.list-group-item.active h4, .list-group-item.active:focus h4, .list-group-item.active:hover h4,
.list-group-item.active p, .list-group-item.active:focus p, .list-group-item.active:hover p {
    color: #fff !important;
}
.on-remove-item {
    color: #ef694b !important;
}
/* Small devices (tablets, 768px and up) */
@media (max-width: 768px) {
    .quotation-detail {
        font-size: 20px !important;
    }
    .control-label, .select2-container--bootstrap .select2-selection {
        font-size: 18px !important;
    }
    .select2-container--bootstrap .select2-dropdown {
        font-size: 16px !important;
    }
    ul.quotation-detail li {
        margin-bottom: 10px !important;
    }
}
CSS
);
?>
<!--<div id="preloader" class="smooth-loader-wrapper">
    <div class="smooth-loader">
        <div class="loader">
            <span class="dot dot-1"></span>
            <span class="dot dot-2"></span>
            <span class="dot dot-3"></span>
            <span class="dot dot-4"></span>
        </div>
    </div>
</div>-->
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
            <ol class="breadcrumb">
                <li>
                    <?= Html::a(Icon::show('file-text-o').' ขอใบเสนอราคา',['/app/product/index']); ?>
                </li>
                <li class="active"><?= $modelProduct['product_name'] ?></li>
            </ol>
        </div>
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-quotation']); ?>
        <div class="row" id="form-container">
            <div class="col-md-7 col-lg-8 order-1 order-md-0">
                <!-- Icon -->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <?=
                        Html::img(Yii::getAlias('@web/images/document.png'), [
                            'width' => '50px',
                            'class' => 'img-responsive center-block'
                        ]) . Html::tag('p', 'กำหนดรายละเอียด', ['class' => 'text-center'])
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
                    <?php /*
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
                    */?>
                    <?= Html::a('ขั้นตอนถัดไป '.Icon::show('angle-right'), 'javascript:void(0);', [
                        'class' => 'btn btn-info btn-block',
                        'onclick' => 'return nextStepOne();'
                    ]); ?>
                    <?php 
                    /*
                        if(Yii::$app->user->can('admin')) {
                            echo Html::a(Icon::show('plus').'เพิ่มไปยัง Catalog', 'javascript:void(0);', [
                                'class' => 'btn btn-primary btn-block',
                                'onclick' => 'return onAddtoCatalog();'
                            ]); 
                        }
                        */
                    ?>
                </p>
            </div>
        </div>
        

        <div class="row">
            <div class="col-md-5 col-lg-4 col-md-offset-4 preview-detail" style="display: none;">
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
                <div id="preview-detail"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 list-group-price" style="display: none;">
                <div class="alert alert-info" role="alert">
                    Notice! เลือกจำนวนที่ต้องการพิมพ์โดยกดที่เครื่องหมายถูก <i class="fa fa-check-circle-o fa-2x"></i>
                </div>
                <ul class="list-group">
                    
                </ul>
            </div>
        </div>

        <div class="row list-group-price" style="display: none;">
            <div class="col-xs-4">
                <?php
                    echo $form->field($model, 'cust_quantity')->textInput([
                        'type' => 'tel',
                        'min' => 1,
                        'placeholder' => 'จำนวน'
                    ])->label('เพิ่มจำนวนอื่นๆ');
                ?>
            </div>
            <div class="col-xs-4">
                <p style="margin-top: 25px;">
                    <?= Html::a('<i class="fa fa-plus"></i>', 'javascript:void(0);', [
                        'class' => 'btn btn-primary btn-sm',
                        'onclick' => 'return onAddQty();'
                    ]) ?>
                </p>
            </div>
            <div class="col-xs-4">
                <?php
                echo Html::activeHiddenInput($model, 'final_price');
                ?>
            </div>
        </div>

        <div class="row list-group-price" style="display: none;">
            <div class="col-xs-6">
                <p>
                    <?= Html::a('<i class="fa fa-angle-left"></i> ขั้นตอนก่อนหน้า', 'javascript:void(0);', [
                        'class' => 'btn btn-info btn-block',
                        'onclick' => 'return onPrevious();'
                    ]) ?>
                </p>
            </div>
            <div class="col-xs-6">
                <p>
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
    '@web/bundle/waitMe.js',
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
                    cancelButtonText: 'ไปยังตระกร้าสินค้า',
                    heightAuto: false
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
                heightAuto: false
            });
        }
    });
};

onPrevious = function() {
    $(".list-group").find('a.active').removeClass('active');
    $('#form-container').show();
    $( "#preview-detail" ).html("").hide();
    $('.list-group-price, .preview-detail').hide();
    $("html, body").animate({ scrollTop: $("#form-quotation").offset().top }, "slow");
}

nextStepOne = function() {
    \$form.yiiActiveForm('validate', true);
    Swal.fire({
        type: 'warning',
        title: 'รอสักครู่...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        showCancelButton: false,
        animation: false,
        onBeforeOpen: () => {
            Swal.showLoading()
        },
    });
    setTimeout(function(){
        if(\$form.find('.has-error').length === 0) {
            $(".list-group").find('a.active').removeClass('active');
            $('#form-container').hide();
            $( "#preview-detail" ).html($('.product-panel').clone()).show();
            $('.list-group-price, .preview-detail').show();
            Calculate();
            $("html, body").animate({ scrollTop: $(".list-group-price").offset().top }, "slow");
            /* Swal({
                type: 'warning',
                title: 'ระบุจำนวนที่ต้องการพิมพ์',
                text: '',
                allowOutsideClick: false,
                allowEscapeKey: false,
                input: 'text',
                inputValue: '',
                showCancelButton: false,
                inputValidator: (value) => {
                    if (!value) {
                        return 'กรุณาระบุจำนวน!'
                    }
                }
            }).then((result) => {
                if (result.value) {
                    console.log(result.value)
                }
            }); */
        } else {
            Swal({
                type: 'warning',
                title: 'กรุณาระบุข้อมูลให้ครบ!',
                text: '',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    },500);
}

onAddQty = function() {
    var \$items = $('.list-group').find('.list-group-item');
    var qty = [];
    var isDuplicate = false;
    \$items.each(function( i,v ) {
        if($(this).data('qty') == $('#tblquotationdetail-cust_quantity').val()){
            isDuplicate = true;
        } else {
            qty.push($(this).data('qty'));
        }
    });
    if(!isDuplicate){
        qty.push($('#tblquotationdetail-cust_quantity').val());
        Calculate(qty);
    }
}

handleClickItem = function() {
    $("a.list-group-item").on('click', function(){
        $(".list-group").find('a.active').removeClass('active');
        $(this).toggleClass('active');
    });
    $('.on-remove-item').on('click', function() {
        $(this).closest( "a" ).remove()
    });
}
handleClickItem();

Calculate = function(qty = []) {
    var data = \$form.serialize();
    var formData = { };
    $.each(\$form.serializeArray(), function() {
        formData[this.name] = this.value;
    });
    $.ajax({
        url: '/product/calculate-price',
        type: \$form.attr('method'),
        data: Object.assign(formData, {qty: qty}),
        dataType: 'json',
        success: function (response) {
            $('.list-group-item').remove();
            $.each(response, function (key, item) {
                $('.list-group').append(`<a href="javascript:void(0);" class="list-group-item" data-qty="\${item.cust_quantity}" data-final_price="\${item.final_price}" id="a-\${key}">
                    <div class="icon-container">
                        <i class="fa fa-check-circle-o fa-2x"></i>
                    </div>
                    <div class="list-item-content">
                        <h3>\${item.cust_quantity} ชิ้น</h3>
                        <p>\${item.price_per_item} THB ต่อชิ้น</p>
                    </div>
                    <div class="list-price-content">
                        <h4>\${item.final_price} THB</h4>
                        <i class="fa fa-times-circle-o fa-2x on-remove-item" data-id="a-\${key}"></i>
                    </div>
                </a>`);
            });
            handleClickItem();
            Swal.close();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal({
                type: 'error',
                title: textStatus,
                text: errorThrown,
            });
        }
    });
}

onAddtoCatalog = function () {
    var data = \$form.serialize();
    swal({
        title: 'ยืนยัน',
        text: '',
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    method: "POST",
                    url: '/product/add-to-catalog',
                    dataType: "json",
                    data: data,
                    success: function (response) {
                        if(response.isSuccess) {
                            Swal({
                                type: 'success',
                                title: 'เพิ่มลง Catalog เรียบร้อย!',
                                text: '',
                            });
                        } else {
                            Swal({
                                type: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: '',
                            });
                            console.error(response);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal({
                            type: 'error',
                            title: textStatus,
                            text: errorThrown,
                        });
                    }
                });
            });
        },
    }).then((result) => {
        if (result.value) { //Confirm
            swal.close();
        }
    });
}
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
