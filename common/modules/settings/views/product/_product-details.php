<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 11/1/2562
 * Time: 16:43
 */

use adminlte\helpers\Html;
use adminlte\widgets\GridView;
use yii\helpers\Url;
use kartik\icons\Icon;
?>
<?php /*
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">ขนาดกระดาษ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataPaperSize,
                    'columns' => [
                        ['class' => '\kartik\grid\SerialColumn'],
                        [
                            'header' => 'ชื่อขนาด',
                            'attribute' => 'paper_size_name',
                        ],
                        [
                            'header' => 'รายละเอียด',
                            'attribute' => 'paper_size_description',
                        ],
                        [
                            'header' => 'ขนาด',
                            'value' => function ($model, $key, $index) {
                                return !empty($model['paper_unit_id']) ? $model['paper_size_width'] . 'x' . $model['paper_size_height'] . ' ' . $model['paper_unit_name'] : '';
                            }
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">รูปแบบการพิมพ์</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataPrintOption,
                    'columns' => [
                        ['class' => '\kartik\grid\SerialColumn'],
                        [
                            'header' => 'ชื่อแบบการพิมพ์',
                            'attribute' => 'print_option_name',
                        ],
                        [
                            'header' => 'รายละเอียด',
                            'attribute' => 'print_option_description',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">ประเภทกระดาษ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataPaperType,
                    'columns' => [
                        ['class' => '\kartik\grid\SerialColumn'],
                        [
                            'header' => 'ชื่อประเภท',
                            'attribute' => 'paper_type_name',
                        ],
                        [
                            'header' => 'รายละเอียด',
                            'attribute' => 'paper_type_description',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">วิธีการเคลือบ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataCoatingOption,
                    'columns' => [
                        ['class' => '\kartik\grid\SerialColumn'],
                        [
                            'header' => 'ชื่อรูปแบบการเคลือบ',
                            'attribute' => 'coating_option_name',
                        ],
                        [
                            'header' => 'รายละเอียด',
                            'attribute' => 'coating_option_description',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">วิธีไดคัท</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataDicutOption,
                    'columns' => [
                        ['class' => '\kartik\grid\SerialColumn'],
                        [
                            'header' => 'ชื่อรูปแบบไดคัท',
                            'attribute' => 'dicut_option_name',
                        ],
                        [
                            'header' => 'รายละเอียด',
                            'attribute' => 'dicut_option_description',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">วิธีการพับ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataFoldOption,
                    'columns' => [
                        ['class' => '\kartik\grid\SerialColumn'],
                        [
                            'header' => 'ชื่อแบบการพับ',
                            'attribute' => 'fold_option_name',
                        ],
                        [
                            'header' => 'รายละเอียด',
                            'attribute' => 'fold_option_description',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">สีฟอยล์</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataFoilingOption,
                    'columns' => [
                        ['class' => '\kartik\grid\SerialColumn'],
                        [
                            'header' => 'ชื่อสีฟอยล์',
                            'attribute' => 'foiling_option_name',
                        ],
                        [
                            'header' => 'โค้ดสี',
                            'attribute' => 'foiling_option_color_code',
                            'value' => function ($model, $key, $index) {
                                return !empty($model['foiling_option_color_code']) ?
                                    Html::tag('span', $model['foiling_option_color_code'], ['style' => 'background-color: ' . $model['foiling_option_color_code']]) :
                                    '';
                            },
                            'format' => 'raw'
                        ],
                        [
                            'header' => 'รายละเอียด',
                            'attribute' => 'foiling_option_description',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
 */ ?>
<div class="sp-detail-content">
    <h3>
        <?= Html::encode($model['product_name']) ?>
        <small></small>
    </h3>
    <div class="row">
        <div class="col-sm-2">
            <div class="img-thumbnail img-rounded text-center">
                <?php if ($model['product_icon_path']) : ?>
                    <img src="<?= Url::base(true) . $model->product_icon_base_url . str_replace('\\', '/', $model->product_icon_path); ?>"
                         style="padding:2px;width:100%">
                <?php else: ?>
                    <?= Html::img(Yii::getAlias('@web') . '/images/No_Image_Available.png', ['style' => 'padding:2px;width:100%']) ?>
                <?php endif; ?>
                <div class="small text-muted"></div>
            </div>
        </div>
        <div class="col-sm-5">
            <?= GridView::widget([
                //'id' => 'grid-paper-size',
                'dataProvider' => $dataPaperSize,
                'bordered' => true,
                'condensed' => true,
                'hover' => true,
                'striped' => false,
                'tableOptions' => ['class' => ' kv-table'],
                'layout' => '{items}',
                'beforeHeader' => [
                    [
                        'columns' => [
                            [
                                'content' => Icon::show('file-text-o').'ขนาดกระดาษ',
                                'options' => [
                                    'style' => 'font-size: medium;',
                                    'class' => 'success',
                                    'colspan' => 4
                                ],
                            ],
                        ]
                    ]
                ],
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'header' => 'ชื่อขนาด',
                        'attribute' => 'paper_size_name',
                    ],
                    [
                        'header' => 'รายละเอียด',
                        'attribute' => 'paper_size_description',
                    ],
                    [
                        'header' => 'ขนาด',
                        'value' => function ($model, $key, $index) {
                            return !empty($model['paper_unit_id']) ? $model['paper_size_width'] . 'x' . $model['paper_size_height'] . ' ' . $model['paper_unit_name'] : '';
                        }
                    ],
                ]
            ]); ?>
        </div>
        <div class="col-sm-5">
            <?= GridView::widget([
                //'id' => 'grid-print-option',
                'dataProvider' => $dataPrintOption,
                'bordered' => true,
                'condensed' => true,
                'hover' => true,
                'striped' => false,
                'tableOptions' => ['class' => ' kv-table'],
                'layout' => '{items}',
                'beforeHeader' => [
                    [
                        'columns' => [
                            [
                                'content' => Icon::show('file-text-o').'รูปแบบการพิมพ์',
                                'options' => [
                                    'style' => 'font-size: medium;',
                                    'class' => 'success',
                                    'colspan' => 3
                                ],
                            ],
                        ]
                    ]
                ],
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'header' => 'ชื่อแบบการพิมพ์',
                        'attribute' => 'print_option_name',
                    ],
                    [
                        'header' => 'รายละเอียด',
                        'attribute' => 'print_option_description',
                    ],
                ]
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-5">
            <?= GridView::widget([
                //'id' => 'grid-paper-type',
                'dataProvider' => $dataPaperType,
                'bordered' => true,
                'condensed' => true,
                'hover' => true,
                'striped' => false,
                'tableOptions' => ['class' => ' kv-table'],
                'layout' => '{items}',
                'beforeHeader' => [
                    [
                        'columns' => [
                            [
                                'content' => Icon::show('file-text-o').'ประเภทกระดาษ',
                                'options' => [
                                    'style' => 'font-size: medium;',
                                    'class' => 'success',
                                    'colspan' => 3
                                ],
                            ],
                        ]
                    ]
                ],
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'header' => 'ชื่อประเภท',
                        'attribute' => 'paper_type_name',
                    ],
                    [
                        'header' => 'รายละเอียด',
                        'attribute' => 'paper_type_description',
                    ],
                ]
            ]); ?>
        </div>
        <div class="col-sm-5">
            <?= GridView::widget([
                //'id' => 'grid-coating-option',
                'dataProvider' => $dataCoatingOption,
                'bordered' => true,
                'condensed' => true,
                'hover' => true,
                'striped' => false,
                'tableOptions' => ['class' => ' kv-table'],
                'layout' => '{items}',
                'beforeHeader' => [
                    [
                        'columns' => [
                            [
                                'content' => Icon::show('file-text-o').'วิธีการเคลือบ',
                                'options' => [
                                    'style' => 'font-size: medium;',
                                    'class' => 'success',
                                    'colspan' => 3
                                ],
                            ],
                        ]
                    ]
                ],
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'header' => 'ชื่อรูปแบบการเคลือบ',
                        'attribute' => 'coating_option_name',
                    ],
                    [
                        'header' => 'รายละเอียด',
                        'attribute' => 'coating_option_description',
                    ],
                ]
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-5">
            <?= GridView::widget([
                'dataProvider' => $dataDicutOption,
                'bordered' => true,
                'condensed' => true,
                'hover' => true,
                'striped' => false,
                'tableOptions' => ['class' => ' kv-table'],
                'layout' => '{items}',
                'beforeHeader' => [
                    [
                        'columns' => [
                            [
                                'content' => Icon::show('file-text-o').'ไดคัท',
                                'options' => [
                                    'style' => 'font-size: medium;',
                                    'class' => 'success',
                                    'colspan' => 3
                                ],
                            ],
                        ]
                    ]
                ],
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'header' => 'ชื่อรูปแบบไดคัท',
                        'attribute' => 'dicut_option_name',
                    ],
                    [
                        'header' => 'รายละเอียด',
                        'attribute' => 'dicut_option_description',
                    ],
                ]
            ]); ?>
        </div>
        <div class="col-sm-5">
            <?= GridView::widget([
                'dataProvider' => $dataFoldOption,
                'bordered' => true,
                'condensed' => true,
                'hover' => true,
                'striped' => false,
                'tableOptions' => ['class' => ' kv-table'],
                'layout' => '{items}',
                'beforeHeader' => [
                    [
                        'columns' => [
                            [
                                'content' => Icon::show('file-text-o').'การพับ',
                                'options' => [
                                    'style' => 'font-size: medium;',
                                    'class' => 'success',
                                    'colspan' => 3
                                ],
                            ],
                        ]
                    ]
                ],
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'header' => 'ชื่อแบบการพับ',
                        'attribute' => 'fold_option_name',
                    ],
                    [
                        'header' => 'รายละเอียด',
                        'attribute' => 'fold_option_description',
                    ],
                ]
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-5">
            <?= GridView::widget([
                'dataProvider' => $dataFoilingOption,
                'bordered' => true,
                'condensed' => true,
                'hover' => true,
                'striped' => false,
                'tableOptions' => ['class' => ' kv-table'],
                'layout' => '{items}',
                'beforeHeader' => [
                    [
                        'columns' => [
                            [
                                'content' => Icon::show('file-text-o').'สีฟอยล์',
                                'options' => [
                                    'style' => 'font-size: medium;',
                                    'class' => 'success',
                                    'colspan' => 4
                                ],
                            ],
                        ]
                    ]
                ],
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'header' => 'ชื่อสีฟอยล์',
                        'attribute' => 'foiling_option_name',
                    ],
                    [
                        'header' => 'โค้ดสี',
                        'attribute' => 'foiling_option_color_code',
                        'value' => function ($model, $key, $index) {
                            return !empty($model['foiling_option_color_code']) ?
                                Html::tag('span', $model['foiling_option_color_code'], ['style' => 'background-color: ' . $model['foiling_option_color_code']]) :
                                '';
                        },
                        'format' => 'raw'
                    ],
                    [
                        'header' => 'รายละเอียด',
                        'attribute' => 'foiling_option_description',
                    ],
                ]
            ]); ?>
        </div>
        <div class="col-sm-5">
        </div>
    </div>
</div>