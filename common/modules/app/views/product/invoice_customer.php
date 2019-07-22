<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table width="100%">
    <tbody>
        <tr>
            <td style="width:60%">
                <div class="content-left">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td colspan="2"> 
                                    <p style="margin-left: 15px;margin-top: 15px;font-size: 14pt;font-weight: bold;">
                                        ชื่อลูกค้า/ บริษัท
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <p style="margin-left: 15px;font-size: 14pt;">Customer :</p>
                                </td>
                                <td>
                                    <p style="font-size: 14pt;">
                                        <?= $model['quotation_customer_name'] ?>
                                    </p>
                                </td>
                            </tr>
                             <tr>
                                <td style="width: 30%">
                                    <p style="margin-left: 15px;font-size: 14pt;padding-top: 10px;">ที่อยู่ :</p>
                                </td>
                                <td>
                                    <p style="font-size: 14pt;">
                                        <?= $model['quotation_customer_address'] ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <p style="margin-left: 15px;font-size: 14pt;padding-top: 40px;">โทร :</p>
                                </td>
                                <td>
                                    <p style="font-size: 14pt;">
                                        <?php echo empty($model->quotation_customer_tel) ? '-' : $model->quotation_customer_tel ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <p style="margin-left: 15px;font-size: 14pt;padding-top: 10px;">แฟกซ์ : </p>
                                </td>
                                <td>
                                    <p style="font-size: 14pt;">
                                        <?php echo empty($model->quotation_customer_fax) ? '-' : $model->quotation_customer_fax ?> 
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
            <td style="width: 40%;">
                <div class="content-right">
                    <div class="detail-right">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td  style="width: 30%" >
                                        <p class="text-label" style="margin-top: 0px;">เลขที่</p>
                                        <p class="text-label"> No.</p>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <?= $model['quotation_id'] ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="detail-right">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td  style="width: 30%">
                                        <p class="text-label">วันที่</p>
                                        <p class="text-label"> Date.</p>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <?php echo Yii::$app->formatter->asDate($model['created_at'], 'php:d M Y') ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="detail-right">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="text-label">เงื่อนไขการชำระเงิน</p>
                                        <p class="text-label"> Term of payment.</p>
                                    </td>
                                    <td style="vertical-align: middle">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="detail-right">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width: 60%">
                                        <p class="text-label">กำหนดยืนราคาถึงวันที่</p>
                                        <p class="text-label">  Validity Date.</p>
                                    </td>
                                    <td style="vertical-align: middle">
                                        -
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="detail-right" style="border-bottom: 0px;height: 49px">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width: 40%">
                                        <p class="text-label">กำหนดการส่งงาน</p>
                                        <p class="text-label"> Delivery.</p>
                                    </td>
                                    <td style="vertical-align: middle">
                                        -
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<div style="padding-top: 5px"></div>
