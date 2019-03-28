<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/1/2562
 * Time: 20:37
 */
?>
<ul class="quotation-detail" style="font-size: 14px;padding: 0;">
    <li>
        <span>สินค้า</span>
        <span class="float-right"><?= $modelProduct['product_name'] ?></span>
    </li>
</ul>
<ul class="quotation-detail" style="font-size: 14px;padding: 0;">
    <?php foreach ($details as $item): ?>
        <li>
            <span><?= str_replace('<span class="text-danger">*</span>', '', $item['label']); ?></span>
            <span class="float-right"><?= $item['info'] ?></span>
        </li>
    <?php endforeach; ?>
</ul>
