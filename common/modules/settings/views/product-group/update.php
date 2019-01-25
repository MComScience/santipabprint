<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblProductGroup */

$this->title = 'กลุ่มสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่ากลุ่มสินค้า', 'url' => ['/settings/product-group/index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-product-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
