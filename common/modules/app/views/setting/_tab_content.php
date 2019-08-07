<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/1/2562
 * Time: 9:28
 */
use adminlte\helpers\Html;
use adminlte\widgets\GridView;
use kartik\icons\Icon;

$productOption = $modelProduct->productOption;
?>
<div class="tab-content">
    <!-- ขนาดกระดาษ -->
    <div class="tab-pane active" id="tab-paper-size">
        <p>
            <span class="badge">ขนาดกระดาษ</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-paper-size',
            'dataProvider' => $gridBuilder->getDataPaperSize($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            /* 'beforeHeader' => [
              [
              'columns' => [
              ['content' => Icon::show('file-text-o').'ขนาดกระดาษ', 'options' => ['class' => 'default text-center', 'colspan' => 4]]
              ],
              ]
              ], */
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn',
                ],
                [
                    'attribute' => 'paper_size_name',
                ],
                [
                    'attribute' => 'paper_unit_id',
                    'value' => function($model) {
                        return $model->unit ? $model->unit->unit_name : '';
                    }
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'paper_size_option');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane" id="tab-print_color">
        <p>
            <span class="badge">สีที่พิมพ์</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-print-one-page',
            'dataProvider' => $gridBuilder->getDataColorPrinting($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'label' => 'สี',
                    'attribute' => 'color_printing_name',
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'print_one_page');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane hidden" id="tab-print-two-page">
        <p>
            <span class="badge">พิมพ์สองหน้า</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-print-two-page',
            'dataProvider' => $gridBuilder->getDataColorPrinting($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'label' => 'สี',
                    'attribute' => 'color_printing_name',
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'print_two_page');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
    <div class="tab-pane" id="tab-paper">
        <p>
            <span class="badge">กระดาษ</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-paper',
            'dataProvider' => $gridBuilder->getDataPaper($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'attribute' => 'paper_type_id',
                    'value' => function ($model, $key, $index) {
                        return !empty($model->paperType) ? $model->paperType->paper_type_name : '';
                    },
                    'group' => true,
                    'header' => 'ประเภทกระดาษ'
                ],
                [
                    'attribute' => 'paper_name',
                    'value' => function ($model, $key, $index) {
                        return $model->paper_name;
                    },
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'paper_option');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS,
                ]
            ]
        ]);
        ?>
    </div>
    <div class="tab-pane" id="tab-coating">
        <p>
            <span class="badge">เคลือบ</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-coating',
            'dataProvider' => $gridBuilder->getDataCoating($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'attribute' => 'coating_name',
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'coating_option');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
    <div class="tab-pane" id="tab-diecut">
        <p>
            <span class="badge">ไดคัท</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-diecut',
            'dataProvider' => $gridBuilder->getDataDiecut($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'label' => 'รูปแบบ',
                    'attribute' => 'diecut_group_id',
                    'value' => function($model, $key, $index) {
                        return $model->diecutGroup->diecut_group_name;
                    },
                    'group' => true,
                ],
                [
                    'attribute' => 'diecut_name',
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'diecut_option');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
    <div class="tab-pane" id="tab-fold">
        <p>
            <span class="badge">วิธีพับ</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-fold',
            'dataProvider' => $gridBuilder->getDataFold($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'attribute' => 'fold_name',
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'fold_option');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
    <div class="tab-pane" id="tab-foil-color">
        <p>
            <span class="badge">สีฟอยล์</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-foil-color',
            'dataProvider' => $gridBuilder->getDataFoilColor($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'attribute' => 'foil_color_name',
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'foil_color_option');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
    <div class="tab-pane" id="tab-book-binding">
        <p>
            <span class="badge">วิธีเข้าเล่ม</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-book-binding',
            'dataProvider' => $gridBuilder->getDataBookBinding($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'attribute' => 'book_binding_name',
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'book_binding_option');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
<!--    <div class="tab-pane" id="tab-page-option1">
        <p>
            <span class="badge">พิมพ์หน้าหลัง</span>
        </p>
    </div>
    <div class="tab-pane" id="tab-page-option2">
        <p>
            <span class="badge">พิมพ์หน้าเดียว</span>
        </p>
    </div>-->

    <div class="tab-pane" id="tab-perforate">
        <p>
            <span class="badge">มุมที่เจาะ</span>
        </p>
        <?=
        GridView::widget([
            'id' => 'grid-perforate',
            'dataProvider' => $gridBuilder->getDataPerforate($modelProduct),
            'tableOptions' => [
                'class' => 'small'
            ],
            'striped' => false,
            'hover' => true,
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'attribute' => 'perforate_id',
                    'value' => function($model) {
                        return $model->perforate ? $model->perforate->perforate_name : '';
                    }
                ],
                [
                    'attribute' => 'perforate_option_name',
                ],
                [
                    'attribute' => 'perforate_option_description',
                ],
                [
                    'class' => '\adminlte\widgets\CheckboxColumn',
                    'content' => function ($model, $key, $index) use ($gridBuilder, $productOption, $modelProduct) {
                        $checked = $modelProduct->isChecked($productOption, $key, 'perforate_option');
                        return $gridBuilder->getCheckboxTemplate($key, $checked);
                    },
                    'header' => $gridBuilder->getCheckboxHeaderTemplate(),
                    'rowSelectedClass' => GridView::TYPE_SUCCESS
                ]
            ]
        ]);
        ?>
    </div>
    <!-- /.tab-pane -->
</div>
