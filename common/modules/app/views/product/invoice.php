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
?>
    <header id="header" class="onlineview-header hidden-xs hidden-sm">
        <div class="onlineview-header-bottom">
            <div class="onlineview-headerbottom-content">
                <div class="onlineview-headerbottom-contentLeft">
                    <a href="<?= Url::to(['/app/product/quo', 'q' => $model['quotation_id']]) ?>">ใบเสนอราคา
                        #<?= $model['quotation_id']; ?>
                    </a>
                </div>
                <div class="onlineview-headerbottom-contentRight">
                    <a id="aLinkCopy"
                       class="onlineview-sharelink btn btn-default"
                       data-title="Copied!"
                       data-toggle="tooltip"
                       data-placement="bottom"
                       data-clipboard-text="<?= Url::base(true).Url::to(['/app/product/quo', 'q' => $model['quotation_id']]) ?>">คัดลอกลิงค์</a>
                    <div class="btn btn-danger" onclick="Invoice.print('printableArea')">พิมพ์</div>
                </div>
            </div>
        </div>
    </header>
    <div class="a4-onlineview">
        <div class="invoice-page iv-olview a4-page-print">
            <div id="emptydiv" style="display:none;width:697.69px;height:90px;"></div>
            <!-- Head -->
            <header>
                <h1>ใบเสนอราคา <br>Quotation</h1>
                <section class="invoice-page-detail">
                    <p id="fpheadertype" class="pheadersetdoc">&nbsp;</p>
                    <p id="fpheadersetdoc" class="pheadertype">( ต้นฉบับ / original )</p>
                </section>
                <span class="onlineview-logo-qrcode-header">
                        <img id="logo" src="/images/santipab_logo.png">
                </span>
            </header>

            <div class="clear"></div>

            <article id="contactDiv">
                <section class="customer-left">
                    <address>
                        <section class="customer-heading"><strong><p>ลูกค้า</p> /</strong>
                            <p>Customer</p></section>
                        <section class="customer-detail-iv"><p><?= $model['quotation_customer_name']; ?></p></section>
                    </address>
                    <address>
                        <section class="customer-heading"><strong><p>ที่อยู่</p> /</strong>
                            <p>Address</p></section>
                        <section class="customer-detail-iv"><p> <?= $model['quotation_customer_address']; ?></p>
                        </section>
                    </address>
                    <address class="customer-tax-main">
                        <section class="customer-tax"><strong><p>เลขผู้เสียภาษี /</p></strong>
                            <p>Tax ID</p></section>
                        <section class="customer-tax-detail"><p>-</p></section>
                        <section class="email-heading">
                            <strong><p>E:</p></strong>
                        </section>
                        <section class="email-detail">
                            <p><?= $model['quotation_customer_email']; ?></p>
                        </section>
                    </address>
                    <address>
                        <section class="customer-contact"><strong><p>ผู้ติดต่อ /</p></strong><p>Attention</p></section>
                        <section class="customer-contact-detail"><p>คุณสุเทพ เทือกเขา</p></section>
                        <section class="tel-heading"><strong><p>T:</p></strong></section>
                        <section class="header-tel-detail"><p><?= $model['quotation_customer_tel']; ?></p></section>
                    </address>
                </section>
                <aside>
                    <section class="number-section">
                        <section class="number-heading">
                            <strong><p>เลขที่ /</p></strong>
                            <p>No.</p>
                        </section>
                        <section class="number-detail">
                            <p id="lbTransactionNumber"
                               style="position: absolute; word-break: break-all; white-space: nowrap;">
                                <?= $model['quotation_id']; ?>
                            </p>
                        </section>
                    </section>
                    <section class="number-section">
                        <section class="number-heading">
                            <strong><p>วันที่ /</p></strong>
                            <p>Issue</p>
                        </section>
                        <section class="number-detail">
                            <p class="makedateandduedate"><?= Yii::$app->formatter->asDate($model['created_at'], 'php:d/m/Y'); ?></p>
                        </section>
                    </section>
                    <!--<section class="number-section">
                        <section class="number-heading">
                            <strong><p>ยอมรับ/</p></strong>
                            <p>Valid</p>
                        </section>
                        <section class="number-detail">
                            <p class="makedateandduedate">-</p>
                        </section>
                    </section>-->
                    <section class="number-section">
                        <section class="number-heading">
                            <strong><p>อ้างอิง </p></strong>
                            <p>/ Ref.</p>

                        </section>
                        <section class="number-detail">
                            <p id="refText" style="word-break: break-all; white-space: nowrap;">-</p>
                        </section>
                    </section>


                </aside>
            </article>

            <article id="issuerDiv" class="article-second">
                <section class="issuer-section">
                    <section class="issuer-heading">
                        <strong><p class="is-nowarp">ผู้ออก</p></strong>
                        <br>
                        <p class="is-nowarp">issuer</p>
                    </section>
                    <section class="issuer-detail">
                        <p>บริษัท สันติภาพแพ็คพริ้นท์ จำกัด<br> กรุงเทพมหานคร THA</p>
                    </section>
                </section>
                <aside class="tax-section">
                    <section class="customer-tax-name">
                        <strong><p>เลขผู้เสียภาษี /</p></strong>
                        <p>Tax ID</p>
                    </section>
                    <section class="customer-tax-detailname">
                        <p>-</p>
                    </section>


                    <!--<section class="customer-tax-name">
                        <strong><p>จัดเตรียมโดย / </p></strong>
                        <p>Prepared by</p>
                    </section>
                    <section class="customer-tax-detailname">
                        <p>demo peak</p>
                    </section>-->
                    <section class="tel-heading">
                        <strong><p>T:</p></strong>
                    </section>
                    <section class="tel-detail">
                        <p>-</p>
                    </section>
                    <section class="email-heading">
                        <strong><p>E:</p></strong>
                    </section>
                    <section class="email-detail">
                        <p>-</p>
                    </section>
                    <div class="clear"></div>
                    <section class="web-heading">
                        <strong><p>W:</p></strong>
                    </section>
                    <section class="web-detail">
                        <p>-</p>
                    </section>
                </aside>
            </article>

            <!-- Body -->
            <table class="table-detail">
                <thead>
                    <tr>
                        <th class="table-detail-number">
                            <strong>รหัส</strong>
                            <br><span>ID no.</span>
                        </th>
                        <th class="table-detail-description border-tbl-left">
                            <strong>คำอธิบาย</strong>
                            <br><span>Description</span>
                        </th>
                        <th class="table-detail-quantity">
                            <strong>จำนวน</strong>
                            <br><span>Quantity</span>
                        </th>
                        <th class="table-detail-unitprice align-left">
                            <strong>ราคาต่อหน่วย</strong>
                            <br><span>Unit Price</span>
                        </th>


                        <th class="table-detail-taxamount border-tbl-left">
                            <strong>มูลค่าก่อนภาษี</strong>
                            <br>
                            <span>Pre-Tax Amount</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                    <tr>
                        <td class="align-left" style="white-space:nowrap;font-size:16px;"><?= $item['product_id']; ?></td>
                        <td class="align-left border-tbl-left is-acceptSlashN"><?= $item['details']; ?></td>
                        <td class="align-right" style="font-size:16px;"><?= Yii::$app->formatter->format($item['data']['cust_quantity'], ['decimal', 0]) ?></td>
                        <td class="align-right"><?= Yii::$app->formatter->format($item['data']['final_price'], ['decimal', 2]) ?></td>


                        <td class="align-right border-tbl-left">1,000.00</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <section class="total-footer">
                <ul>
                    <li><strong>หมายเหตุ /</strong> Remarks</li>
                    <li>

                        -
                    </li>
                </ul>
                <table class="grand-total">
                    <tbody>
                    <tr>
                        <td class="grand-total-desc"><strong>ส่วนลด (บาท) /</strong> Discount</td>
                        <td class="align-right grand-total-number border-tbl-left">0.00</td>
                    </tr>
                    <tr>
                        <td class="grand-total-desc"><strong>ราคาสุทธิสินค้าที่เสียภาษี (บาท) /</strong> Pre-VAT Amount
                        </td>
                        <td class="align-right grand-total-number border-tbl-left">0.00</td>
                    </tr>
                    <tr>
                        <td class="grand-total-desc"><strong>ภาษีมูลค่าเพิ่ม (บาท) /</strong> VAT</td>
                        <td class="align-right grand-total-number border-tbl-left">0.00</td>
                    </tr>
                    <tr>
                        <td class="grand-total-desc"><strong>จำนวนเงินรวมทั้งสิ้น (บาท) /</strong> Grand Total</td>
                        <td class="align-right grand-total-number grand-total-txt border-tbl-left"><?= Yii::$app->formatter->format($summary, ['decimal', 2]) ?></td>
                    </tr>

                    </tbody>
                </table>
                <div class="grand-total-txtbtm" style="border-bottom:1px solid #929292">
                    <div>จำนวนเงินรวมทั้งสิ้น</div>
                    <span style="font-size:16px;"><?= Yii::$app->NumberThai->convertBaht($summary); ?></span>
                </div>

            </section>


            <!-- Bottom -->

            <div class="btm-line"></div>
            <!--<article class="payment-footer clear-btm-line">
                <section class="payment-hdd float-left"><strong>การชำระเงิน /</strong> Payment</section>
                <div class="clear"></div>
                <table class="tb-payment float-left">
                    <tbody><tr>
                        <th class="tb-payment-bank-name align-left">ธนาคาร</th>
                        <th class="tb-payment-account-name align-left">ชื่อบัญชี</th>
                        <th class="tb-payment-bank-number align-left">เลขที่บัญชี</th>
                    </tr>
                    <tr>
                        <td>• ไทยพาณิชย์</td>
                        <td>บริษัท ตัวอย่างใหม่ จำกัด</td>
                        <td>1234567890</td>
                    </tr>


                    </tbody></table>

            </article>-->

            <aside class="sign-section">
                <div>
                    <section class="approved-by"><strong>อนุมัติโดย /</strong> Approved by</section>
                    ......................................................
                    <section class="d-date">
                        <p>วันที่ / Date</p>
                        <div class="date-approved">&nbsp;01/09/2019</div>
                        <div class="date-approved-empty">................................</div>
                    </section>
                </div>


                <div>
                    <section class="accepted-by"><strong>ยอมรับใบเสนอราคา /</strong> Accepted by</section>
                    ......................................................
                    <section class="d-date">
                        <p>วันที่ / Date</p>
                        <div></div>
                    </section>
                    ..................................
                </div>

            </aside>


            <div class="clear"></div>


        </div>

    </div>
<?php
$this->registerJsFile(
    '@web/js/clipboard.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
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
JS
);
?>