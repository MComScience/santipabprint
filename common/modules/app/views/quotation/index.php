<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\app\models\TblQuotationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการใบเสนอราคา';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->title ?></h3>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="tbl-quotation-index">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
            'toolbar' => [
                [
                    'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default', 
                        'title' => 'Reload'
                    ]),
                ],
                '{export}',
                '{toggleData}'
            ],
            'panel' => [
                'heading'=>false,
                'type'=>'success',
                'before'=> '',
                'after'=> '',
                'footer'=> ''
            ],
            'export' => [
                'showConfirmAlert' => false,
                'fontAwesome' => true,
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'quotation_id',
                'quotation_customer_name',
                'quotation_customer_address',
                'quotation_customer_email:email',
                'quotation_customer_tel',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d/m/Y H:i'],
                    'filterType' => GridView::FILTER_DATE,
                    'contentOptions' => [
                        'style' => 'text-align: center;'
                    ],
                    'filterWidgetOptions' => [
                        'options' => ['autocomplete' => 'off'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                        ],
                        'readonly' => true,
                    ]
                ],
                //'updated_at',

                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view} {delete}',
                    'viewOptions' => [
                        'target' => '_blank',
                        'data-pjax' => 0
                    ],
                    'noWrap' => true,
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if($action === 'view'){
                            return Url::to(['/app/product/quo', 'q' => $key]);
                        }
                        if($action === 'delete'){
                            return Url::to(['delete', 'id' => $key]);
                        }
                    }
                ],
            ],
        ]); ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>

