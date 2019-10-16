<?php

namespace common\modules\app\controllers;

use common\components\QueryBuilder;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblQuotationDetail;
use common\modules\app\models\TblUnit;
use common\modules\app\models\TblBillPrice;
use common\modules\app\models\TblBillPriceDetail;
use common\modules\app\traits\ModelTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\components\CalculateDigital;
use common\components\CalculateOffset;
use yii\helpers\Url;
use yii\helpers\Json;

class ApiController extends \yii\web\Controller {

    use ModelTrait;

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'product-category-list' => ['GET'],
                    'quotation' => ['GET'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'product-category-list', 'quotation', 'calculate-price', 'bill-floor-options',
                            'get-product-category', 'get-all-product'
                        ],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionProductCategoryList() {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $catagorys = TblProductCategory::find()->all();
        $itemCatagorys = [];
        $baseUrl = 'https://santipab.info';
        foreach ($catagorys as $key => $catagory) {
            $itemCatagorys[] = [
                'product_category_id' => $catagory['product_category_id'],
                'product_category_name' => $catagory['product_category_name'],
                'image_url' => $baseUrl . $catagory->getImageUrl(),
            ];
        }
        return $itemCatagorys;
    }

    public function actionQuotation($p) {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $product = $this->findModelProduct($p);
        $modelProductOption = $this->findModelProductOption($p);
        $formOptions = $product->options;
        $QuotationDetail = new TblQuotationDetail();
        $queryBuilder = new QueryBuilder(['modelOption' => $modelProductOption]);

        // หน่วย ขนาดกำหนดเอง
        $paperSizeUnitOptions = ArrayHelper::map(TblUnit::find()->where(['unit_id' => [2, 3]])->asArray()->all(), 'unit_id', 'unit_name');
        // ตัวเลือกขนาดสำเร็จ
        $paperSizeOptions = $queryBuilder->getPaperSizeOption();
        // วิธีเข้าเล่ม
        $bookBindingOptions = $queryBuilder->getBookBindingOption();
        // กระดาษ
        $paperOptions = $queryBuilder->getPaperOption();
        // สีที่พิมพ์
        $printColorOptions = $queryBuilder->getBeforePrintOption();
        // เคลือบ
        $coatingOptions = $queryBuilder->getCoatingOption();
        // ไดคัทมุมมน
        $dicutOptions = $queryBuilder->getDiecutOption();
        // ตัดเป็นตัว เจาะรู
        $perforateOptions = [
            0 => 'ตัดเป็นตัวอย่างเดียว',
            1 => 'ตัดเป็นตัว + เจาะรูกลม',
        ];
        $perforateOptionOptions = $queryBuilder->getPerforateOption();
        // วิธีพับ
        $foldOptions = $queryBuilder->getFoldOption();
        // หน่วยฟอย์ล
        $foilUnitOptions = ArrayHelper::map(TblUnit::find()->where(['unit_id' => [2, 3]])->asArray()->all(), 'unit_id', 'unit_name');
        // สีฟอยล์
        $foilColorOptions = $queryBuilder->getFoilOption();
        // หน่วยปั๊มนูน
        $embossUnitOptions = ArrayHelper::map(TblUnit::find()->where(['unit_id' => [2, 3]])->asArray()->all(), 'unit_id', 'unit_name');
        
        $windowBoxUnitOpts = ArrayHelper::map(TblUnit::find()->where(['unit_id' => [2, 3]])->asArray()->all(), 'unit_id', 'unit_name');
        return [
            'formOptions' => $formOptions,
            'formAttributes' => $QuotationDetail->getAttributes(),
            'product' => $product,
            'dataOptions' => [
                'paperSizeOptions' => $paperSizeOptions,
                'paperSizeUnitOptions' => $paperSizeUnitOptions,
                'bookBindingOptions' => $bookBindingOptions,
                'paperOptions' => $paperOptions,
                'printColorOptions' => $printColorOptions,
                'coatingOptions' => $coatingOptions,
                'dicutOptions' => $dicutOptions,
                'perforateOptions' => $perforateOptions,
                'perforateOptionOptions' => $perforateOptionOptions,
                'foldOptions' => $foldOptions,
                'foilUnitOptions' => $foilUnitOptions,
                'foilColorOptions' => $foilColorOptions,
                'embossUnitOptions' => $embossUnitOptions,
                'windowBoxUnitOpts' => $windowBoxUnitOpts,
            ],
        ];
    }

    public function actionCalculatePrice() {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $qtys = [
            500,
            1000,
            2000
        ];
        $priceList = [];
        $data = $request->post();
        $product = $this->findModelProduct($data['product_id']);
        $unit = 'ชิ้น';
        // บิล/ใบเสร็จ/ใบส่งของ
        if ($product['product_category_id'] == 19) {
            $unit = 'เล่ม';
            $billPriceDetails = TblBillPriceDetail::findAll([
                        'bill_price_id' => $data['bill_detail_qty']
            ]);
            foreach ($billPriceDetails as $key => $billPriceDetail) {
                $priceList[] = [
                    'cust_quantity' => $billPriceDetail['bill_detail_qty'],
                    'price_per_item' => $billPriceDetail['bill_detail_price'],
                    'final_price' => number_format($billPriceDetail['bill_detail_price'] * $billPriceDetail['bill_detail_qty'], 2),
                    'paper' => [
                        'paper_detail' => [
                            'paper_detail_id' => ''
                        ]
                    ],
                    'unit' => $unit
                ];
            }
            return [
                'price_list' => $priceList,
            ];
        }

        if (!empty($request->post('qty'))) {
            $qtys = \explode(',', $request->post('qty'));
        }



        foreach ($qtys as $qty) {
            $data['cust_quantity'] = $qty;
            $digital = new CalculateDigital([
                'model' => $data,
            ]);
            $digitalAttr = $digital->getAttributeValue();
            $offset = new CalculateOffset([
                'model' => $data,
            ]);
            $offsetAttr = $offset->getAttributeValue();

            $final_price_digital = ceil($digitalAttr['final_price_digital'] / 10) * 10;
            $price_per_item_digital = $final_price_digital / $data['cust_quantity'];

//            $final_price_offset = ceil($offsetAttr['final_price_offset'] / 10) * 10;
//            $price_per_item_offset = $final_price_offset / $data['cust_quantity'];
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
//            if ($price_per_item_offset_decimal < 90 && $price_per_item_offset_decimal > 0) {
//                $price_per_item_offset_decimal = (ceil($price_per_item_offset_decimal / 10)) * 10;
//                $price_per_item_offset = (int) $offsetAttr['price_per_item_offset'] . '.' . $price_per_item_offset_decimal;
//            } else {
//                $price_per_item_offset = ceil($offsetAttr['price_per_item_offset']);
//            }
            if ($product['product_category_id'] == 12) {
                $unit = 'แผ่น (' . (round($qty / $data['book_binding_qty'])).' เล่ม)';
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
                        'price_per_item_offset_decimal' => $price_per_item_offset_decimal
                    ];
                } elseif ($final_price_digital < $offsetAttr['final_price_offset']) {
                    $priceList[] = [
                        'final_price' => number_format(($price_per_item_digital * $data['cust_quantity']), 2),
                        'price_per_item' => $price_per_item_digital ? $price_per_item_digital : 0.00,
                        'cust_quantity' => $cust_quantity,
                        'price_of' => 'digital',
                        'offsetAttr' => $offsetAttr,
                        'digitalAttr' => $digitalAttr,
                        'paper' => $digitalAttr['paper'],
                        'unit' => $unit,
                        'price_per_item_digital_decimal' => $price_per_item_digital_decimal,
                        'price_per_item_offset_decimal' => $price_per_item_offset_decimal
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
                    'price_per_item_offset_decimal' => $price_per_item_offset_decimal
                ];
            } elseif ($final_price_digital > 0 && $offsetAttr['final_price_offset'] == 0) {
                $priceList[] = [
                    'final_price' => number_format(($price_per_item_digital * $data['cust_quantity']), 2),
                    'price_per_item' => $price_per_item_digital ? $price_per_item_digital : 0.00,
                    'cust_quantity' => $cust_quantity,
                    'price_of' => 'digital',
                    'offsetAttr' => $offsetAttr,
                    'digitalAttr' => $digitalAttr,
                    'paper' => $digitalAttr['paper'],
                    'unit' => $unit,
                    'price_per_item_digital_decimal' => $price_per_item_digital_decimal,
                    'price_per_item_offset_decimal' => $price_per_item_offset_decimal
                ];
            }
        }
        if (count($priceList) == 0) {
            throw new \yii\web\HttpException(422, 'เนื่องจากขนาดชิ้นงานของท่านมีไชส์ใหญ่เกินระบบจะประมาณผล กรุณาติดต่อโรงพิมพ์');
        }
//        $data = $request->post();
//        $data['cust_quantity'] = 2000;
//        $offset = new CalculateOffset([
//            'model' => $data,
//        ]);
//        $offsetAttr = $offset->getAttributeValue();
        return [
            'price_list' => $priceList,
        ];
    }

    public function actionBillFloorOptions($paper_size_id, $paper_id) {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $rows = (new \yii\db\Query())
                ->select([
                    'tbl_bill_price.bill_price_id',
                    'tbl_bill_price.paper_size_id',
                    'CONCAT(tbl_bill_price.bill_floor,\'  แผ่น \') as bill_floor',
                    'tbl_bill_price.paper_id'
                ])
                ->from('tbl_bill_price')
                ->where([
                    'paper_size_id' => $paper_size_id,
                    'paper_id' => $paper_id,
                ])
                ->all();
        return ArrayHelper::map($rows, 'bill_price_id', 'bill_floor');
    }

    public function actionGetProductCategory($id) {
        $baseUrl = 'https://santipab.info';
        $catagory = TblProductCategory::findOne($id);
        $itemProducts = [];
        if ($catagory) {
            $products = TblProduct::find()->where(['product_category_id' => $id])->orderBy('package_type_id ASC')->all();
            foreach ($products as $key => $product) {
                $itemProducts[] = [
                    'product_id' => $product['product_id'],
                    'product_name' => $product['product_name'],
                    'image_url' => $baseUrl . $product->getImageUrl(),
                ];
            }
        }
        return Json::encode([
                    'items' => $itemProducts
        ]);
    }

    public function actionGetAllProduct() {
        $itemProducts = [];
        $products = TblProduct::find()->orderBy('package_type_id ASC')->all();
        $baseUrl = 'https://santipab.info';
        foreach ($products as $key => $product) {
            $itemProducts[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'product_category_name' => $product->productCategory->product_category_name,
                'product_category_id' => $product->productCategory->product_category_id,
                'image_url' => $baseUrl . $product->getImageUrl(),
            ];
        }
        return Json::encode([
                    'items' => $itemProducts,
                    'keywords' => ArrayHelper::getColumn($itemProducts, 'product_name')
        ]);
    }

}
