<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\app\models\TblQuotation */

$this->title = 'Update Tbl Quotation: ' . $model->quotation_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->quotation_id, 'url' => ['view', 'id' => $model->quotation_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-quotation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
