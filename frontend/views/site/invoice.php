<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 9/1/2562
 * Time: 20:54
 */
$this->title = 'ใบเสนอราคา';
$this->registerCssFile("@web/css/onlineview.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$this->registerCssFile("@web/css/invoice-style.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
?>
<header id="header" class="onlineview-header hidden-xs hidden-sm">
    <div class="onlineview-header-top headder-fade">
        <div class="onlineview-headertop-content">
            <a href="/Home/Index?emi=NTYwMDk=">
                <img src="/images/santipab_logo.png" title="โปรแกรมบัญชีออนไลน์อัจฉริยะ PEAKENGINE">
            </a>

        </div>
    </div>
    <div class="onlineview-header-bottom">
        <div class="onlineview-headerbottom-content">
            <div class="onlineview-headerbottom-contentLeft">
                <a href="/Income/QuotationDetail?emi=NTYwMDk=&amp;eii=MzI1NDgw">ใบเสนอราคา #QO-20161200001</a>


            </div>
            <div class="onlineview-headerbottom-contentRight">

                <!--<a class="docsetting-toggle">ตั้งค่าเอกสาร</a>
                <a class="onlineview-sharelink btn" onclick="copyUrl()"> คัดลอกลิงค์</a>-->

                <a id="aLinkCopy" class="onlineview-sharelink btn btn-default" data-title="Copied!" data-content="" data-clipboard-target="#foo" onclick="copyUrl(); copyLinkHiddenAlert();">คัดลอกลิงค์</a>

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
                    <section class="customer-heading"><strong><p>ลูกค้า</p> /</strong> <p>Customer</p></section>
                    <section class="customer-detail-iv"><p>สุเทพ เทือกเขา (สำนักงานใหญ่)</p></section>
                </address>
                <address>
                    <section class="customer-heading"><strong><p>ที่อยู่</p> /</strong> <p>Address</p></section>
                    <section class="customer-detail-iv"><p> 12/34 ถ.สาทรใต้ แขวงทุ่งมหาเมฆ เขตพระนคร กรุงเทพมหานคร 10110 </p></section>
                </address>
                <address class="customer-tax-main">
                    <section class="customer-tax"><strong><p>เลขผู้เสียภาษี /</p></strong> <p>Tax ID</p></section>
                    <section class="customer-tax-detail"><p>-</p></section>
                    <section class="email-heading">
                        <strong><p>E:</p></strong>
                    </section>
                    <section class="email-detail">
                        <p>mail@taukkao.com</p>
                    </section>
                </address>
                <address>
                    <section class="customer-contact"><strong><p>ผู้ติดต่อ /</p></strong> <p>Attention</p></section>
                    <section class="customer-contact-detail"><p>คุณสุเทพ  เทือกเขา</p></section>
                    <section class="tel-heading"><strong><p>T:</p></strong></section>
                    <section class="header-tel-detail"><p>089-999-9900</p></section>
                </address>
            </section>
            <aside>
                <section class="number-section">
                    <section class="number-heading">
                        <strong><p>เลขที่ /</p></strong>
                        <p>No.</p>
                    </section>
                    <section class="number-detail">
                        <p id="lbTransactionNumber" style="position: absolute; word-break: break-all; white-space: nowrap;">QO-20161200001</p>
                    </section>
                </section>
                <section class="number-section">
                    <section class="number-heading">
                        <strong><p>วันที่ /</p></strong>
                        <p>Issue</p>
                    </section>
                    <section class="number-detail">
                        <p class="makedateandduedate">01/09/2019</p>
                    </section>
                </section>
                <section class="number-section">
                    <section class="number-heading">
                        <strong><p>ยอมรับ/</p></strong>
                        <p>Valid</p>
                    </section>
                    <section class="number-detail">
                        <p class="makedateandduedate">03/01/2019</p>
                    </section>
                </section>
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
                    <p>บริษัท ตัวอย่าง จำกัด<br> กรุงเทพมหานคร THA</p>
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


                <section class="customer-tax-name">
                    <strong><p>จัดเตรียมโดย / </p></strong>
                    <p>Prepared by</p>
                </section>
                <section class="customer-tax-detailname">
                    <p>demo peak</p>
                </section>
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
            <tr>
                <td class="align-left" style="white-space:nowrap;font-size:16px;">P00003</td>
                <td class="align-left border-tbl-left is-acceptSlashN">บริการติดตั้ง : ติดฟิลม์ และเช็คความสะอาดเครื่อง</td>
                <td class="align-right" style="font-size:16px;">2</td>
                <td class="align-right">500.00</td>


                <td class="align-right border-tbl-left">1,000.00</td>
            </tr>
            <tr>
                <td class="align-left" style="white-space:nowrap;font-size:16px;">P00001</td>
                <td class="align-left border-tbl-left is-acceptSlashN">iPhone 7SE case : iPhone 7SE เคสสีขาวใส มีลายกาตูน</td>
                <td class="align-right" style="font-size:16px;">2</td>
                <td class="align-right">1,500.00</td>


                <td class="align-right border-tbl-left">3,000.00</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>
            <tr>
                <td class="align-left">&nbsp;</td>
                <td class="align-left border-tbl-left">&nbsp;</td>
                <td class="align-right">&nbsp;</td>
                <td class="align-right">&nbsp;</td>

                <td class="align-right border-tbl-left">&nbsp;</td>
            </tr>

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
                <tbody><tr>
                    <td class="grand-total-desc"><strong>ส่วนลด (บาท) /</strong> Discount</td>
                    <td class="align-right grand-total-number border-tbl-left">20.00</td>
                </tr>
                <tr>
                    <td class="grand-total-desc"><strong>ราคาสุทธิสินค้าที่เสียภาษี (บาท) /</strong> Pre-VAT Amount</td>
                    <td class="align-right grand-total-number border-tbl-left">3,975.16</td>
                </tr>
                <tr>
                    <td class="grand-total-desc"><strong>ภาษีมูลค่าเพิ่ม (บาท) /</strong> VAT</td>
                    <td class="align-right grand-total-number border-tbl-left">224.00</td>
                </tr>
                <tr>
                    <td class="grand-total-desc"><strong>จำนวนเงินรวมทั้งสิ้น (บาท) /</strong> Grand Total</td>
                    <td class="align-right grand-total-number grand-total-txt border-tbl-left">3,424.00</td>
                </tr>

                </tbody></table>
            <div class="grand-total-txtbtm" style="border-bottom:1px solid #929292">
                <div>จำนวนเงินรวมทั้งสิ้น</div><span style="font-size:16px;">สามพันสี่ร้อยยี่สิบสี่บาทถ้วน</span>
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
$this->registerJs(<<<JS
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
    }
}
JS
);
?>