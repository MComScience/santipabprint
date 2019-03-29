<?php
/* @var $this yii\web\View */

use adminlte\helpers\Html;

$this->title = 'สินค้า';

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
                    <?= Html::encode('ตัวอย่างผลิตภัณฑ์') ?>
                </span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
        </div>
        <!-- end title -->
        <!-- Product List -->
        <div class="product-grid container-fluid">
            <div class="padding-v-sm">
                <div class="line line-dashed"></div>
            </div>
            <div class="tab-content product-grid-tab" id="pills-tabContent">
                <div class="tab-pane fade active in" id="pills-all" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row row-product">
                        <?php foreach ($categorys as $category) : ?>
                            <?php echo $this->render('_product_template', ['category' => $category]) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Product List -->
    </div>
</section>
