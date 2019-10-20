<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 20:32
 */
use adminlte\widgets\GridView;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Url;
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use adminlte\assets\FancyboxAsset;
use yii\jui\JuiAsset;

SweetAlert2Asset::register($this);
FancyboxAsset::register($this);
JuiAsset::register($this);

$this->title = 'สินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/app/setting/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .fancybox img {
        max-width: 50%;
    }
    td.sortable:hover {
        cursor: move;
    }
</style>
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
            'id' => 'grid-product',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'export' => [
                'showConfirmAlert' => false,
            ],
            'panel' => [
                'heading' => false,
                'type' => 'default',
                'before' => Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-dynamic-form'], [
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
                    'content' => Html::a(Icon::show('refresh'), ['product'], [
                        'class' => 'btn btn-default',
                        'title' => 'Reload'
                    ]),
                ],
                '{export}',
                '{toggleData}'
            ],
            'tableOptions' => ['class' => 'small kv-table'],
            'columns' => [
                [
                    'header' => '#',
                    'value' => function($model){
                        return Html::tag('i', '', ['class' => 'fa fa-arrows']);
                    },
                    'format' => 'raw',
                    'hAlign' => 'center',
                    'contentOptions' => ['class' => 'sortable']
                ],
                ['class' => '\kartik\grid\SerialColumn'],
                [
                  'attribute' => 'product_id'
                ],
                [
                    'attribute' => 'icon',
                    'value' => function($model){
                        return $model->getPreviewIcon();
                    },
                    'format' => 'raw',
                    'hidden' => true
                ],
                [
                    'attribute' => 'product_category_id',
                    'value' => function($model, $key, $index){
                        return !empty($model->productCategory) ? $model->productCategory->product_category_name : '';
                    },
                    'group' => true,  // enable grouping,
                    'groupedRow' => true,                    // move grouped column to a single grouped row
                    'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
                [
                    'attribute' => 'package_type_id',
                    'value' => function($model, $key, $index){
                        return !empty($model->packageType) ? $model->packageType->package_type_name : '';
                    },
                    'group' => false,
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'attribute' => 'product_order',
                    'hAlign' => 'center'
                ],
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
                            return Url::to(['update-dynamic-form', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['delete-product', 'id' => $key]);
                        }
                    }
                ]
            ],
        ]) ?>
    </div>
    <!-- /.box-body -->
</div>
<?php
$this->registerJsFile(
    '@web/js/yii-confirm.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJs(<<<JS
var methods = {
    getRowKeys: function () {
        var \$grid = $(this);
        var keys = [];
        \$grid.find("tbody tr").each(function () {
            if ($(this).data('key')) {
                keys.push($(this).data('key'));
            }
        });

        return keys;
    },
    initSortable: function() {
        $( "#grid-product-container tbody" ).sortable({
            stop: function( event, ui ) {
                var keys = $('#grid-product-container').gridView('getRowKeys');
                $.ajax({
                    method: "POST",
                    url: "/app/setting/sortable-product",
                    data: { keys: keys },
                    dataType: "json",
                    success: function(data) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        })

                        Toast.fire({
                            type: 'success',
                            title: 'Sortable successfully'
                        })
                        $.pjax.reload({container: '#grid-product-pjax'});
                    },
                    error: function( jqXHR, textStatus, errorThrown) {
                        Swal({
                            type: "error",
                            title: textStatus,
                            text: errorThrown
                        });
                    }
                });
            }
        });
    }
};

(function ($) {
    $.fn.gridView = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
                return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist in jQuery.yiiGridView');
            return false;
        }
    };
})(window.jQuery);
$("a.fancybox").fancybox({});

$("#grid-product-pjax").on("pjax:success", function() {
    methods.initSortable();
});

$(window).on('load', function(){
    methods.initSortable();
});
JS
);
?>
