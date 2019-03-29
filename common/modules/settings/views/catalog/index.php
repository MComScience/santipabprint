<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\settings\models\TblCatalogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Catalogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-catalog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Catalog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'catalog_id',
            'catalog_name',
            'catalog_detail:ntext',
            'catalog_type_id',
            'image_path',
            //'image_base_url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
