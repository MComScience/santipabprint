<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblProductType */

$this->title = 'ประเภทสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่าประเภทสินค้า', 'url' => ['/settings/product-type/index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-product-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
