<?php
/* @var $this yii\web\View */

use adminlte\helpers\Html;

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
<section class="whiteSection full-width clearfix productsSection">
    <div class="container">
        <!-- Section Title -->
        <div class="sectionTitle text-center">
            <h2 class="wow">
                <span class="shape shape-left bg-color-4"></span>
                <span>
                    <?= Html::encode('เลือกหมวดหมู่การพิมพ์') ?>
                </span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
        </div>
        <!-- end title -->
        <!-- Product List -->
        <div class="product-grid container-fluid">
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-all" role="tab"
                       aria-controls="pills-home" aria-selected="true">ทั้งหมด</a>
                </li>
                <?php
                foreach ($categorys as $category) {
                    $id = strtolower($category['product_category_id']);
                    echo Html::beginTag('li', ['class' => 'nav-item']) .
                        Html::a($category['product_category_name'], '#pills-' . $id, [
                            'id' => "pills-$id-tab",
                            'data-toggle' => 'pill',
                            'role' => 'tab',
                            'aria-controls' => "pills-$id",
                            'aria-selected' => 'false',
                            'class' => 'nav-link'
                        ]) .
                        Html::endTag('li');
                } ?>
            </ul>
            <div class="padding-v-sm">
                <div class="line line-dashed"></div>
            </div>
            <div class="tab-content product-grid-tab" id="pills-tabContent">
                <div class="tab-pane fade active in" id="pills-all" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row row-product">
                        <?php foreach ($allProducts as $product) : ?>
                            <?php echo $this->render('_product_template', ['product' => $product]) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php foreach ($productGroups as $product) { ?>
                    <div class="tab-pane fade"
                         id="pills-<?= strtolower($product['product_category_id']); ?>"
                         role="tabpanel"
                         aria-labelledby="pills-<?= strtolower($product['product_category_id']); ?>-tab">
                        <?php foreach ($product['items'] as $item) : ?>
                            <?php echo $this->render('_product_template', ['product' => $item]) ?>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- End Product List -->
    </div>
</section>
