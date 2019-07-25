<?php
/* @var $this yii\web\View */

use adminlte\helpers\Html;
use app\assets\SweetAlert2Asset;

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

$this->registerCss(<<<CSS
.lds-dual-ring {
  display: inline-block;
  width: 64px;
  height: 64px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid #42b983;
  border-color: #42b983 transparent #42b983 transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.loading {
    display: flex;
    align-items: center;
    justify-content: center;
}
.col {
  position: relative;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
  width: 16.66666667%;
  max-width: 100% !important;
  min-width: 140px !important;
  height: 100% !important;
  margin: 0px !important;
}
CSS
);
SweetAlert2Asset::register($this);
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
                    <div class="loading">
                        <div class="lds-dual-ring" id="loading"></div>
                    </div>
                    <div id="app">
                        <vm-catalog-list :categorys="categorys" />
                    </div>
                    <?php
                    /*
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
                    }*/
                    ?>
                </div>
            </div>
        </div>
        <!-- End Product List -->
    </div>
</section>

<?php
$this->registerJsFile(
  '@web/js/axios.min.js',
  ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
  YII_ENV_DEV ? '@web/js/vue.js' : '@web/js/vue.min.js',
  []
);

$this->registerJsFile(
  '@web/js/vue/catalog-list.js',
  ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJs(<<<JS
$(window).on("load", function (e) {
    // $('#loading').hide()
    $('#app').removeClass('hidden')
})
JS
);
?>