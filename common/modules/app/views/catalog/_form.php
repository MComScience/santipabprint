<?php

use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\modules\app\models\TblCatalogType;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;
use froala\froalaeditor\FroalaEditorWidget;
use dosamigos\tinymce\TinyMce;
use kartik\icons\Icon;

use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

/* @var $this yii\web\View */
/* @var $model common\modules\app\models\TblCatalog */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->title ?></h3>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="tbl-catalog-form">

            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-product']); ?>

            <div class="col-sm-4 col-sm-offset-4">
                <?= $form->field($model, 'image')->widget(Upload::classname(), [
                    'url' => ['upload-icon'],
                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                    'id' => 'image-preview'
                ])->hint('<span class="text-danger">**ขนาดไฟล์: ไม่เกิน 10MB/ไฟล์</span> ,ชนิดไฟล์: gif, jpeg, png')->label('ภาพสินค้า'); 
                ?>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-12">
                    <?= $form->field($model, 'catalog_type_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TblCatalogType::find()->asArray()->all(), 'catalog_type_id', 'catalog_type_name'),
                        'options' => ['placeholder' => 'เลือกหมวดหมู่'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'theme' => Select2::THEME_BOOTSTRAP,
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-sm-12">
                    <?= $form->field($model, 'catalog_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-sm-12">
                    <?= $form->field($model, 'catalog_detail')->widget(TinyMce::classname(), [
                        'clientOptions' => [
                            'plugins' => [
                                'advlist autolink lists link charmap print preview anchor template emoticons',
                                'searchreplace visualblocks code fullscreen pagebreak nonbreaking imagetools directionality',
                                'insertdatetime media table contextmenu paste colorpicker',
                                'autoresize tabfocus textcolor image',
                            ],
                            'width' => '100%',
                            'branding' => false,
                            'image_advtab' => true,
                            'autoresize_min_height' => 500,
                            "font_formats" => "Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;",
                            'tabfocus_elements' => ':prev,:next',
                            'images_upload_url' => 'tinymce-upload',
                            'images_reuse_filename' => true,
                            'automatic_uploads' => true,
                            'fontsize_formats' => '8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt',
                            'toolbar' => 'emoticons undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontsizeselect | forecolor backcolor | restoredraft fontselect',
                        ],
                        'language' => 'th_TH',
                    ]); ?>
                </div>
            </div>

            <div class="form-group text-right">
                <div class="col-sm-12">
                    <?= Html::a(Icon::show('close') . 'ยกเลิก', ['index'], [
                        'class' => 'btn btn-danger',
                    ]) ?>
                    <?= Html::submitButton(Icon::show('save') . 'บันทึก', [
                        'class' => 'btn btn-success'
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<?php
$this->registerJS(<<<JS

JS
);
?>
