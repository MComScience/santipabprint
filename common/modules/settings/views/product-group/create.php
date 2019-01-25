<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblProductGroup */

$this->title = 'กลุ่มสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่ากลุ่มสินค้า', 'url' => ['/settings/product-group/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-product-group-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
