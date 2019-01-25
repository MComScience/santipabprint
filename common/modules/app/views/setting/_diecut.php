<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 16:06
 */

use adminlte\widgets\GridView;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Url;
use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

$this->title = 'ไดคัท';
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
        <?= GridView::widget([
            'id' => 'grid-diecut',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'export' => [
                'showConfirmAlert' => false,
            ],
            'panel' => [
                'heading' => false,
                'type' => 'default',
                'before' => Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-diecut'], [
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
                    'content' => Html::a(Icon::show('refresh'), ['diecut'], [
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
                    'detailUrl' => Url::to(['diecut-detail']),
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'expandOneOnly' => true
                ],
                'diecut_group_id',
                'diecut_group_name',
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
                                'data-pjax-reload' => '#grid-diecut-pjax',
                                'data-toggle' => 'tooltip'
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['update-diecut', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['delete-diecut-group', 'id' => $key]);
                        }
                    }
                ]
            ],
        ]) ?>
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
