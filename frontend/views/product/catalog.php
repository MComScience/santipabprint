<?php
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Json;
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
$this->registerJs('var options = '. Json::encode($model). ';', View::POS_HEAD);
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
         <!-- Panel -->
         <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <p class="text-center" style="line-height: 15px">
                            <?= Html::img(Yii::getAlias('@web/images/photo-gallery.png'), [
                                'width' => '50px',
                                'class' => 'img-responsive center-block',
                                'style' => 'margin-bottom: 5px;',
                            ]) . Html::tag('span', 'ภาพสินค้า', ['class' => 'text-center']) ?>
                        </p>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-body">
                        <div class="row isotopeContainer" id="container">
                            <?php foreach ($modelProduct->fileAttachments as $key => $file) : ?>
                            <div class="col-md-4 col-sm-4 col-xs-4 isotopeSelector">
                                <article class="wow fadeInUp">
                                    <figure>
                                        <img src="<?= Yii::getAlias('@web'.$file['base_url'].$file['path']); ?>" alt="image" class="img-rounded">
                                        <div class="overlay-background">
                                        <div class="inner"></div>
                                        </div>
                                        <div class="overlay">
                                        <a data-fancybox="images" href="<?= Yii::getAlias('@web'.$file['base_url'].$file['path']); ?>">
                                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        </a>
                                        </div>
                                    </figure>
                                </article>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
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
                <div class="panel panel-info product-panel">
                    <div class="panel-body">
                        <?= $this->render('_quotation-details', [
                            'option' => $option,
                            'modelProduct' => $modelProduct,
                            'queryBuilder' => $queryBuilder,
                            'details' => $details
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 list-group-price">
                <!-- <div class="alert alert-info" role="alert">
                    Notice! เลือกจำนวนที่ต้องการพิมพ์โดยกดที่เครื่องหมายถูก <i class="fa fa-check-circle-o fa-2x"></i>
                </div> -->
                <ul class="list-group">
                    
                </ul>
            </div>
        </div>

        <div class="row list-group-price">
            <div class="col-xs-4">
                <?php
                echo Html::activeLabel($model,'cust_quantity',['label' => 'เพิ่มจำนวนอื่นๆ']);
                echo Html::activeInput('tel', $model, 'cust_quantity',[
                    'min' => 1,
                    'placeholder' => 'จำนวน',
                    'class' => 'form-control'
                ]);
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
         
    </div>
</section>

<?php
$this->registerJs(<<<JS
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

onAddQty = function() {
    var \$items = $('.list-group').find('.list-group-item');
    var qty = [];
    var isDuplicate = false;
    \$items.each(function( i,v ) {
        if($(this).data('qty') == $('#tblproductcatalog-cust_quantity').val()){
            isDuplicate = true;
        } else {
            qty.push($(this).data('qty'));
        }
    });
    if(!isDuplicate){
        qty.push($('#tblproductcatalog-cust_quantity').val());
        Calculate(qty);
    }
}

Calculate = function(qty = []) {
    var formData = {};
    $.each(options, function(i,v) {
        formData['TblQuotationDetail['+ i +']'] = v;
    });
    $.ajax({
        url: '/product/calculate-price',
        type: 'POST',
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
Calculate();
JS
);
?>