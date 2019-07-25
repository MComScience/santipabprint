<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use adminlte\widgets\GridView;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Url;
?>
<div class="kv-detail-content">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table-bordered table-condensed table-hover kv-table'
                ],
                'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => 'รายละเอียดขนาดกระดาษ', 'options' => ['class' => 'success text-center', 'colspan' => 6]]
                        ]
                    ]
                ],
                'layout' => '{items}',
                'columns' => [
                    [
                        'class' => '\kartik\grid\SerialColumn',
                         'width' => '20%',
                    ],
                    [
                        'attribute' => 'paper_size',
                        'label' => 'ขนาด'
                    ],
                    [
                        'attribute' => 'paper_width',
                        'label' => 'ความกว้าง',
                        'value' => function($model) {
                            return Html::convertNumber($model['paper_width']);
                        }
                    ],
                    [
                        'attribute' => 'paper_length',
                        'label' => 'ความยาว',
                        'value' => function($model) {
                            return Html::convertNumber($model['paper_length']);
                        }
                    ],
                    [
                        'attribute' => 'paper_price',
                        'label' => 'ราคา',
                        'format' => ['decimal', 2],
                        'hAlign' => 'right',
                    ],
                    [
                        'class' => 'kartik\grid\BooleanColumn',
                        'attribute' => 'stk_flag',
                        'label' => 'สติ๊กเกอร์',
                        'value' => function($model) {
                            return $model['stk_flag'] == 'N' ? false : true;
                        }
                    ], 
                ]
            ])
            ?>
        </div>
    </div>
</div>