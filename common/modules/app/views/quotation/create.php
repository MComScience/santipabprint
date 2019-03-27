<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\app\models\TblQuotation */

$this->title = 'Create Tbl Quotation';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-quotation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
