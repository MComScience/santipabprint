<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 16/1/2562
 * Time: 13:32
 */

use adminlte\helpers\Html;
use kartik\icons\Icon;
use dominus77\sweetalert2\assets\SweetAlert2Asset;

SweetAlert2Asset::register($this);

$this->title = 'ตระกร้าสินค้า';
?>
<style type="text/css">
    img.img-responsive.img-rounded.cart-image {
        max-width: 64px;
        max-height: 74px;
    }

    .cartInfo .table-responsive .table thead tr th {
        font-size: 16px;
    }

    .cartInfo .table-responsive .table tbody tr td {
        font-size: 14px;
    }

    @media (min-width: 1200px) {
        .cartInfo .table-responsive .table tbody tr td {
            padding: 10px 8px 10px 15px;
        }
    }
</style>
<section class="mainContent full-width clearfix">
    <div class="container">
        <!-- Section Title -->
        <?php if (!$carts) : ?>
            <div class="sectionTitle text-center">
                <h2 class="wow">
                    <span class="shape shape-left bg-color-4"></span>
                    <span>
                    <?= Html::encode('ไม่มีรายการสินค้าในรถเข็นของคุณ') ?>
                </span>
                    <span class="shape shape-right bg-color-4">

                </span>
                </h2>
                <p class="text-center">
                    <?= Html::a('Shopping', ['/product/index'], ['class' => 'btn btn-info']) ?>
                </p>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-xs-12">
                    <form action="#">
                        <div class="cartInfo">
                            <div class="table-responsive">
                                <table class="table small">
                                    <thead>
                                    <tr class="bg-color-1">
                                        <th class="col-lg-2 col-xs-3">
                                            &nbsp;
                                        </th>
                                        <th class="col-lg-4 col-xs-3">สินค้า</th>
                                        <th class="col-lg-2 col-xs-2">ราคา</th>
                                        <th class="col-lg-2 col-xs-2">จำนวน</th>
                                        <th class="col-lg-2 col-xs-2">ราคารวม</th>
                                        <th class="col-lg-2 col-xs-3">
                                            &nbsp;
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($carts as $cart) : ?>
                                        <tr>
                                            <td>
                                                <button type="button" class="close del-item-cart"
                                                        data-dismiss="alert"
                                                        data-id="<?= $cart['product_id'] ?>"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <span class="cartImage">
                                                <?= $cart['cartImage']; ?>
                                            </span>
                                            </td>
                                            <td>
                                                <?= $cart['product_name']; ?>
                                                <ul class="quotation-detail" style="font-size: 11px;">
                                                    <li>
                                                        <span>ขนาด:</span>
                                                        <span class="op_paper_size float-right">
                                                        <?= $cart['des']['paperSize']; ?>
                                                    </span>
                                                    </li>
                                                    <li>
                                                        <span>หน้าแรก:</span>
                                                        <span class="op_first_page float-right">
                                                            <?= $cart['des']['first_page']; ?>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span>หน้าหลัง:</span>
                                                        <span class="op_last_page float-right">
                                                            <?= $cart['des']['last_page']; ?>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span>กระดาษ:</span>
                                                            <span class="op_paper float-right">
                                                            <?= $cart['des']['paper']; ?>
                                                        </span>
                                                    </li>
                                                    <?php if ($cart['des']['dicut']) { ?>
                                                        <li>
                                                            <span>ไดคัท:</span>
                                                            <span class="op_dicut float-right">
                                                                <?= $cart['des']['dicut']; ?>
                                                            </span>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($cart['des']['fold']) { ?>
                                                        <li>
                                                            <span>พับ:</span>
                                                            <span class="op_book_binding float-right">
                                                                <?= $cart['des']['fold']; ?>
                                                            </span>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($cart['des']['coating']) { ?>
                                                        <li>
                                                            <span>การเคลือบ:</span>
                                                            <span class="op_refinement float-right">
                                                                <?= $cart['des']['coating']; ?>
                                                            </span>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($cart['des']['foiling']) { ?>
                                                        <li>
                                                            <span>ฟอยล์:</span>
                                                            <span class="op_foiling float-right">
                                                                <?= $cart['des']['foiling']; ?>
                                                            </span>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($cart['des']['embosser']) { ?>
                                                        <li>
                                                            <span>ปั๊มนูน:</span>
                                                            <span class="op_embosser float-right">
                                                                <?= $cart['des']['embosser']; ?>
                                                            </span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                            <td>
                                                $ 99.00
                                            </td>
                                            <td>
                                                <?= $cart['cartQty']; ?>
                                            </td>
                                            <td>
                                                $ 99.00
                                            </td>
                                            <td>
                                                <?= Html::a(Icon::show('edit', ['class' => 'fa-2x']), ['/product/quotation', 'product_id' => $cart['product_id']], [
                                                    'class' => 'btn btn-default btn-sm'
                                                ]) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                        <tr>
                                            <td colspan="6">
                                                <?= Html::a(Icon::show('download').' ใบเสนอราคา', ['/site/invoice'], [
                                                    'class' => 'btn btn-sm btn-primary pull-right on-print'
                                                ]) ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
$this->registerJS(<<<JS
$('button.del-item-cart').on('click', function() {
    var itemId = $(this).data('id');
    $.ajax({
        url: '/product/delete-cart',
        type: 'GET',
        data: {
            itemId: itemId
        },
        dataType: 'json',
        success: function (response) {
            window.location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal({
                type: 'error',
                title: textStatus,
                text: errorThrown,
            });
        }
    });
});
JS
);
?>
