<?php
use yii\helpers\Html;
use kartik\icons\Icon;
//style
$styles = [
    '@web/bundle/waitMe.css',
    //'@web/bundle/quotation.css',
    '@web/bundle/checkboxStyle.css'
];
foreach ($styles as $style) {
    $this->registerCssFile($style, [
        'depends' => [
            \yii\bootstrap\BootstrapAsset::className(),
            \kidz\assets\KidzAsset::className(),
            \frontend\assets\AppAsset::className()
        ],
    ]);
}
?>
<section class="whiteSection full-width clearfix qoutationSection" style="padding: 20px 0;">
    <div class="container">
        <!-- Section Title -->
        <div class="sectionTitle text-center">
            <h2 class="wow" style="margin-bottom: 5px;">
                <span class="shape shape-left bg-color-4"></span>
                <span>
                    <?= $catalog['catalog_name'] ?>
                </span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <?= Html::a(Icon::show('th').'ตัวอย่างผลิตภัณฑ์',['/product/catalog-list']); ?>
                </li>
                <li>
                    <?= Html::a($catalogType['catalog_type_name'],['/product/catalog', 'p' => $catalogType['catalog_type_id']]); ?>
                </li>
                <li class="active"><?= $catalog['catalog_name'] ?></li>
            </ol>
        </div>
         <!-- Panel -->
         <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-offset-4">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <p class="text-center" style="line-height: 15px">
                            <?= Html::img(Yii::getAlias('@web/images/photo-gallery.png'), [
                                'width' => '50px',
                                'class' => 'img-responsive center-block',
                                'style' => 'margin-bottom: 5px;',
                            ]) . Html::tag('span', 'ภาพสินค้า', ['class' => 'text-center']) ?>
                        </p>
                    </div>
                </div>
                <div class="row isotopeContainer" id="container">
                    <div class="col-md-8 col-sm-8 col-xs-8 col-xs-offset-2 isotopeSelector">
                        <article class="wow fadeInUp">
                            <figure>
                                <img src="<?= $catalog->imageUrl; ?>" alt="image" class="img-rounded center-block">
                                <div class="overlay-background">
                                <div class="inner"></div>
                                </div>
                                <div class="overlay">
                                <a data-fancybox="images" href="<?= $catalog->imageUrl; ?>">
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                                </div>
                            </figure>
                        </article>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-8 col-sm-offset-2">
                <!-- Icon -->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <p class="text-center" style="line-height: 15px">
                            <?= Html::img(Yii::getAlias('@web/images/checklist.png'), [
                                'width' => '50px',
                                'class' => 'img-responsive center-block',
                                'style' => 'margin-bottom: 5px;'
                            ]) . Html::tag('span', 'รายละเอียด', ['class' => 'text-center']) ?>
                        </p>
                    </div>
                </div>
                <div class="panel panel-info product-panel">
                    <div class="panel-body">
                        <?= $catalog['catalog_detail'] ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-2"></div>
            <div class="col-xs-12 col-md-4">
               <p>
               <?= Html::a('<i class="fa fa-angle-left"></i> ย้อนกลับ', ['/product/catalog', 'p' => $catalog['catalog_type_id']], [
                    'class' => 'btn btn-info btn-block',
                ]); ?>
               </p>
            </div>
            <div class="col-xs-12 col-md-4">
                <p>
                <?= Html::a('<i class="fa fa-th"></i> ตัวอย่างผลิตภัณฑ์อื่น', ['/product/catalog-list'], [
                    'class' => 'btn btn-info btn-block',
                ]); ?>
                </p>
            </div>
            <div class="col-xs-12 col-md-2"></div>
        </div>
         
    </div>
</section>