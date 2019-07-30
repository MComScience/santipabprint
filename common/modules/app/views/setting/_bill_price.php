<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/1/2562
 * Time: 20:56
 */
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use kartik\icons\Icon;
use adminlte\helpers\Html;
use yii\helpers\Url;
use adminlte\widgets\GridView;

SweetAlert2Asset::register($this);

$this->title = 'ราคาบิล ใบเสร็จ ใบส่งของ';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/app/setting/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@common/modules/app/views/setting/index'); ?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <?= Icon::show('file-text-o') . Html::encode($this->title) ?>
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?=
        GridView::widget([
            'id' => 'grid-bill-price',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'export' => [
                'showConfirmAlert' => false,
            ],
            'panel' => [
                'heading' => false,
                'type' => 'default',
                'before' => Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-bill-price'], [
                    'class' => 'btn btn-primary',
                    'role' => 'modal-remote',
                    'data-pjax' => 0,
                    'data-toggle' => 'tooltip',
                    'title' => 'เพิ่มรายการ'
                ]),
                'after' => '',
                'footer' => ''
            ],
            'toolbar' => [
                [
                    'content' => Html::a(Icon::show('refresh'), ['paper-type'], [
                        'class' => 'btn btn-default',
                        'title' => 'Reload'
                    ]),
                ],
                '{export}',
                '{toggleData}'
            ],
            'tableOptions' => ['class' => 'small kv-table'],
            'columns' => [
                ['class' => '\kartik\grid\SerialColumn'],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'width' => '50px',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detailUrl' => Url::to(['bill-details']),
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'expandOneOnly' => true
                ],
                'bill_price_id',
                [
                    'attribute' => 'paper_size_id',
                    'value' => function($model) {
                        return $model->paperSize ? $model->paperSize->paper_size_name : '';
                    }
                ],
                'bill_floor',
                [
                    'attribute' => 'paper_id',
                    'value' => function($model) {
                        return $model->paper ? $model->paper->paper_name : '';
                    }
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'noWrap' => true,
                    'template' => '{copy} {update} {delete}',
                    'updateOptions' => [
                        'class' => 'btn btn-sm btn-primary',
                        'role' => 'modal-remote',
                        'data-toggle' => 'tooltip'
                    ],
                    'buttons' => [
                        'copy' => function ($url, $model, $key) {
                            return Html::a('Duplicate', $url, [
                                        'class' => 'btn btn-sm btn-default',
                                        'data-pjax' => '0',
                                        'title' => Yii::t('yii', 'Duplicate'),
                                        'data-confirm' => 'Duplicate',
                                        'data-method' => 'post',
                                        'data-pjax-reload' => '#grid-bill-price-pjax',
                                        'data-toggle' => 'tooltip',
                                        'complete-msg' => 'Success'
                            ]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a(Icon::show('trash', ['framework' => Icon::BSG]), $url, [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-pjax' => '0',
                                        'title' => Yii::t('yii', 'Delete'),
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-pjax-reload' => '#grid-bill-price-pjax',
                                        'data-toggle' => 'tooltip'
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['update-bill-price', 'id' => $key]);
                        }
                        if ($action == 'copy') {
                            return Url::to(['copy-bill-price', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['delete-bill-price', 'id' => $key]);
                        }
                    }
                ]
            ],
        ])
        ?>
    </div>
</div>
<!-- Modal -->
<?= $this->render('modal') ?>
<?php
$this->registerJsFile(
        '@web/js/yii-confirm.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>