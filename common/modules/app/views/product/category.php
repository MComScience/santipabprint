<?php
use adminlte\helpers\Html;
use common\widgets\ProductView;
use kartik\icons\Icon;

$this->title = 'ประเมินราคา';

$css = [
    '@web/bundle/product_grid.css',
    '@web/bundle/animate.css',
    '@web/bundle/waitMe.css',
];

foreach ($css as $css_path) {
    $this->registerCssFile($css_path, [
        'depends' => [
            \yii\bootstrap\BootstrapAsset::className(),
            \kidz\assets\KidzAsset::className(),
            \frontend\assets\AppAsset::className()
        ],
    ]);
}
?>

<section class="whiteSection full-width clearfix productsSection">
    <div class="container">
        <!-- Section Title -->
        <div class="sectionTitle text-center">
            <h2 class="wow">
                <span class="shape shape-left bg-color-4"></span>
                <span>
                    <?= Html::encode('เลือกสินค้า') ?>
                </span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <?= Html::a(Icon::show('th').'เลือกหมวดหมู่',['/app/product/index']); ?>
                </li>
                <li class="active"><?= $catagory['product_category_name'] ?></li>
            </ol>
        </div>
        <!-- Product List -->
        <div class="product-grid container-fluid">
            <div class="padding-v-sm">
                <div class="line line-dashed"></div>
                <div class="tab-content product-grid-tab" id="pills-tabContent">
                    <div class="tab-pane fade active in" id="pills-all" role="tabpanel" aria-labelledby="pills-home-tab">
                        <?= ProductView::widget(['products' => $products]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>