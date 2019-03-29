<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\app\models\TblCatalog */

$this->title = 'บันทึกรายการ';
$this->params['breadcrumbs'][] = ['label' => 'แคตตาล็อก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-catalog-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
