<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 9/1/2562
 * Time: 20:54
 */
use yii\helpers\Url;
use yii\bootstrap\BootstrapPluginAsset;

BootstrapPluginAsset::register($this);

$this->title = 'ใบเสนอราคา';
$this->registerCssFile("@web/css/onlineview.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$this->registerCssFile("@web/css/invoice-style.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$stylecontent = 'style="font-size: 16pt; text-align: center;border-bottom: 0.5px solid black;border-left: 0.5px solid black;border-top: 0.5px solid black; line-height: 0.9;"';
?>
<?= $this->render('invoice_header', ['model' => $model]) ?>
<div class="a4-onlineview">
    <div class="invoice-page iv-olview a4-page-print">
        <content>
            <!-- ข้อมูลที่อยู่บริษัท -->
            <?= $this->render('invoice_enterprise', ['model' => $model]) ?>
            <!-- ข้อมูลที่อยู่ลูกค้า -->
            <?= $this->render('invoice_customer', ['model' => $model]) ?>

            <p style="font-size: 14pt; padding-left: 15px;" >
                บริษัทฯ มีความยินดีขอเสนอราคา ตามรายการต่อ ไปนี้ / We are pleased to submit our quotation as follows
            </p>
            <!-- ข้อมูลสินค้า -->
            <?= $this->render('invoice_product_info', ['model' => $model, 'details' => $details, 'modelDetail' => $modelDetail]) ?>
        </content>
    </div>
</div>

<style>
    .table-custome{
        border: 1px solid !important;
    }
    .row-content{
        border: 1px solid;
        margin-top: 10px;
        min-height: 230px;
    }
    .content-left{
        border-right: 1px solid;
        border-left: 1px solid;
        border-top: 1px solid;
        border-bottom: 1px solid;
        min-height: 306px;
    }
    .content-right{
        min-height: 250px;
        padding: 0px;
        border-right: 1px solid;
        border-top: 1px solid;
        border-bottom: 1px solid;
        padding-top: 15px;
    }
    .detail-right {
        border-bottom: 1px solid;
        height: 60px;
    }
    .detail-right tr td p {
        margin-left: 5px;
    }
    .text-label{
        font-size: 13pt;
        font-weight: bold;
        margin-top: 5px;
    }
    .label-left {
        padding-left: 15px;
        padding-top: 15px;
    }
    @media print {
        img#logo{
            width: 100% !important;
            display: block;
        }
        .row-logo{
            width: 20%;
        }
        .row-info2{
            padding-left: 0px !important;
            width: 100px !important;
        }
        .row-info3 {
            width: 450px !important;
        }
        @page {
            size: A4;
        }

    }

</style>


<?php
$this->registerJsFile(
        '@web/js/clipboard.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJs(<<<JS
var clipboard = new ClipboardJS('.onlineview-sharelink');
clipboard.on('success', function(e) {
    $('#aLinkCopy').tooltip('show');
    e.clearSelection();
    setTimeout(function() {
        $('#aLinkCopy').tooltip('destroy');
    },1000);
});
$(function () {
    //$('[data-toggle="tooltip"]').tooltip()
});
Invoice = {
    print: function() {
        if ($('#aLinkCopy').hasClass('visible')) {
            $('#aLinkCopy').popup('hide');
            setTimeout(function () {
                window.print();
            }, 1000);
        } else {
            window.print();
        }
    },
}
document.title = 'ใบเสนอราคา ' + '{$model->quotation_id}'
JS
);
?>