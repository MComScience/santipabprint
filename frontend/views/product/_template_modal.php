<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 14/1/2562
 * Time: 11:27
 */

use yii\helpers\Url;
use adminlte\helpers\Html;

?>
<style type="text/css">
    #product-modal .modal-header {
        border-bottom: 1px solid #fff;
    }
    #product-modal .modal-content {
        border: 2px solid #ea7066;
    }
</style>
<?php if ($products) : ?>
    <div class="row text-center">
        <div class="product-grid container-fluid">
            <div class="tab-content product-grid-tab" id="pills-tabContent" style="margin-top: 0px">
                <div class="tab-pane fade active in fadeInLeft" id="pills-home" role="tabpanel"
                     aria-labelledby="pills-home-tab">
                    <div class="sectionTitle text-center">
                        <h2 style="margin-bottom: 10px;">
                            <span class="shape shape-left bg-color-4"></span>
                            <span><?= $productType['product_type_name'] ?></span>
                            <span class="shape shape-right bg-color-4"></span>
                        </h2>
                    </div>
                    <div class="row">
                        <?php foreach ($products as $product) : ?>
                            <div class="col">
                                <div class="media">
                                    <a class="product-link cell product_nav"
                                       href="<?= Url::to(['/product/quotation', 'product_id' => $product['product_id']]) ?>"
                                       data-pjax="0">
                                        <div class="product-sub">
                                            <?=
                                            !empty($product['product_icon_path']) ?
                                                Html::img(Url::base(true) . $product['product_icon_base_url'] . str_replace('\\', '/', $product['product_icon_path']), ['alt' => $product['product_id'], 'class' => 'img-fluid img-responsive center-block']) :
                                                Html::img(Url::base(true) . '/images/No_Image_Available.png', ['alt' => $product['product_id'], 'class' => 'img-fluid img-responsive center-block'])
                                            ?>
                                        </div>
                                        <div class="media-body">
                                            <p class="product-sub-name">
                                                <?= Html::encode($product['product_name']); ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="row text-center">
        <div class="product-grid container-fluid">
            <div class="tab-content product-grid-tab" id="pills-tabContent" style="margin-top: 0px">
                <div class="tab-pane fade active in fadeInLeft" id="pills-home" role="tabpanel"
                     aria-labelledby="pills-home-tab">
                    <div class="sectionTitle text-center">
                        <h2 style="margin-bottom: 10px;">
                            <span class="shape shape-left bg-color-4"></span>
                            <span>ไม่พบสินค้า</span>
                            <span class="shape shape-right bg-color-4"></span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
