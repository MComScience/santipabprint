<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use common\modules\settings\models\TblProductType;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use mcomscience\bstable\BootstrapTable;
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;
SweetAlert2Asset::register($this);
/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\TblProduct */
/* @var $form yii\widgets\ActiveForm */
$action = Yii::$app->controller->action->id;
$this->registerJs('var action = ' . \yii\helpers\Json::encode($action) . ';', \yii\web\View::POS_HEAD);
?>
<style type="text/css">
    .nowrap {
        white-space: nowrap;
    }
</style>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-product']); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">ข้อมูลสินค้า</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 border-right">
                        <p>
                            <span class="badge badge-primary">รายละเอียดสินค้า</span>
                        </p>
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4">
                                <?= $form->field($model, 'icon')->widget(Upload::classname(), [
                                    'url' => ['upload-icon'],
                                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                                    'id' => 'product-icon'
                                ])->label('ไอคอนสินค้า <button type="button" 
                                class="btn btn-xs btn-default"
                                data-toggle="popover" 
                                data-placement="right"
                                data-html="true"
                                data-content="<small><span class=\'text-danger\'>Notice!</span> หากขนาดภาพใหญ่เกิน <strong>112x112</strong> ระบบจะปรับขนาดให้เหลือ <strong>112x112</strong></small>">
                                  <i class="glyphicon glyphicon-question-sign"></i>
                            </button>') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($model, 'product_id')->textInput([
                                    'maxlength' => true,
                                    'readonly' => true
                                ])->hint('<small class="label bg-yellow">Notice! ระบบจะรันเลขสินค้าให้อัตโนมัติ</small>')
                                    ->label('รหัสสินค้า <button type="button" 
                                class="btn btn-xs btn-default"
                                data-toggle="popover" 
                                data-placement="right"
                                data-html="true"
                                data-content="<small>ตัวอย่างเลขสินค้า</small> <span class=\'label bg-yellow\'>PG.0001</span>">
                                  <i class="glyphicon glyphicon-question-sign"></i>
                            </button>') ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'product_type_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(TblProductType::find()->all(), 'product_type_id', 'product_type_name'),
                                    'options' => [
                                        'placeholder' => 'เลือกประเภทสินค้า...'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                ])->label('ประเภทสินค้า');
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'product_name')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'ชื่อสินค้า'
                                ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'product_description')->widget(\yii\redactor\widgets\Redactor::className(),[
                                    'clientOptions' => [
                                        'plugins' => ['clips', 'fontcolor','imagemanager']
                                    ]
                                ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <?=
                                $form->field($model, 'product_status')->widget(Select2::classname(), [
                                    'data' => [
                                        1 => 'Active',
                                        0 => 'UnActive'
                                    ],
                                    'options' => [
                                        'placeholder' => 'เลือกสถานะ...'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                ])->label('สถานะสินค้า');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <p>
                            <span class="badge badge-primary">รายละเอียดทั่วไป</span>
                        </p>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label for="diecut">
                                        <input type="checkbox" name="diecut" value="0" id="diecut"/>
                                        ไดคัท
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input name="option_name" class="form-control" placeholder="ข้อความ"/>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label for="diecut-required">
                                        <input type="checkbox" name="diecut_required" value="0" id="diecut-required"/>
                                        บังคับ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label for="coating">
                                        <input type="checkbox" name="coating" value="0" id="coating"/>
                                        เคลือบ
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input name="option_name" class="form-control" placeholder="ข้อความ"/>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label for="coating-required">
                                        <input type="checkbox" name="coating_required" value="0" id="coating-required"/>
                                        บังคับ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label for="foil">
                                        <input type="checkbox" name="foil" value="0" id="foil"/>
                                        ฟอยล์
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input name="option_name" class="form-control" placeholder="ข้อความ"/>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label for="foil-required">
                                        <input type="checkbox" name="foil_required" value="0" id="foil-required"/>
                                        บังคับ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label for="embosser">
                                        <input type="checkbox" name="embosser" value="0" id="embosser"/>
                                        ปั๊มนูน
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input name="option_name" class="form-control" placeholder="ข้อความ"/>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label for="embosser-required">
                                        <input type="checkbox" name="embosser_required" value="0" id="embosser-required"/>
                                        บังคับ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab">ขนาด</a>
                                </li>
                                <li>
                                    <a href="#tab_2" data-toggle="tab">การพิมพ์</a>
                                </li>
                                <li>
                                    <a href="#tab_3" data-toggle="tab">ประเภทกระดาษ</a>
                                </li>
                                <li>
                                    <a href="#tab_4" data-toggle="tab">การเคลือบ</a>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        อื่นๆ <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li role="presentation">
                                            <a role="menuitem" href="#tab_5" data-toggle="tab">ไดคัท</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" href="#tab_6" data-toggle="tab">การพับ</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" href="#tab_7" data-toggle="tab">สีฟอยล์</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <!-- ขนาด -->
                                    <p>
                                        <?php if ($model->isNewRecord): ?>
                                            <?= Html::button(Icon::show('plus') . 'เพิ่มรายการ', [
                                                'class' => 'btn btn-primary',
                                                'disabled' => true
                                            ]) ?>
                                        <?php else: ?>
                                            <?= Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-paper-size', 'id' => $model['product_id']], [
                                                'class' => 'btn btn-primary',
                                                'role' => 'modal-remote',
                                                'data-pjax' => '0'
                                            ]) ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php
                                    echo BootstrapTable::widget([
                                        'tableOptions' => ['id' => 'tb-paper-size'],
                                        'hover' => true, // Defaults to true
                                        'bordered' => true, // Defaults to false
                                        'striped' => true, // Defaults to true
                                        'condensed' => true, // Defaults to true
                                        'caption' => '<small class="label bg-yellow">ขนาดกระดาษของสินค้า เช่น 4*6, A4</small>',
                                        'beforeHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                                    ['content' => 'ชื่อขนาด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'รายละเอียด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ขนาด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'datatableOptions' => [
                                            "clientOptions" => [
                                                "ajax" => [
                                                    "url" => Url::base(true) . "/settings/product/data-paper-size",
                                                    "type" => "GET",
                                                    "data" => [
                                                        'product_id' => $model['product_id'],
                                                    ],
                                                ],
                                                "responsive" => true,
                                                "autoWidth" => false,
                                                "deferRender" => true,
                                                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                "language" => array_merge(Yii::$app->params['dt_i18n_th'], [
                                                    "sLengthMenu" => " _MENU_ "
                                                ]),
                                                "columns" => [
                                                    ["data" => "index", "className" => "text-center"],
                                                    //["data" => "paper_size_id", "className" => "text-center"],
                                                    ["data" => "paper_size_name"],
                                                    ["data" => "paper_size_description"],
                                                    ["data" => "paper_size"],
                                                    ["data" => "actions", "orderable" => false, "className" => "text-center nowrap"]
                                                ],
                                            ],
                                            "clientEvents" => [
                                                'error.dt' => 'function ( e, settings, techNote, message ){
                                                    e.preventDefault();
                                                    Swal({
                                                        type: \'error\',
                                                        title: \'Oops...\',
                                                        text: message,
                                                    })
                                                }'
                                            ]
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <p>
                                        <?php if ($model->isNewRecord): ?>
                                            <?= Html::button(Icon::show('plus') . 'เพิ่มรายการ', [
                                                'class' => 'btn btn-primary',
                                                'disabled' => true
                                            ]) ?>
                                        <?php else: ?>
                                            <?= Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-print-option', 'id' => $model['product_id']], [
                                                'class' => 'btn btn-primary',
                                                'role' => 'modal-remote',
                                                'data-pjax' => '0'
                                            ]) ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php
                                    echo BootstrapTable::widget([
                                        'tableOptions' => ['id' => 'tb-print-option'],
                                        'hover' => true, // Defaults to true
                                        'bordered' => true, // Defaults to false
                                        'striped' => true, // Defaults to true
                                        'condensed' => true, // Defaults to true
                                        'caption' => '<small class="label bg-yellow">รูปแบบการพิพ์</small>',
                                        'beforeHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                                    ['content' => 'ชื่อแบบการพิมพ์', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'รายละเอียด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'datatableOptions' => [
                                            "clientOptions" => [
                                                "ajax" => [
                                                    "url" => Url::base(true) . "/settings/product/data-print-option",
                                                    "type" => "GET",
                                                    "data" => [
                                                        'product_id' => $model['product_id'],
                                                    ],
                                                ],
                                                "responsive" => true,
                                                "autoWidth" => false,
                                                "deferRender" => true,
                                                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                "language" => array_merge(Yii::$app->params['dt_i18n_th'], [
                                                    "sLengthMenu" => " _MENU_ "
                                                ]),
                                                "columns" => [
                                                    ["data" => "index", "className" => "text-center"],
                                                    ["data" => "print_option_name"],
                                                    ["data" => "print_option_description"],
                                                    ["data" => "actions", "orderable" => false, "className" => "text-center nowrap"]
                                                ],
                                            ],
                                            "clientEvents" => [
                                                'error.dt' => 'function ( e, settings, techNote, message ){
                                                    e.preventDefault();
                                                    Swal({
                                                        type: \'error\',
                                                        title: \'Oops...\',
                                                        text: message,
                                                    })
                                                }'
                                            ]
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    <p>
                                        <?php if ($model->isNewRecord): ?>
                                            <?= Html::button(Icon::show('plus') . 'เพิ่มรายการ', [
                                                'class' => 'btn btn-primary',
                                                'disabled' => true
                                            ]) ?>
                                        <?php else: ?>
                                            <?= Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-paper-type', 'id' => $model['product_id']], [
                                                'class' => 'btn btn-primary',
                                                'role' => 'modal-remote',
                                                'data-pjax' => '0'
                                            ]) ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php
                                    echo BootstrapTable::widget([
                                        'tableOptions' => ['id' => 'tb-paper-type'],
                                        'hover' => true, // Defaults to true
                                        'bordered' => true, // Defaults to false
                                        'striped' => true, // Defaults to true
                                        'condensed' => true, // Defaults to true
                                        'caption' => '<small class="label bg-yellow">ประเภทกระดาษ</small>',
                                        'beforeHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                                    ['content' => 'ชื่อประเภท', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'รายละเอียด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'datatableOptions' => [
                                            "clientOptions" => [
                                                "ajax" => [
                                                    "url" => Url::base(true) . "/settings/product/data-paper-type",
                                                    "type" => "GET",
                                                    "data" => [
                                                        'product_id' => $model['product_id'],
                                                    ],
                                                ],
                                                "responsive" => true,
                                                "autoWidth" => false,
                                                "deferRender" => true,
                                                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                "language" => array_merge(Yii::$app->params['dt_i18n_th'], [
                                                    "sLengthMenu" => " _MENU_ "
                                                ]),
                                                "columns" => [
                                                    ["data" => "index", "className" => "text-center"],
                                                    ["data" => "paper_type_name"],
                                                    ["data" => "paper_type_description"],
                                                    ["data" => "actions", "orderable" => false, "className" => "text-center nowrap"]
                                                ],
                                            ],
                                            "clientEvents" => [
                                                'error.dt' => 'function ( e, settings, techNote, message ){
                                                    e.preventDefault();
                                                    Swal({
                                                        type: \'error\',
                                                        title: \'Oops...\',
                                                        text: message,
                                                    })
                                                }'
                                            ]
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="tab-pane" id="tab_4">
                                    <p>
                                        <?php if ($model->isNewRecord): ?>
                                            <?= Html::button(Icon::show('plus') . 'เพิ่มรายการ', [
                                                'class' => 'btn btn-primary',
                                                'disabled' => true
                                            ]) ?>
                                        <?php else: ?>
                                            <?= Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-coating-option', 'id' => $model['product_id']], [
                                                'class' => 'btn btn-primary',
                                                'role' => 'modal-remote',
                                                'data-pjax' => '0'
                                            ]) ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php
                                    echo BootstrapTable::widget([
                                        'tableOptions' => ['id' => 'tb-coating-option'],
                                        'hover' => true, // Defaults to true
                                        'bordered' => true, // Defaults to false
                                        'striped' => true, // Defaults to true
                                        'condensed' => true, // Defaults to true
                                        'caption' => '<small class="label bg-yellow">วิธีการเคลือบ</small>',
                                        'beforeHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                                    ['content' => 'ชื่อรูปแบบการเคลือบ', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'รายละเอียด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'datatableOptions' => [
                                            "clientOptions" => [
                                                "ajax" => [
                                                    "url" => Url::base(true) . "/settings/product/data-coating-option",
                                                    "type" => "GET",
                                                    "data" => [
                                                        'product_id' => $model['product_id'],
                                                    ],
                                                ],
                                                "responsive" => true,
                                                "autoWidth" => false,
                                                "deferRender" => true,
                                                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                "language" => array_merge(Yii::$app->params['dt_i18n_th'], [
                                                    "sLengthMenu" => " _MENU_ "
                                                ]),
                                                "columns" => [
                                                    ["data" => "index", "className" => "text-center"],
                                                    ["data" => "coating_option_name"],
                                                    ["data" => "coating_option_description"],
                                                    ["data" => "actions", "orderable" => false, "className" => "text-center nowrap"]
                                                ],
                                            ],
                                            "clientEvents" => [
                                                'error.dt' => 'function ( e, settings, techNote, message ){
                                                    e.preventDefault();
                                                    Swal({
                                                        type: \'error\',
                                                        title: \'Oops...\',
                                                        text: message,
                                                    })
                                                }'
                                            ]
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="tab-pane" id="tab_5">
                                    <p>
                                        <?php if ($model->isNewRecord): ?>
                                            <?= Html::button(Icon::show('plus') . 'เพิ่มรายการ', [
                                                'class' => 'btn btn-primary',
                                                'disabled' => true
                                            ]) ?>
                                        <?php else: ?>
                                            <?= Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-dicut-option', 'id' => $model['product_id']], [
                                                'class' => 'btn btn-primary',
                                                'role' => 'modal-remote',
                                                'data-pjax' => '0'
                                            ]) ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php
                                    echo BootstrapTable::widget([
                                        'tableOptions' => ['id' => 'tb-dicut-option'],
                                        'hover' => true, // Defaults to true
                                        'bordered' => true, // Defaults to false
                                        'striped' => true, // Defaults to true
                                        'condensed' => true, // Defaults to true
                                        'caption' => '<small class="label bg-yellow">วิธีการไดคัท</small>',
                                        'beforeHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                                    ['content' => 'ชื่อรูปแบบไดคัท', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'รายละเอียด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'datatableOptions' => [
                                            "clientOptions" => [
                                                "ajax" => [
                                                    "url" => Url::base(true) . "/settings/product/data-dicut-option",
                                                    "type" => "GET",
                                                    "data" => [
                                                        'product_id' => $model['product_id'],
                                                    ],
                                                ],
                                                "responsive" => true,
                                                "autoWidth" => false,
                                                "deferRender" => true,
                                                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                "language" => array_merge(Yii::$app->params['dt_i18n_th'], [
                                                    "sLengthMenu" => " _MENU_ "
                                                ]),
                                                "columns" => [
                                                    ["data" => "index", "className" => "text-center"],
                                                    ["data" => "dicut_option_name"],
                                                    ["data" => "dicut_option_description"],
                                                    ["data" => "actions", "orderable" => false, "className" => "text-center nowrap"]
                                                ],
                                            ],
                                            "clientEvents" => [
                                                'error.dt' => 'function ( e, settings, techNote, message ){
                                                    e.preventDefault();
                                                    Swal({
                                                        type: \'error\',
                                                        title: \'Oops...\',
                                                        text: message,
                                                    })
                                                }'
                                            ]
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="tab-pane" id="tab_6">
                                    <p>
                                        <?php if ($model->isNewRecord): ?>
                                            <?= Html::button(Icon::show('plus') . 'เพิ่มรายการ', [
                                                'class' => 'btn btn-primary',
                                                'disabled' => true
                                            ]) ?>
                                        <?php else: ?>
                                            <?= Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-fold-option', 'id' => $model['product_id']], [
                                                'class' => 'btn btn-primary',
                                                'role' => 'modal-remote',
                                                'data-pjax' => '0'
                                            ]) ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php
                                    echo BootstrapTable::widget([
                                        'tableOptions' => ['id' => 'tb-fold-option'],
                                        'hover' => true, // Defaults to true
                                        'bordered' => true, // Defaults to false
                                        'striped' => true, // Defaults to true
                                        'condensed' => true, // Defaults to true
                                        'caption' => '<small class="label bg-yellow">วิธีการพับ</small>',
                                        'beforeHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                                    ['content' => 'ชื่อแบบการพับ', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'รายละเอียด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'datatableOptions' => [
                                            "clientOptions" => [
                                                "ajax" => [
                                                    "url" => Url::base(true) . "/settings/product/data-fold-option",
                                                    "type" => "GET",
                                                    "data" => [
                                                        'product_id' => $model['product_id'],
                                                    ],
                                                ],
                                                "responsive" => true,
                                                "autoWidth" => false,
                                                "deferRender" => true,
                                                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                "language" => array_merge(Yii::$app->params['dt_i18n_th'], [
                                                    "sLengthMenu" => " _MENU_ "
                                                ]),
                                                "columns" => [
                                                    ["data" => "index", "className" => "text-center"],
                                                    ["data" => "fold_option_name"],
                                                    ["data" => "fold_option_description"],
                                                    ["data" => "actions", "orderable" => false, "className" => "text-center nowrap"]
                                                ],
                                            ],
                                            "clientEvents" => [
                                                'error.dt' => 'function ( e, settings, techNote, message ){
                                                    e.preventDefault();
                                                    Swal({
                                                        type: \'error\',
                                                        title: \'Oops...\',
                                                        text: message,
                                                    })
                                                }'
                                            ]
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="tab-pane" id="tab_7">
                                    <p>
                                        <?php if ($model->isNewRecord): ?>
                                            <?= Html::button(Icon::show('plus') . 'เพิ่มรายการ', [
                                                'class' => 'btn btn-primary',
                                                'disabled' => true
                                            ]) ?>
                                        <?php else: ?>
                                            <?= Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create-foiling-option', 'id' => $model['product_id']], [
                                                'class' => 'btn btn-primary',
                                                'role' => 'modal-remote',
                                                'data-pjax' => '0'
                                            ]) ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php
                                    echo BootstrapTable::widget([
                                        'tableOptions' => ['id' => 'tb-foiling-option'],
                                        'hover' => true, // Defaults to true
                                        'bordered' => true, // Defaults to false
                                        'striped' => true, // Defaults to true
                                        'condensed' => true, // Defaults to true
                                        'caption' => '<small class="label bg-yellow">สีฟอยล์</small>',
                                        'beforeHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                                    ['content' => 'ชื่อสีฟอยล์', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'โค้ดสี', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'รายละเอียด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'datatableOptions' => [
                                            "clientOptions" => [
                                                "ajax" => [
                                                    "url" => Url::base(true) . "/settings/product/data-foiling-option",
                                                    "type" => "GET",
                                                    "data" => [
                                                        'product_id' => $model['product_id'],
                                                    ],
                                                ],
                                                "responsive" => true,
                                                "autoWidth" => false,
                                                "deferRender" => true,
                                                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                "language" => array_merge(Yii::$app->params['dt_i18n_th'], [
                                                    "sLengthMenu" => " _MENU_ "
                                                ]),
                                                "columns" => [
                                                    ["data" => "index", "className" => "text-center"],
                                                    ["data" => "foiling_option_name"],
                                                    ["data" => "foiling_option_color_code", "className" => "text-center"],
                                                    ["data" => "foiling_option_description"],
                                                    ["data" => "actions", "orderable" => false, "className" => "text-center nowrap"]
                                                ],
                                            ],
                                            "clientEvents" => [
                                                'error.dt' => 'function ( e, settings, techNote, message ){
                                                    e.preventDefault();
                                                    Swal({
                                                        type: \'error\',
                                                        title: \'Oops...\',
                                                        text: message,
                                                    })
                                                }'
                                            ]
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <?php if ($action === 'create'): ?>
                        <?= Html::a(Icon::show('close') . 'ยกเลิก', ['/settings/product/index'], [
                            'class' => 'btn btn-default'
                        ]); ?>
                    <?php else: ?>
                        <?= Html::a(Icon::show('close') . 'ปิด', ['/settings/product/index'], [
                            'class' => 'btn btn-default'
                        ]); ?>
                    <?php endif; ?>
                    <?= Html::a(Icon::show('save') . 'บันทึก', 'javascript:void(0);', [
                        'class' => 'btn btn-success on-submit',
                        'onclick' => 'return Product.onSubmit();'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?= $this->render('modal') ?>
<?php
$this->registerJs(<<<JS

JS
);
$this->registerJsFile(
    '@web/js/product.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>


