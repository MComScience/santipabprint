<?php

use yii\helpers\Html;
use adminlte\widgets\GridView;
use kartik\icons\Icon;
use yii\helpers\Url;
use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\modules\settings\models\search\TblProductGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ตั้งค่ากลุ่มสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/settings/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@common/modules/settings/views/default/menu'); ?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->title ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <p>
            <?= Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ?>
        </p>

        <?= GridView::widget([
            'id' => 'crud-product-group',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            /*'panel' => [
                'heading' => false,
                'type' => 'default',
                'before' => '',
                'after' => '',
            ],*/
            'export' => [
                'showConfirmAlert' => false,
            ],
            'tableOptions' => ['class' => 'small kv-table'],
            'columns' => [
                ['class' => '\kartik\grid\SerialColumn'],
                [
                    'attribute' => 'product_group_id',
                    /*'value' => function ($model, $key, $index) {
                        return Html::tag('span', $model['product_group_id'], ['class' => 'label bg-blue','style' => 'font-size: 14px;']);
                    },*/
                    'format' => 'raw',
                    'hAlign' => 'center'
                ],
                [
                    'attribute' => 'product_group_name',
                ],
                [
                    'attribute' => 'created_by',
                    'value' => function ($model, $key, $index) {
                        return !empty($model->userCreatedBy) ? $model->userCreatedBy->fullname : '';
                    },
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d/m/Y H:i:s']
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model, $key, $index) {
                        return !empty($model->userUpdatedBy) ? $model->userUpdatedBy->fullname : '';
                    },
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:d/m/Y H:i:s']
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'noWrap' => true,
                    'template' => '{update} {delete}',
                    'updateOptions' => [
                        'class' => 'btn btn-primary',
                        'role' => 'modal-remote'
                    ],
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::a(Icon::show('trash', ['framework' => Icon::BSG]), $url, [
                                'class' => 'btn btn-danger',
                                'data-pjax' => '0',
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax-reload' => '#crud-product-group-pjax'
                            ]);
                        },
                    ]
                ],
            ],
        ]); ?>
    </div>
    <!-- /.box-body -->
</div>

<!-- Modal -->
<?= $this->render('modal') ?>
<?php
$this->registerJsFile(
    '@web/js/yii-confirm.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>

