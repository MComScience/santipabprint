<?php
use yii\helpers\Url;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ ?>

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
                   data-clipboard-text="<?= Url::base(true) . Url::to(['/app/product/quo', 'q' => $model['quotation_id']]) ?>">คัดลอกลิงค์</a>
                <div class="btn btn-danger" onclick="Invoice.print('printableArea')">พิมพ์</div>
            </div>
        </div>
    </div>
</header>
