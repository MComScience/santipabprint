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
                            ['content' => 'รายละเอียดราคา', 'options' => ['class' => 'success text-center', 'colspan' => 4]]
                        ]
                    ]
                ],
                'layout' => '{items}',
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    'bill_detail_qty',
                    [
                        'attribute' => 'bill_detail_price',
                        'hAlign' => 'right'
                    ],
                ]
            ])
            ?>
        </div>
    </div>
</div>

