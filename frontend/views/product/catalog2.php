<?php
use yii\helpers\Url;
use adminlte\helpers\Html;
use kartik\icons\Icon;

$css = [
    '@web/bundle/product_grid.css',
    //'@web/bundle/animate.css',
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
                    <?= $catalogType['catalog_type_name'] ?>
                </span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <?= Html::a(Icon::show('th').'ตัวอย่างผลิตภัณฑ์',['/product/catalog-list']); ?>
                </li>
                <li class="active"><?= $catalogType['catalog_type_name'] ?></li>
            </ol>
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
                        <?php foreach ($products as $product) : ?>
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <div class="media open-collapse" data-toggle="collapse__35" role="button"
                                    aria-expanded="true" aria-controls="collapse__35">
                                    <a class="product-link product-cate-sub"
                                    href="<?= Url::to(['/product/catalog-detail', 'id' => $product['catalog_id']]) ?>"
                                    data-block-id="block_coll_<?= $product['catalog_id'] ?>"
                                    data-point-id="point-active-<?= $product['catalog_id'] ?>">
                                        <span class="icon"></span>
                                        <div class="product-sub">
                                            <?= Html::img($product->imageUrl, ['class' => 'img-fluid img-responsive center-block']) ?>
                                        </div>
                                        <div class="media-body">
                                            <p class="product-sub-name">
                                                <?= $product['catalog_name'] ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="point-active point-active-<?= $product['catalog_id'] ?>"
                                    style="display: none;"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Product List -->
    </div>
</section>