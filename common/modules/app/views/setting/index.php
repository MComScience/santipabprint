<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\widgets\Pjax;
use adminlte\helpers\Html;
use common\modules\app\models\TblUnit;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblPaperType;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblFoilColor;
use common\modules\app\models\TblCoating;
use common\modules\app\models\TblDiecut;
use common\modules\app\models\TblBookBinding;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblPerforate;
use common\modules\app\models\TblPackageType;
use common\modules\app\models\TblBillPrice;

$options = [
    [
        'text' => 'หน่วยกระดาษ',
        'url' => ['unit'],
        'action' => 'unit',
        'count' => TblUnit::find()->count()
    ],
    [
        'text' => 'ขนาดกระดาษ',
        'url' => ['paper-size'],
        'action' => 'paper-size',
        'count' => TblPaperSize::find()->count()
    ],
    [
        'text' => 'ประเภทกระดาษ',
        'url' => ['paper-type'],
        'action' => 'paper-type',
        'count' => TblPaperType::find()->count()
    ],
    [
        'text' => 'กระดาษ',
        'url' => ['paper'],
        'action' => 'paper',
        'count' => TblPaper::find()->count()
    ],
    [
        'text' => 'วิธีพับ',
        'url' => ['fold'],
        'action' => 'fold',
        'count' => TblFold::find()->count()
    ],
    [
        'text' => 'สีฟอยล์',
        'url' => ['foil-color'],
        'action' => 'foil-color',
        'count' => TblFoilColor::find()->count()
    ],
    [
        'text' => 'วิธีเคลือบ',
        'url' => ['coating'],
        'action' => 'coating',
        'count' => TblCoating::find()->count()
    ],
    [
        'text' => 'ไดคัท',
        'url' => ['diecut'],
        'action' => 'diecut',
        'count' => TblDiecut::find()->count()
    ],
    [
        'text' => 'วิธีเข้าเล่ม',
        'url' => ['book-binding'],
        'action' => 'book-binding',
        'count' => TblBookBinding::find()->count()
    ],
    [
        'text' => 'พิมพ์สองหน้า/พิมพ์หน้าเดียว',
        'url' => ['printing'],
        'action' => 'printing',
        'count' => TblColorPrinting::find()->count()
    ],
    [
        'text' => 'หมวดหมู่สินค้า',
        'url' => ['product-category'],
        'action' => 'product-category',
        'count' => TblProductCategory::find()->count()
    ],
    [
        'text' => 'เจาะมุม',
        'url' => ['perforate'],
        'action' => 'perforate',
        'count' => TblPerforate::find()->count()
    ],
    [
        'text' => 'สินค้า',
        'url' => ['product'],
        'action' => 'product',
        'count' => TblProduct::find()->count()
    ],
    [
        'text' => 'ตั้งค่าราคา บิล/ใบเสร็จ/ใบส่งของ',
        'url' => ['bill-price'],
        'action' => 'bill-price',
        'count' => TblBillPrice::find()->count()
    ],
    //ใช้ร่วมกันกับหมวดหมู่
//    [
//        'text' => 'ประเภทสินค้า',
//        'url' => ['package-type'],
//        'action' => 'package-type',
//        'count' => TblPackageType::find()->count()
//    ],
];
$action = Yii::$app->controller->action->id;
?>
<style type="text/css">
    .color-inherit {
        color: inherit !important;
    }
</style>
<?php Pjax::begin(['id' => 'pjax-menu']); ?>
<div class="row">
    <?php foreach ($options as $option): ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<?= Url::to($option['url']); ?>" class="color-inherit" data-pjax="0">
                <div class="info-box">
                <span class="info-box-icon <?= ($action !== $option['action']) ? 'bg-aqua' : 'bg-green' ?>">
                    <i class="fa fa-file-text-o"></i>
                </span>

                    <div class="info-box-content">
                        <span class="info-box-text"><?= Html::encode($option['text']) ?></span>
                        <span class="info-box-number"><?= $option['count'] ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div><!-- /.col -->
    <?php endforeach; ?>
</div>
<?php Pjax::end(); ?>

<?php
$this->registerJs(<<<JS
if($('.box-primary').length) {
    $('html, body').animate({ scrollTop: $('.box-primary').offset().top }, 1500);
}
JS
);
?>