<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblCatalog */

$this->title = 'Create Tbl Catalog';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Catalogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-catalog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
