<?php
/* @var $this yii\web\View */

use adminlte\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\Url;
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use yii\bootstrap\Modal;

SweetAlert2Asset::register($this);
$this->title = 'สินค้า';

$css = [
    '@web/css/product-grid.css',
    '@web/css/animate.css',
    '@web/js/waitMe/waitMe.min.css',
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
                    <?= Html::encode('กรุณาเลือกผลิตภัณฑ์') ?>
                </span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
        </div>

        <!-- Product List -->
        <div class="product-grid container-fluid">
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-all" role="tab"
                       aria-controls="pills-home" aria-selected="true">ทั้งหมด</a>
                </li>
                <?php foreach ($groups as $group) : ?>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="pills-<?= $group['group_id'] ?>-tab"
                           data-toggle="pill"
                           href="#pills-<?= $group['group_id'] ?>"
                           role="tab"
                           aria-controls="pills-<?= $group['group_id'] ?>"
                           aria-selected="false">
                            <?= $group['group_name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="padding-v-sm">
                <div class="line line-dashed"></div>
            </div>
            <div class="tab-content product-grid-tab" id="pills-tabContent">
                <div class="tab-pane fade active in" id="pills-all" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row row-product">
                        <?php
                        foreach ($product_type_all as $item) {
                            echo $this->render('_template', ['item' => $item]);
                        }
                        ?>
                    </div>
                </div>
                <?php foreach ($group_types as $group_type) { ?>
                    <div class="tab-pane fade"
                         id="pills-<?= $group_type['group_id'] ?>"
                         role="tabpanel"
                         aria-labelledby="pills-<?= $group_type['group_id'] ?>-tab">
                        <?php
                        foreach ($group_type['items'] as $item) {
                            echo $this->render('_template', ['item' => $item]);
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- End Product List -->
    </div>
    <!-- End Section Title -->

</section>
<?php
Modal::begin([
    "id" => "product-modal",
    "header" => "<h4 class=\"modal-title\" id=\"gridSystemModalLabel\">กรุณาเลือกผลิตภัณฑ์</h4>",
    "footer" => false,
    'options' => ['class' => 'modal fade bs-product-modal-lg', 'tabindex' => false,],
    'size' => 'modal-lg',
    'clientOptions' => [
        //'backdrop' => 'static',
        'keyboard' => false
    ]
]);

Modal::end();

$js = [
    '@web/js/waitMe/waitMe.min.js',
    '@web/js/product-grid.js'
];
foreach ($js as $js_path) {
    $this->registerJsFile(
        $js_path,
        ['depends' => [
            \yii\web\JqueryAsset::className(),
            \kidz\assets\KidzAsset::className()
        ]]
    );
}
?>



