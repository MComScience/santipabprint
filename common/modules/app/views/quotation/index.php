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

        <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
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
                    'content'=> '',
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
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'quotation_id',
                'quotation_customer_name',
                'quotation_customer_address',
                'quotation_customer_email:email',
                'quotation_customer_tel',
                //'created_at',
                //'updated_at',

                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view} {delete}',
                    'viewOptions' => [
                        'target' => '_blank',
                        'data-pjax' => 0
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if($action === 'view'){
                            return Url::to(['/app/product/quo', 'q' => $key]);
                        }
                    }
                ],
            ],
        ]); ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>

