<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div>
    <table width="100%" style="border: 1px solid" >
        <thead>
            <tr style="border: 1px solid;">
                <th style="text-align: center;border-right: 1px solid;width: 7%;font-size: 14pt;font-weight: bold;">
                    <p>ลำดับที่</p>
                    <p>Item</p>
                </th>
                <th style="text-align: center;border-right: 1px solid;width: 48%;font-size: 14pt;font-weight: bold;">
                    <p>รายการ</p>
                    <p>Description</p>
                </th>
                <th style="text-align: center;border-right: 1px solid;width: 15%;font-size: 14pt;font-weight: bold;">
                    <p>จำนวน</p>
                    <p>Quantity</p>
                </th>
                <th style="text-align: center;border-right: 1px solid;width: 15%;font-size: 14pt;font-weight: bold;">
                    <p>ราคา/หน่วย</p>
                    <p>Unit Price</p>
                </th>
                <th style="text-align: center;width: 15%;font-size: 14pt;font-weight: bold;">
                    <p>จำนวนเงิน</p>
                    <p>Amount</p>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $index => $item) : ?>
            <?php 
                $vat = ($item['data']['final_price'] / 100) * 7;
            ?>
                <tr style="border: 1px solid;height: 300px;">
                    <td style="border-right: 1px solid;text-align:center;font-size: 13pt;white-space: pre-line;">
                        <?= ($index + 1) ?>
                    </td>
                    <td style="border-right: 1px solid;font-size: 13pt;padding-left: 5px;white-space: pre-line;">
                        <?= $item['details']; ?>   
                    </td>
                    <td style="border-right: 1px solid;text-align: center;font-size: 13pt;white-space: pre-line;">
                        <!--จำนวน-->
                        <?= Yii::$app->formatter->format($item['data']['cust_quantity'], ['decimal', 0]) ?>
                    </td>
                    <td style="border-right: 1px solid;text-align: right;font-size: 13pt;white-space: pre-line;">
                        <!--ราคา/ต่อหน่วย  -->
                        <?= Yii::$app->formatter->format($item['data']['final_price'] / $item['data']['cust_quantity'], ['decimal', 2]) ?>&nbsp;
                    </td>
                    <td style="text-align: right;font-size: 13pt;white-space: pre-line;">
                        <!--จำนวนเงิน-->
                        <?= Yii::$app->formatter->format($summary, ['decimal', 2]) ?>&nbsp;
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr style="border: 1px solid;">
                <td colspan="3" rowspan="2">
                    <p style="font-weight: bold">&nbsp;&nbsp;หมายเหตุ</p>
                    <p>&nbsp;&nbsp; * ราคานี้รวมภาษีมูลค่าเพิ่มแล้ว / VAT Included</p>
                </td>
                <td style="border-left: 1px solid;font-weight: bold;">
                    <p>&nbsp;&nbsp;รวม</p>
                    <p>&nbsp;&nbsp;Total</p>
                </td>
                <td style="border-left: 1px solid;text-align: right;font-size: 13pt;vertical-align: middle;">
                    <?= Yii::$app->formatter->format($summary, ['decimal', 2]) ?> &nbsp;&nbsp;
                </td>
            </tr>
            <tr style="border: 1px solid;">
                <td style="font-weight: bold;vertical-align: middle;">
                    <p>&nbsp;&nbsp;ภาษีมูลค่าเพิ่ม (7%)</p>
                    <p>&nbsp;&nbsp;Vat (7%)</p>
                </td>
                <td style="border-left: 1px solid;text-align: right;font-size: 13pt;vertical-align: middle;">
                    <?= Yii::$app->formatter->format($vat, ['decimal', 2]) ?>&nbsp;&nbsp;
                </td>
            </tr>
            <tr style="border: 1px solid;">
                <td colspan="3" style="font-size: 14pt; text-align: center;font-weight: bold; vertical-align: middle;">
                    <p><?= Yii::$app->NumberThai->convertBaht($summary + $vat); ?> </p>
                </td>
                <td style="border-left: 1px solid;font-weight: bold;vertical-align: middle;">
                    <p>&nbsp;&nbsp;รวมทั้งสิ้น</p>
                    <p>&nbsp;&nbsp;Grand Total</p>
                </td>
                <td style="border-left: 1px solid;text-align: right;font-size: 13pt;vertical-align: middle;">
                    <?= Yii::$app->formatter->format($summary + $vat, ['decimal', 2]) ?>&nbsp;&nbsp;
                </td>
            </tr>
        </tbody>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr style="font-size: 13pt; font-weight: bold;">
            <td width = "65%" style="border-left: 1px solid;border-right: 1px solid;" >
                &nbsp;&nbsp;( สำหรับลูกค้า / For customer only )
            </td>
            <td width ="35%" style="border-right: 1px solid;">

            </td>
        </tr>
        <tr style="font-size: 13pt;">
            <td width="65%" style="border-left: 1px solid;border-right: 1px solid;">
                &nbsp;&nbsp;บริษัทฯ ตกลงสั่งซื้อและว่าจ้างตามรายการในใบเสนอราคาฉบับนี้
            </td>
            <td width="35%" style="text-align: center;border-right: 1px solid;" >
                <p>
                    ขอแสดงความนับถือ
                </p>
                <p>
                    You sincerely
                </p>
            </td>
        </tr>
        <tr style="font-size: 13pt;  border-bottom: 1px solid;">
            <td width = "65%" style="padding-left: 5%;border-left: 1px solid;border-right: 1px solid;" >
                <p style="padding-left: 5;">
                    ลงชื่อ&nbsp;&nbsp;(Signature)&nbsp;__________________________&nbsp;ผู้สั่งซื้อ&nbsp;(Purchaser)
                </p>
                <p style="padding-left: 30%;">
                    ( &nbsp;&nbsp;<?= $model['quotation_customer_name'] ?>&nbsp;&nbsp;) 

                </p>
            </td>
            <td width = "35%" style="border-left: 1px solid;border-right: 1px solid;">
                <p style="text-align: center">
                    _____________________ 
                </p>
                <p style="text-align: center; ">
                    (&nbsp;&nbsp;ดวงพร พันธ์พิกุล&nbsp;&nbsp;)
                </p>
            </td>
        </tr>
    </table>
</div>
