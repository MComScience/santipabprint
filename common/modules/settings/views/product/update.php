<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblProduct */

$this->title = 'แก้ไขสินค้า: ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค้า', 'url' => ['/settings/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่าสินค้า', 'url' => ['/settings/product/index']];
$this->params['breadcrumbs'][] = $model->product_id;
?>
<div class="tbl-product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
