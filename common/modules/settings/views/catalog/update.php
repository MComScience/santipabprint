<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblCatalog */

$this->title = 'Update Tbl Catalog: ' . $model->catalog_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Catalogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->catalog_id, 'url' => ['view', 'id' => $model->catalog_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-catalog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
