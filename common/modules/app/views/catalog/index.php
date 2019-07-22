<?php

use adminlte\widgets\GridView;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Url;
use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\modules\app\models\TblCatalogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ตัวอย่าง ผลิตภัณฑ์';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \dominus77\sweetalert2\Alert::widget(['useSessionFlash' => true]) ?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->title ?></h3>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="tbl-catalog-index">

            <?=
            GridView::widget([
                'id' => 'grid-product',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax' => true,
                'export' => [
                    'showConfirmAlert' => false,
                    'target' => GridView::TARGET_SELF
                ],
                'panel' => [
                    'heading' => false,
                    'type' => 'default',
                    'before' => Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create'], [
                        'class' => 'btn btn-primary',
                        'data-pjax' => 0,
                        'data-toggle' => 'tooltip',
                        'title' => 'เพิ่มรายการ'
                    ]),
                    'after' => '',
                    'footer' => ''
                ],
                'toolbar' => [
                    [
                        'content' => Html::a(Icon::show('refresh'), ['unit'], [
                            'class' => 'btn btn-default',
                            'title' => 'Reload'
                        ]),
                    ],
                    '{export}',
                    '{toggleData}'
                ],
                'tableOptions' => ['class' => 'small kv-table'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'catalog_type_id',
                        'value' => function($model) {
                            return $model->catalogType ? $model->catalogType->catalog_type_name : '-';
                        },
                        'group' => true
                    ],
                    'catalog_name',
                    'catalog_detail:raw',
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'noWrap' => true,
                        'template' => '{update} {delete}',
                        'updateOptions' => [
                            'class' => 'btn btn-sm btn-primary',
                            'role' => 'modal-remote',
                            'data-toggle' => 'tooltip'
                        ],
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a(Icon::show('trash', ['framework' => Icon::BSG]), $url, [
                                            'class' => 'btn btn-sm btn-danger',
                                            'data-pjax' => '0',
                                            'title' => Yii::t('yii', 'Delete'),
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax-reload' => '#grid-product-pjax',
                                            'data-toggle' => 'tooltip'
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action == 'update') {
                                return Url::to(['update', 'id' => $key]);
                            }
                            if ($action == 'delete') {
                                return Url::to(['delete', 'id' => $key]);
                            }
                        }
                    ]
                ],
            ]);
            ?>
        </div>
    </div>
</div>

<?php
$this->registerJsFile(
        '@web/js/yii-confirm.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>