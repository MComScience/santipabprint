<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 13/1/2562
 * Time: 15:03
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

$this->title = 'ตั้งค่าใบเสนอราคา';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/settings/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/checkbox-style.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$template = "<div class=\"checkbox\">
              <label>
                {input}\n
                <span class=\"cr\"><i class=\"cr-icon glyphicon glyphicon-ok\"></i></span>
                {label}\n
              </label>
            </div>\n{error}\n{hint}";
?>
    <style type="text/css">
        .padding-v-sm {
            padding-top: 5px;
            padding-bottom: 10px;
        }

        .line-dashed {
            background-color: transparent;
            border-bottom: 1px dashed #dee5e7 !important;
        }
    </style>
<?= $this->render('@common/modules/settings/views/default/menu'); ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $this->title ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <span class="input-icon">
                        <input type="text" class="form-control" id="form-search" placeholder="ค้นหาชื่อสินค้า">
                    </span>
                </div>
            </div>
            <div id="product-container">
                <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-quotation']); ?>
                <?php foreach ($settings as $index => $setting) { ?>
                    <section>
                        <div class="product-list">
                            <div class="row product-name">
                                <div class="col-sm-4">
                                    <?php echo $form->field($setting, "[$index]product_name", [
                                        'staticValue' => Html::tag('span', $setting->product->product_name, [
                                            'class' => 'badge badge-' . $setting->product->product_name
                                        ])
                                    ])->staticInput()->label(false); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <?php echo $form->field($setting, "[$index]coating")->checkbox([
                                        'template' => $template
                                    ])->label('การเคลือบ'); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo $form->field($setting, "[$index]dicut")->checkbox([
                                        'template' => $template
                                    ])->label('ไดคัท'); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo $form->field($setting, "[$index]fold")->checkbox([
                                        'template' => $template
                                    ])->label('การพับ'); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo $form->field($setting, "[$index]foiling")->checkbox([
                                        'template' => $template
                                    ])->label('ฟอยล์'); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo $form->field($setting, "[$index]embosser")->checkbox([
                                        'template' => $template
                                    ])->label('ปั๊มนูน'); ?>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="padding-v-sm">
                        <div class="line line-dashed"></div>
                    </div>
                <?php } ?>
                <div class="form-group text-right">
                    <?= Html::submitButton(Icon::show('save').'บันทึก', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?php
$this->registerJs(<<<JS
$("#form-search")
    .keyup(function () {
        var term = $.trim(this.value);
        if (term === "") {
            $('.product-name')
                .parent()
                .show();
        } else {
            $('.product-name')
                .parent()
                .hide();
            
            $('.product-name span[class*="badge-' + term + '"]')
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .map(function() {
                    if ($(this).hasClass('product-list')){
                        $(this).show();
                    }
                });
        }
    });
    var \$form = $('#form-quotation');
    \$form.on('beforeSubmit', function() {
        var data = \$form.serialize();
        var \$btn = $('#form-quotation button[type="submit"]').button('loading');
        $.ajax({
            url: \$form.attr('action'),
            type: \$form.attr('method'),
            data: data,
            success: function (response) {
                // Implement successful
                if (response.success) {
                    swal({
                        type: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    \$btn.button('reset');
                } else {
                    \$btn.button('reset');
                    $.each(response.validate, function (key, val) {
                        $(\$form).yiiActiveForm('updateAttribute', key, [val]);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                \$btn.button('reset');
                Swal({
                    type: 'error',
                    title: textStatus,
                    text: errorThrown,
                });
            }
        });
        return false; // prevent default submit
    });
JS
);
?>