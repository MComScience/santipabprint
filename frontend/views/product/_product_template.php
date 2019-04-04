<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/1/2562
 * Time: 21:55
 */
use yii\helpers\Url;
use adminlte\helpers\Html;
$className = '';
?>
<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
    <div class="media open-collapse" data-toggle="collapse__35" role="button"
         aria-expanded="true" aria-controls="collapse__35">
        <a class="product-link product-cate-sub"
           href="<?= Url::to(['/product/catalog', 'p' => $category['catalog_type_id']]) ?>"
           data-block-id="block_coll_<?= $className ?>"
           data-point-id="point-active-<?= $className ?>">
            <span class="icon"></span>
            <div class="product-sub">
                <?= Html::img($category->imageUrl, ['class' => 'img-fluid img-responsive center-block']) ?>
            </div>
            <div class="media-body">
                <p class="product-sub-name">
                    <?= $category['catalog_type_name'] ?>
                </p>
            </div>
        </a>
    </div>
    <div class="point-active point-active-<?= $className; ?>"
         style="display: none;"></div>
</div>
