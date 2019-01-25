<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 14/1/2562
 * Time: 11:14
 */
use yii\helpers\Url;
$className = str_replace('.', '_',$item['product_type_id']);
?>
<div class="col">
    <div class="media open-collapse" data-toggle="collapse__35" role="button"
         aria-expanded="true" aria-controls="collapse__35">
        <a class="product-link product-cate-sub"
           href="javascript:void(0);"
           data-url="<?= Url::to(['/product/product-sub', 'id' => $item['product_type_id']]) ?>"
            data-block-id="block_coll_<?= strtolower($className) ?>"
            data-point-id="point-active-<?= strtolower($className) ?>">
            <span class="icon"></span>
            <!--                                                            <span class="icon"><img src="/skin/frontend/ggp/default/images/expand.png"></span>-->
            <div class="product-sub">
                <?= $item['product_type_icon'] ?>
            </div>
            <div class="media-body">
                <p class="product-sub-name">
                    <?= $item['product_type_name'] ?>
                </p>
            </div>
        </a>
    </div>
    <div class="point-active point-active-<?= strtolower($className); ?>" style="display: none;"></div>
</div>


