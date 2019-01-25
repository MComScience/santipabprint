<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 17:00
 */
use adminlte\widgets\GridView;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Url;
?>
<div class="kv-detail-content">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table-bordered table-condensed table-hover kv-table'
                ],
                'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => 'ไดคัท', 'options' => ['class' => 'success text-center','colspan' => 5]]
                        ]
                    ]
                ],
                'layout' => '{items}',
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    'diecut_id',
                    'diecut_name',
                    'diecut_description',
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'noWrap' => true,
                        'template' => '{delete}',
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
                            if ($action == 'delete') {
                                return Url::to(['delete-diecut', 'id' => $key]);
                            }
                        }
                    ]
                ]
            ]) ?>
        </div>
    </div>
</div>
