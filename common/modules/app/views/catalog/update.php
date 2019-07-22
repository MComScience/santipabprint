<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\app\models\TblCatalog */

$this->title = 'แก้ไข สินค้าตัวอย่าง ';
$this->params['breadcrumbs'][] = ['label' => 'แคตตาล็อก', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-catalog-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
