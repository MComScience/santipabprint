<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblProduct */

$this->title = 'บันทึกสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่าสินค้า', 'url' => ['/settings/product/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
