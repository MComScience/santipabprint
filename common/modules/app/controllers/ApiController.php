<?php

namespace common\modules\app\controllers;

use common\components\QueryBuilder;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblQuotationDetail;
use common\modules\app\models\TblUnit;
use common\modules\app\traits\ModelTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\components\CalculateDigital;
use common\components\CalculateOffset;

class ApiController extends \yii\web\Controller
{
    use ModelTrait;

    public function behaviors()
    {
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
                        'actions' => ['product-category-list', 'quotation', 'calculate-price'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProductCategoryList()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $catagorys = TblProductCategory::find()->all();
        $itemCatagorys = [];
        foreach ($catagorys as $key => $catagory) {
            $itemCatagorys[] = [
                'product_category_id' => $catagory['product_category_id'],
                'product_category_name' => $catagory['product_category_name'],
                'image_url' => $catagory->getImageUrl(),
            ];
        }
        return $itemCatagorys;
    }

    public function actionQuotation($p)
    {
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
            ],
        ];
    }

    public function actionCalculatePrice()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $qtys = [];
        $priceList = [];
        if (!empty($request->post('qty'))) {
            $qtys = \explode(',', $request->post('qty'));
        }
        foreach ($qtys as $key => $qty) {
            $priceList[] = [
                'cust_quantity' => $qty,
                'price_per_item' => 0.2,
                'final_price' => $qty * 0.2,
            ];
        }
        $priceList = [];
        $data = $request->post();
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
            $price_per_item_digital = $digitalAttr['price_per_item_digital'];
            $final_price_offset = ceil($offsetAttr['final_price_offset'] / 10) * 10;
            $price_per_item_offset = $offsetAttr['price_per_item_offset'];
            $cust_quantity = $qty;
            if ($final_price_digital > $final_price_offset) {
                $priceList[] = [
                    'final_price' => $final_price_offset ? number_format($final_price_offset, 2) : 0.00,
                    'price_per_item' => $price_per_item_offset ? number_format($price_per_item_offset, 2) : 0.00,
                    'cust_quantity' => $cust_quantity,
                    'price_of' => 'offset',
                    'offsetAttr' => $offsetAttr,
                    'digitalAttr' => $digitalAttr,
                    'paper' => $offsetAttr['paper']
                ];
            } else {
                $priceList[] = [
                    'final_price' => $final_price_digital ? number_format($final_price_digital, 2) : 0.00,
                    'price_per_item' => $price_per_item_digital ? number_format($price_per_item_digital, 2) : 0.00,
                    'cust_quantity' => $cust_quantity,
                    'price_of' => 'digital',
                    'offsetAttr' => $offsetAttr,
                    'digitalAttr' => $digitalAttr,
                    'paper' => $digitalAttr['paper']
                ];
            }
        }
        return [
            'price_list' => $priceList,
        ];
    }
}
