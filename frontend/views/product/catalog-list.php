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
$i = 0;
$x = 0;
$count = count($categorys);
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
                    <?php
                    foreach ($categorys as $category) {
                        $i++;
                        if ($i == 1) {
                            echo '<!-- begin row ' . $i . '-->';
                            echo '<div class="row row-product">';
                        }
                        echo $this->render('_product_template', ['category' => $category]);
                        $x++;
                        if ($i == 6 || $x == $count) {
                            echo '</div>' . '<!-- end row ' . $i . '-->';
                            $i = 0;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- End Product List -->
    </div>
</section>
