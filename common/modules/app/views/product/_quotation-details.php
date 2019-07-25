<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/1/2562
 * Time: 20:37
 */
$embossing = $queryBuilder->isShowInput($option, 'emboss_size_width') && $queryBuilder->isShowInput($option, 'emboss_size_height') && $queryBuilder->isShowInput($option, 'emboss_size_unit');
$foil =  $queryBuilder->isShowInput($option, 'foil_size_width') &&  $queryBuilder->isShowInput($option, 'foil_size_height') &&  $queryBuilder->isShowInput($option, 'foil_size_unit') &&  $queryBuilder->isShowInput($option, 'foil_color_id');
$classes = [
    [
        'label' => 'รูปแบบ',
        'class' => 'op_land_orient',
        'visible' => $queryBuilder->isShowInput($option, 'land_orient')
    ],
    [
        'label' => 'ขนาด',
        'class' => 'op_paper_size_id',
        'visible' => true
    ],
    [
        'label' => 'เข้าเล่ม',
        'class' => 'op_book_binding_id',
        'visible' => $queryBuilder->isShowInput($option, 'book_binding_id')
    ],
    [
        'label' => $queryBuilder->getInputLabel($option, 'page_qty', $model),
        'class' => 'op_page_qty',
        'visible' => $queryBuilder->isShowInput($option, 'page_qty')
    ],
    [
        'label' => $queryBuilder->getInputLabel($option, 'paper_id', $model),
        'class' => 'op_paper_id',
        'visible' => $queryBuilder->isShowInput($option, 'paper_id')
    ],
    [
        'label' => $queryBuilder->getInputLabel($option, 'print_one_page', $model),
        'class' => 'op_print_one_page',
        'visible' => $queryBuilder->isShowInput($option, 'print_one_page')
    ],
    [
        'label' => $queryBuilder->getInputLabel($option, 'print_two_page', $model),
        'class' => 'op_print_two_page',
        'visible' => $queryBuilder->isShowInput($option, 'print_two_page')
    ],
    [
        'label' => $queryBuilder->getInputLabel($option, 'coating_id', $model),
        'class' => 'op_coating_id',
        'visible' => $queryBuilder->isShowInput($option, 'coating_id')
    ],
    [
        'label' => 'ไดคัท',
        'class' => 'op_diecut_id',
        'visible' => $queryBuilder->isShowInput($option, 'diecut')
    ],
    [
        'label' => $queryBuilder->getInputLabel($option, 'perforate', $model),
        'class' => 'op_perforate_option',
        'visible' => $queryBuilder->isShowInput($option, 'perforate')
    ],
    [
        'label' => $queryBuilder->getInputLabel($option, 'fold_id', $model),
        'class' => 'op_fold_id',
        'visible' => $queryBuilder->isShowInput($option, 'fold_id')
    ],
    [
        'label' => 'ฟอยล์',
        'class' => 'op_foil_color_id',
        'visible' => $foil
    ],
    [
        'label' => 'ปั๊มนูน',
        'class' => 'op_embossing',
        'visible' => $embossing
    ],
 
   
];
?>
<ul class="quotation-detail" style="font-size: 14px;padding: 0;">
    <li>
        <span>สินค้า</span>
        <span class="float-right"><?= $modelProduct['product_name'] ?></span>
    </li>
</ul>
<ul class="quotation-detail" style="font-size: 14px;padding: 0;">
    <?php foreach ($classes as $item): ?>
        <li style="<?= $item['visible'] ? '' : 'display:none;' ?>">
            <span><?= $item['label']; ?></span>
            <span class="<?= $item['class']; ?> float-right" id="<?= $item['class']; ?>">-</span>
        </li>
    <?php endforeach; ?>
</ul>
