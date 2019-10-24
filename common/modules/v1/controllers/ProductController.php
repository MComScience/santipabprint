<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 22/10/2562
 * Time: 6:13
 */

namespace common\modules\v1\controllers;

use common\components\CalculateDigital;
use common\components\CalculateOffset;
use common\components\InPutOptions;
use common\components\QueryBuilder;
use common\filters\auth\HttpBearerAuth;
use common\modules\app\models\TblBillPriceDetail;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblQuotation;
use common\modules\app\models\TblQuotationDetail;
use common\modules\app\traits\ModelTrait;
use kartik\form\ActiveForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\HttpException;

class ProductController extends ActiveController
{
    use ModelTrait;

    const BASE_URL = 'https://admin.santipab.info';

    public $modelClass = 'common\modules\app\models\TblProduct';

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'view' => ['get'],
                'create' => ['post'],
                'update' => ['put'],
                'delete' => ['delete'],
                'product-categories' => ['get'],
                'category' => ['get'],
                'bill-floor-option' => ['get'],
                'calculate-price' => ['post'],
                'download' => ['post'],
            ],
        ];
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = [
            'options',
            'product-categories',
            'category',
            'product-options',
            'bill-floor-option',
            'calculate-price',
            'download',
        ];
        // setup access
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete'], //only be applied to
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['product-categories', 'category', 'product-options', 'bill-floor-option', 'calculate-price', 'download'],
                    'roles' => ['?'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function apiBadRequest($message = false)
    {
        throw new HttpException(400, $message ? $message : 'Error Bad request.');
    }

    public function apiDataNotFound($message = false)
    {
        throw new HttpException(404, $message ? $message : 'Resource not found.');
    }

    public function apiValidate($message = false)
    {
        throw new HttpException(422, $message ? $message : 'Error validation.');
    }

    public function sendApiSuccess($data = null)
    {
        $response = \Yii::$app->getResponse();
        $response->setStatusCode(200);
        return [
            'data' => $data,
            'success' => true,
            'statusCode' => 200,
        ];
    }

    public function actionProductCategories()
    {
        $categories = TblProductCategory::find()->orderBy('product_category_order ASC')->all();
        $itemCategories = [];
        $baseUrl = self::BASE_URL;
        foreach ($categories as $key => $category) {
            $itemCategories[] = [
                'product_category_id' => $category['product_category_id'],
                'product_category_name' => $category['product_category_name'],
                'image_url' => $baseUrl . $category->getImageUrl(),
                'default_image' => $baseUrl . $category->getDefaultImage(),
            ];
        }
        return $itemCategories;
    }

    public function actionCategory($id)
    {
        $baseUrl = self::BASE_URL;
        $category = $this->findModelProductCategory($id);
        $itemProducts = [];
        $products = TblProduct::find()->where(['product_category_id' => $id])->orderBy('product_order ASC')->all();
        foreach ($products as $key => $product) {
            $itemProducts[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'product_description' => $product['product_description'],
                'image_url' => $baseUrl . $product->getImageUrl(),
                'default_image' => $baseUrl . $product->getDefaultImage(),
            ];
        }
        return [
            'category' => $category,
            'products' => $itemProducts,
        ];
    }

    public function actionProductOptions($p)
    {
        $product = $this->findModelProduct($p);
        $modelProductOption = $this->findModelProductOption($p);
        $formOptions = empty($product['product_options']) ? [] : unserialize($product['product_options']);
        $QuotationDetail = new TblQuotationDetail();
        $queryBuilder = new QueryBuilder([
            'modelOption' => $modelProductOption,
            'product' => $product,
        ]);

        // หน่วย ขนาดกำหนดเอง
        $paperSizeUnitOption = $queryBuilder->getPaperSizeCustomUnitOption();
        // ตัวเลือกขนาดสำเร็จ
        $paperSizeIdOption = $queryBuilder->getPaperSizeOption();
        // วิธีเข้าเล่ม
        $bookBindingIdOption = $queryBuilder->getBookBindingOption();
        // กระดาษ
        $paperIdOption = $queryBuilder->getPaperOption();
        // สีที่พิมพ์
        $printColorOption = $queryBuilder->getBeforePrintOption();
        // วิธีเคลือบ
        $coatingIdOption = $queryBuilder->getCoatingOption();
        // ไดคัทมุมมน
        $dicutIdOption = $queryBuilder->getDiecutRoundedOption();
        // ตัดเป็นตัว เจาะรู
        $perforateOption = $queryBuilder->getPerforate();
        // มุมที่เจาะ
        $perforateOptionOption = $queryBuilder->getPerforateOption();
        // วิธีพับ
        $foldIdOption = $queryBuilder->getFoldOption();
        // หน่วยฟอย์ล
        $foilSizeUnitOption = $queryBuilder->getFoilUnitOption();
        // สีฟอยล์
        $foilColorIdOption = $queryBuilder->getFoilOption();
        // หน่วยปั๊มนูน
        $embossSizeUnitOption = $queryBuilder->getEmbossUnitOption();
        // พิมพ์สองหน้า, พิมพ์หน้าเดียว
        $printOption = $queryBuilder->getPrintOption();
        // เเคลือบด้านเดียว สองด้าน
        $coatingOptionOption = $queryBuilder->getCoatingOnePageTwoPageOption();
        // ไดคัท
        $dicutStatusOption = $queryBuilder->getDicutStatusOption();
        // ปั๊มฟอยล์หน้าหลัง
        $foilPrintOption = $queryBuilder->getFoilPrintOption();
        // ปั๊มนูนหน้าหลัง
        $embossPrintOption = $queryBuilder->getEmbossPrintOption();
        // ปะกาว
        $glueOption = $queryBuilder->getGlueOption();
        // ร้อยเชือกหูถุง
        $ropeOption = $queryBuilder->getRopeOption();
        // แนวตั้ง แนวนอน
        $landOrientOption = $queryBuilder->getLandOrientOption();
        // ฟอยล์
        $foilStatusOption = $queryBuilder->getFoilStatusOption();
        // ปั๊มนูน
        $embossStatusOption = $queryBuilder->getEmbossStatusOption();
        // รูปแบบไดคัท
        $dicutOption = $queryBuilder->getDiecutOption();
        // สถานะเข้าเล่ม
        $bookBindingStatusOption = $queryBuilder->getBookBindingStatusOption();
        // ปรุฉีก
        $perforatedRippedOption = $queryBuilder->getPerforatedRippedOption();
        // running number
        $runningNumberOption = $queryBuilder->getRunningNumberOptions();
        // ติดหน้าต่าง
        $windowBoxOption = $queryBuilder->getWindowBoxOptions();
        // หน่วยติดหน้าต่าง
        $windowBoxUnitOption = $queryBuilder->getWindowBoxUnitOption();
        // ฟิลด์ที่ไม่ต้องการให้แสดงรายละเอียด
        $skipAttributes = InPutOptions::skipAttributes();
        // กระดาษปกหนังสือ
        $bookCoversPaperOption = $queryBuilder->getBookCoversPaperOption();
        // สีที่พิมพ์ปกหนังสือ
        $bookCoversColorOption = $queryBuilder->getBookCoversColorOption();
        // กระดาษเนื้อใน
        $bookInnerPaperOption = $queryBuilder->getBookInnerPaperOption();
        // สี่ที่พิมพ์(เนื้อใน)
        $bookInnerColorOption = $queryBuilder->getBookInnerColorOption();
        // กระดาษขาวดำ(เนื้อใน)
        $bookInnerPaperWithoutColorOption = $queryBuilder->getBookInnerPaperWithoutColorOption();

        return [
            'formOptions' => $formOptions,
            'formAttributes' => $QuotationDetail->getAttributes(),
            'product' => $product,
            'skipAttributes' => $skipAttributes,
            'dataOptions' => [
                'paperSizeIdOption' => $paperSizeIdOption,
                'paperSizeUnitOption' => $paperSizeUnitOption,
                'bookBindingIdOption' => $bookBindingIdOption,
                'paperIdOption' => $paperIdOption,
                'printColorOption' => $printColorOption,
                'coatingIdOption' => $coatingIdOption,
                'dicutIdOption' => $dicutIdOption,
                'perforateOption' => $perforateOption,
                'perforateOptionOption' => $perforateOptionOption,
                'foldIdOption' => $foldIdOption,
                'foilSizeUnitOption' => $foilSizeUnitOption,
                'foilColorIdOption' => $foilColorIdOption,
                'embossSizeUnitOption' => $embossSizeUnitOption,
                'printOption' => $printOption,
                'coatingOptionOption' => $coatingOptionOption,
                'dicutStatusOption' => $dicutStatusOption,
                'foilPrintOption' => $foilPrintOption,
                'embossPrintOption' => $embossPrintOption,
                'glueOption' => $glueOption,
                'ropeOption' => $ropeOption,
                'landOrientOption' => $landOrientOption,
                'foilStatusOption' => $foilStatusOption,
                'embossStatusOption' => $embossStatusOption,
                'dicutOption' => $dicutOption,
                'bookBindingStatusOption' => $bookBindingStatusOption,
                'perforatedRippedOption' => $perforatedRippedOption,
                'runningNumberOption' => $runningNumberOption,
                'windowBoxOption' => $windowBoxOption,
                'windowBoxUnitOption' => $windowBoxUnitOption,
                'bookCoversPaperOption' => $bookCoversPaperOption,
                'bookCoversColorOption' => $bookCoversColorOption,
                'bookInnerPaperOption' => $bookInnerPaperOption,
                'bookInnerColorOption' => $bookInnerColorOption,
                'bookInnerPaperWithoutColorOption' => $bookInnerPaperWithoutColorOption,
            ],
        ];
    }

    public function actionBillFloorOption($paper_size_id, $paper_id)
    {
        $rows = (new \yii\db\Query())
            ->select([
                'tbl_bill_price.bill_price_id',
                'tbl_bill_price.paper_size_id',
                'CONCAT(tbl_bill_price.bill_floor,\'  แผ่น \') as bill_floor',
                'tbl_bill_price.paper_id',
            ])
            ->from('tbl_bill_price')
            ->where([
                'paper_size_id' => $paper_size_id,
                'paper_id' => $paper_id,
            ])
            ->all();
        return ArrayHelper::map($rows, 'bill_price_id', 'bill_floor');
    }

    public function actionCalculatePrice()
    {
        $qtys = [
            500,
            1000,
            2000,
        ];
        $priceList = [];
        $params = \Yii::$app->getRequest()->getBodyParams();
        $product = $this->findModelProduct($params['product_id']);
        $unit = 'ชิ้น';
        // บิล/ใบเสร็จ/ใบส่งของ
        if ($product['product_category_id'] == 19) {
            $unit = 'เล่ม';
            $billPriceDetails = TblBillPriceDetail::findAll([
                'bill_price_id' => $params['bill_detail_qty'],
            ]);
            foreach ($billPriceDetails as $key => $billPriceDetail) {
                $priceList[] = [
                    'cust_quantity' => $billPriceDetail['bill_detail_qty'],
                    'price_per_item' => $billPriceDetail['bill_detail_price'],
                    'final_price' => number_format($billPriceDetail['bill_detail_price'] * $billPriceDetail['bill_detail_qty'], 2),
                    'paper' => [
                        'paper_detail' => [
                            'paper_detail_id' => '',
                        ],
                    ],
                    'unit' => $unit,
                ];
            }
            return [
                'price_list' => $priceList,
            ];
        }

        if (!empty($params['qty'])) {
            $qtys = \explode(',', $params['qty']);
        }

        foreach ($qtys as $qty) {
            $params['cust_quantity'] = $qty;
            $digital = new CalculateDigital([
                'model' => $params,
            ]);
            $digitalAttr = $digital->getAttributeValue();
            $offset = new CalculateOffset([
                'model' => $params,
            ]);
            $offsetAttr = $offset->getAttributeValue();

            $final_price_digital = ceil($digitalAttr['final_price_digital'] / 10) * 10;
            $price_per_item_digital = $final_price_digital / $params['cust_quantity'];

            //ราคาต่อชิ้น digital
            $price_per_item_digital_decimal = (int) substr(number_format($price_per_item_digital, 2), -2);
            if ($price_per_item_digital_decimal < 90 && $price_per_item_digital_decimal > 0) {
                $price_per_item_digital_decimal = (ceil($price_per_item_digital_decimal / 10)) * 10;
                $price_per_item_digital = (int) $digitalAttr['price_per_item_digital'] . '.' . $price_per_item_digital_decimal;
            } else {
                $price_per_item_digital = ceil($digitalAttr['price_per_item_digital']);
            }
            //ราคาต่อชิ้น offset
            $price_per_item_offset_decimal = number_format($offsetAttr['price_per_item_offset'], 2);
            if ($product['product_category_id'] == 12) {
                $unit = 'แผ่น (' . (round($qty / $params['book_binding_qty'])) . ' เล่ม)';
            }
            $cust_quantity = $qty;
            if ($final_price_digital > 0 && $offsetAttr['final_price_offset'] > 0) {
                if ($final_price_digital > $offsetAttr['final_price_offset']) {
                    $priceList[] = [
                        'final_price' => number_format($offsetAttr['final_price_offset'], 2), //$final_price_offset ? number_format($final_price_offset, 2) : 0.00,
                        'price_per_item' => $offsetAttr['price_per_item_offset'],
                        'cust_quantity' => $cust_quantity,
                        'price_of' => 'offset',
                        'offsetAttr' => $offsetAttr,
                        'digitalAttr' => $digitalAttr,
                        'paper' => $offsetAttr['0.6[paper]'],
                        'unit' => $unit,
                        'price_per_item_digital_decimal' => $price_per_item_digital_decimal,
                        'price_per_item_offset_decimal' => $price_per_item_offset_decimal,
                    ];
                } elseif ($final_price_digital < $offsetAttr['final_price_offset']) {
                    $priceList[] = [
                        'final_price' => number_format(($price_per_item_digital * $params['cust_quantity']), 2),
                        'price_per_item' => $price_per_item_digital ? $price_per_item_digital : 0.00,
                        'cust_quantity' => $cust_quantity,
                        'price_of' => 'digital',
                        'offsetAttr' => $offsetAttr,
                        'digitalAttr' => $digitalAttr,
                        'paper' => $digitalAttr['paper'],
                        'unit' => $unit,
                        'price_per_item_digital_decimal' => $price_per_item_digital_decimal,
                        'price_per_item_offset_decimal' => $price_per_item_offset_decimal,
                    ];
                }
            } elseif ($final_price_digital == 0 && $offsetAttr['final_price_offset'] > 0) {
                $priceList[] = [
                    'final_price' => number_format($offsetAttr['final_price_offset'], 2), //$final_price_offset ? number_format($final_price_offset, 2) : 0.00,
                    'price_per_item' => $offsetAttr['price_per_item_offset'],
                    'cust_quantity' => $cust_quantity,
                    'price_of' => 'offset',
                    'offsetAttr' => $offsetAttr,
                    'digitalAttr' => $digitalAttr,
                    'paper' => $offsetAttr['0.6[paper]'],
                    'unit' => $unit,
                    'price_per_item_digital_decimal' => $price_per_item_digital_decimal,
                    'price_per_item_offset_decimal' => $price_per_item_offset_decimal,
                ];
            } elseif ($final_price_digital > 0 && $offsetAttr['final_price_offset'] == 0) {
                $priceList[] = [
                    'final_price' => number_format(($price_per_item_digital * $params['cust_quantity']), 2),
                    'price_per_item' => $price_per_item_digital ? $price_per_item_digital : 0.00,
                    'cust_quantity' => $cust_quantity,
                    'price_of' => 'digital',
                    'offsetAttr' => $offsetAttr,
                    'digitalAttr' => $digitalAttr,
                    'paper' => $digitalAttr['paper'],
                    'unit' => $unit,
                    'price_per_item_digital_decimal' => $price_per_item_digital_decimal,
                    'price_per_item_offset_decimal' => $price_per_item_offset_decimal,
                ];
            }
        }
        if (count($priceList) == 0) {
            throw new \yii\web\HttpException(422, 'เนื่องจากขนาดชิ้นงานของท่านมีไชส์ใหญ่เกินระบบจะประมาณผล กรุณาติดต่อโรงพิมพ์');
        }
        return [
            'price_list' => $priceList,
        ];
    }

    public function actionDownload($p)
    {
        $model = new TblQuotation();
        $modelDetail = new TblQuotationDetail();
        $modelDetail->product_id = $p;
        $params = \Yii::$app->getRequest()->getBodyParams();
        if ($model->load($params, '')) {
            $modelDetail->setAttributes($params);
            $modelDetail->final_price = str_replace(',', '', $params['final_price']);
            if ($model->save()) {
                $modelDetail->quotation_id = $model['quotation_id'];
                if ($modelDetail->save()) {
                    $modelProduct = $this->findModelProduct($modelDetail['product_id']);
                    $productOptions = unserialize($modelProduct['product_options']);
                    $skipAttributes = InPutOptions::skipAttributes();
                    $skipAttributes = ArrayHelper::merge($skipAttributes, [
                        'perforate_option_id',
                    ]);
                    $result = $this->getProductDetail($productOptions, $skipAttributes, $modelProduct, $modelDetail);
                    return [
                        'success' => true,
                        'message' => 'Success',
                        'url' => 'https://admin.santipab.info/app/product/quo?q='.$model['quotation_id'],
                        'flexMessage' => [
                            "type" => "flex",
                            "altText" => "รายละเอียดสินค้า",
                            "contents" => $result['flex'],
                        ],
                    ];
                } else {
                    $model->delete();
                    return [
                        'success' => false,
                        'message' => 'error',
                        'validate' => ArrayHelper::merge(ActiveForm::validate($model), ActiveForm::validate($modelDetail)),
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'error',
                    'validate' => ArrayHelper::merge(ActiveForm::validate($model), ActiveForm::validate($modelDetail)),
                ];
            }
        }
    }

    private function getProductDetail($productOptions, $skipAttributes, $modelProduct, $model)
    {
        $inputOptions = [];
        $x = 'x';
        $spacebar = ' ';
        $newline = "\n";
        $details = '';

        // flex
        $baseUrl = 'https://admin.santipab.info';
        $hero = [
            "type" => "image",
            "url" => $baseUrl . $modelProduct->getImageUrl(),
            "size" => "full",
            "aspectRatio" => "20:13",
            "aspectMode" => "cover",
            "action" => [
                "type" => "uri",
                "uri" => $baseUrl . $modelProduct->getImageUrl(),
            ],
        ];
        $box = [
            "type" => "box",
            "layout" => "horizontal",
            "margin" => "md",
            "contents" => [],
        ];

        $contentLeft = [
            "type" => "text",
            "text" => "",
            "size" => "sm",
            "color" => "#555555",
            "flex" => 0,
        ];

        $contentRight = [
            "type" => "text",
            "text" => "",
            "size" => "sm",
            "color" => "#111111",
            "align" => "end",
        ];

        $contents = [];

        foreach ($productOptions as $attribute => $option) {
            if ($option['value']) {
                $label = empty($option['label']) ? $model->getAttributeLabel($attribute) : $option['label'];
                $options = empty($option['options']) ? [] : InPutOptions::getOption($attribute);
                $value = empty($option['options']) ? $model[$attribute] : InPutOptions::getAttributeValue($model[$attribute], $options);
                $attributeOption = [
                    'label' => $option['label'],
                    'value' => $value,
                ];
                if (!ArrayHelper::isIn($attribute, $skipAttributes)) {
                    // ขนาด กำหนดเอง
                    if ($attribute === 'paper_size_id' && $model['paper_size_id'] == 'custom') {
                        $unitOptions = InPutOptions::getOption('paper_size_unit');
                        $unitName = InPutOptions::getAttributeValue($model['paper_size_unit'], $unitOptions);
                        if (!empty($model['paper_size_height'])) {
                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $model['paper_size_width'] . $x . $model['paper_size_lenght'] . $x . $model['paper_size_height'] . $spacebar . $unitName,
                            ]);
                        } else {
                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $model['paper_size_width'] . $x . $model['paper_size_lenght'] . $spacebar . $unitName,
                            ]);
                        }
                    }
                    // เคลือบ
                    if ($attribute === 'coating_id' && !empty($model['coating_option'])) {
                        // ด้านที่เคลือบ
                        $options = InPutOptions::getOption('coating_option');
                        $coating_option = InPutOptions::getAttributeValue($model['coating_option'], $options);
                        $attributeOption = ArrayHelper::merge($attributeOption, [
                            'value' => $value . $spacebar . '(' . $coating_option . ')',
                        ]);
                    }
                    // ตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว
                    if ($attribute === 'perforate') {
                        $perforateOptions = InPutOptions::getOption('perforate');
                        $perforate = InPutOptions::getAttributeValue($model['perforate'], $perforateOptions);
                        // มุมที่เจาะ
                        if (!empty($model['perforate_option_id'])) {
                            $perforateOptionIdOptions = InPutOptions::getOption('perforate_option_id');
                            $perforate_option_id = InPutOptions::getAttributeValue($model['perforate_option_id'], $perforateOptionIdOptions);
                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $perforate . $spacebar . ' + เจาะ' . $perforate_option_id,
                            ]);
                        } else {
                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $perforate,
                            ]);
                        }
                    }
                    // ปั๊มฟอยล์
                    if ($attribute === 'foil_status') {
                        $foilStatusOptions = InPutOptions::getOption('foil_status');
                        $foil_status = InPutOptions::getAttributeValue($model['foil_status'], $foilStatusOptions);
                        // ปั๊ม
                        if ($model['foil_status'] !== 'N') {
                            // หน่วยฟอยล์
                            $foilSizeUnitOptions = InPutOptions::getOption('foil_size_unit');
                            $foil_size_unit = InPutOptions::getAttributeValue($model['foil_size_unit'], $foilSizeUnitOptions);
                            // สีฟอยล์
                            $foilColorIdOptions = InPutOptions::getOption('foil_color_id');
                            $foil_color_id = InPutOptions::getAttributeValue($model['foil_color_id'], $foilColorIdOptions);

                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $spacebar . $model['foil_size_width'] . $x . $model['foil_size_height'] . $spacebar . $foil_size_unit . $spacebar . $foil_color_id,
                            ]);
                        } else {
                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $foil_status,
                            ]);
                        }
                    }
                    // ปั๊มนูน
                    if ($attribute === 'emboss_status') {
                        $embossStatusOptions = InPutOptions::getOption('emboss_status');
                        $emboss_status = InPutOptions::getAttributeValue($model['emboss_status'], $embossStatusOptions);
                        // ปั๊ม
                        if ($model['emboss_status'] !== 'N') {
                            // หน่วย
                            $embossSizeUnitOptions = InPutOptions::getOption('emboss_size_unit');
                            $emboss_size_unit = InPutOptions::getAttributeValue($model['emboss_size_unit'], $embossSizeUnitOptions);

                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $spacebar . $model['emboss_size_width'] . $x . $model['emboss_size_height'] . $spacebar . $foil_size_unit,
                            ]);
                        } else {
                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $emboss_status,
                            ]);
                        }
                    }
                    // window_box
                    if ($attribute === 'window_box') {
                        $windowBoxOptions = InPutOptions::getOption('window_box');
                        $window_box = InPutOptions::getAttributeValue($model['window_box'], $windowBoxOptions);
                        if ($model['window_box']) {
                            // หน่วย
                            $windowBoxUnitOptions = InPutOptions::getOption('window_box_unit');
                            $window_box_unit = InPutOptions::getAttributeValue($model['window_box_unit'], $windowBoxUnitOptions);
                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $model['window_box_width'] . $x . $model['window_box_lenght'] . $spacebar . $window_box_unit,
                            ]);
                        } else {
                            $attributeOption = ArrayHelper::merge($attributeOption, [
                                'value' => $window_box,
                            ]);
                        }
                    }
                    $details .= $attributeOption['label'] . ': ' . $attributeOption['value'] . $newline;
                    $contents[] = ArrayHelper::merge($box, [
                        'contents' => [
                            ArrayHelper::merge($contentLeft, [
                                "text" => $attributeOption['label'],
                            ]),
                            ArrayHelper::merge($contentRight, [
                                "text" => empty($attributeOption['value']) ? "" : $attributeOption['value'],
                            ]),
                        ],
                    ]);
                    $inputOptions[$attribute] = $attributeOption;
                }
            }

        }

        $contents[] = [
            "type" => "separator",
            "margin" => "xxl",
        ];
        $contents[] = ArrayHelper::merge($box, [
            'contents' => [
                ArrayHelper::merge($contentLeft, [
                    "text" => "จำนวน",
                    "color" => "#ea7066",
                ]),
                ArrayHelper::merge($contentRight, [
                    "text" => Yii::$app->formatter->format($model['cust_quantity'], ['decimal', 0]) . " ชิ้น",
                    "color" => "#ea7066",
                ]),
            ],
        ]);
        $contents[] = ArrayHelper::merge($box, [
            'contents' => [
                ArrayHelper::merge($contentLeft, [
                    "text" => "ราคา",
                    "color" => "#ea7066",
                ]),
                ArrayHelper::merge($contentRight, [
                    "text" => Yii::$app->formatter->format($model['final_price'], ['decimal', 2]) . " บ.",
                    "color" => "#ea7066",
                ]),
            ],
        ]);

        $body = [
            "type" => "box",
            "layout" => "vertical",
            "contents" => ArrayHelper::merge([
                [
                    "type" => "text",
                    "text" => "รายละเอียดสินค้า",
                    "weight" => "bold",
                    "color" => "#1DB446",
                    "size" => "sm",
                ],
                [
                    "type" => "text",
                    "text" => $modelProduct['product_name'],
                    "weight" => "bold",
                    "size" => "xs",
                    "margin" => "md",
                ],
                [
                    "type" => "separator",
                    "margin" => "xxl",
                ],
                [
                    "type" => "box",
                    "layout" => "horizontal",
                    "margin" => "md",
                    "contents" => [
                        [
                            "type" => "text",
                            "text" => "ID",
                            "size" => "xs",
                            "color" => "#aaaaaa",
                            "flex" => 0,
                        ],
                        [
                            "type" => "text",
                            "text" => "#" . $model['quotation_id'],
                            "color" => "#aaaaaa",
                            "size" => "xs",
                            "align" => "end",
                        ],
                    ],
                ],
            ], $contents),
        ];

        $footer = [
            "type" => "box",
            "layout" => "vertical",
            "contents" => [
                [
                    "type" => "button",
                    "color" => "#905c44",
                    "action" => [
                        "type" => "uri",
                        "label" => "ดาวน์โหลดใบเสนอราคา",
                        "uri" => $baseUrl . Url::to(['quo', 'q' => $model['quotation_id']]),
                    ],
                ],
            ],
        ];

        $flex = [
            "type" => "bubble",
            "styles" => [
                "footer" => [
                    "separator" => true,
                ],
            ],
            "hero" => $hero,
            "body" => $body,
            "footer" => $footer,
        ];
        return [
            'flex' => $flex,
            'inputOptions' => $inputOptions,
            'details' => $details,
        ];
    }
}
