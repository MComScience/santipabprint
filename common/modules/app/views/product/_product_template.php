<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/1/2562
 * Time: 21:55
 */
use yii\helpers\Url;
use adminlte\helpers\Html;
$className = strtolower(str_replace('.', '_', $product['product_category_id']));
?>
<div class="col">
    <div class="media open-collapse" data-toggle="collapse__35" role="button"
         aria-expanded="true" aria-controls="collapse__35">
        <a class="product-link product-cate-sub"
           href="<?= Url::to(['/app/product/quotation', 'p' => $product['product_id'], 'slug' => Yii::$app->slugUrl->create($product['product_name'])]) ?>"
           data-block-id="block_coll_<?= $className ?>"
           data-point-id="point-active-<?= $className ?>">
            <span class="icon"></span>
            <div class="product-sub">
                <?= Html::img($product->imageUrl, ['class' => 'img-fluid img-responsive center-block']) ?>
            </div>
            <div class="media-body">
                <p class="product-sub-name">
                    <?= $product['product_name'] ?>
                </p>
            </div>
        </a>
    </div>
    <div class="point-active point-active-<?= $className; ?>"
         style="display: none;"></div>
</div>
