<?php

namespace frontend\controllers;

use adminlte\helpers\Html;
use common\modules\settings\models\TblCoatingOptions;
use common\modules\settings\models\TblDicutOptions;
use common\modules\settings\models\TblFoilingOptions;
use common\modules\settings\models\TblFoldOptions;
use common\modules\settings\models\TblPaperSize;
use common\modules\app\models\TblPaper;
use common\modules\settings\models\TblPaperType;
use common\modules\settings\models\TblPrintOptions;
use common\modules\settings\models\TblProduct;
use common\modules\settings\models\TblProductGroup;
use common\modules\settings\models\TblProductGroupType;
use common\modules\settings\models\TblProductSetting;
use common\modules\settings\models\TblProductType;
use common\modules\settings\models\TblQuotation;
use common\modules\settings\models\TblQuotationDetail;
use common\modules\settings\models\TblUnit;
use common\modules\settings\models\TblCoatingPrice;
use common\modules\app\models\TblCoating;
use common\modules\settings\models\TblEmbossPrice;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblDiecut;
use common\modules\app\models\TblDiecutGroup;
use kartik\form\ActiveForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class ProductController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            /*[
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
            ],*/
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['checkout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['checkout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $groups = [];
        $group_types = [];
        $modelGroups = TblProductGroup::find()->all();
        foreach ($modelGroups as $modelProductGroup) {
            $rows = (new \yii\db\Query())
                ->select([
                    'tbl_product_group_type.product_group_id',
                    'tbl_product_type.product_type_id',
                    'tbl_product_type.product_type_name',
                    'tbl_product_type.product_img_path',
                    'tbl_product_type.product_img_base_url'
                ])
                ->from('tbl_product_group_type')
                ->innerJoin('tbl_product_type', 'tbl_product_type.product_type_id = tbl_product_group_type.product_type_id')
                ->where(['tbl_product_group_type.product_group_id' => $modelProductGroup->product_group_id])
                ->all();
            $groups[] = [
                'group_name' => $modelProductGroup->product_group_name,
                'group_id' => str_replace('.', '-', strtolower($modelProductGroup->product_group_id)),
            ];
            $arr = [];
            foreach ($rows as $row) {
                $arr[] = [
                    'product_type_id' => $row['product_type_id'],
                    'product_type_name' => $row['product_type_name'],
                    'product_type_icon' => $this->getProductTypeIcon($row)
                ];
            }
            $group_types[] = [
                'group_name' => $modelProductGroup->product_group_name,
                'group_id' => str_replace('.', '-', strtolower($modelProductGroup->product_group_id)),
                'items' => $arr
            ];
        }
        $product_type_all = [];
        $productTypes = TblProductType::find()->all();
        foreach ($productTypes as $productType) {
            $product_type_all[] = [
                'product_type_id' => $productType->product_type_id,
                'product_type_name' => $productType->product_type_name,
                'product_type_icon' => $this->getProductTypeIcon($productType)
            ];
        }
        return $this->render('index', [
            'groups' => $groups,
            'product_type_all' => $product_type_all,
            'group_types' => $group_types
        ]);
    }

    public function actionProductSub($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $productType = $this->findModelProductType($id);
        $products = TblProduct::find()->where([
            'product_type_id' => $id
        ])->all();
        return $this->renderAjax('_template_modal', [
            'products' => $products,
            'productType' => $productType
        ]);
    }

    protected function getProductTypeIcon($model)
    {
        return !empty($model['product_img_path']) ?
            Html::img(Url::base(true) . $model['product_img_base_url'] . str_replace('\\', '/', $model['product_img_path']), [
                'class' => 'img-fluid img-responsive center-block'
            ]) :
            Html::img(Url::base(true) . '/images/No_Image_Available.png', [
                'class' => 'img-fluid img-responsive center-block'
            ]);
    }

    public function actionQuotation($product_id)
    {
        $session = Yii::$app->session;
        $modelProduct = $this->findModelProduct($product_id);
        $modelSetting = $this->findModelProductSetting($product_id);
        $modelQuotation = new TblQuotation();
        $modelQuotationDetail = new TblQuotationDetail();
        $dataOptions = $this->selectOptions($product_id);
        $modelQuotationDetail->product_id = $product_id;
        $update = false;
        if ($session->has('cart') && $session->get('cart')) {
            $carts = $session->get('cart');
            if (isset($carts[$product_id])) {
                $attributes = $carts[$product_id];
                $modelQuotationDetail->setAttributes($attributes);
                $update = true;
            }
        }
        return $this->render('quotation', [
            'modelProduct' => $modelProduct,
            'modelSetting' => $modelSetting,
            'modelQuotation' => $modelQuotation,
            'modelQuotationDetail' => $modelQuotationDetail,
            'dataOptions' => $dataOptions,
            'update' => $update
        ]);
    }

    protected function findModelProduct($id)
    {
        if (($model = TblProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelProductType($id)
    {
        if (($model = TblProductType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelProductSetting($id)
    {
        if (($model = TblProductSetting::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelPaperSize($id)
    {
        if (($model = TblPaperSize::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelPrintOption($id)
    {
        if (($model = TblPrintOptions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelPaperType($id)
    {
        if (($model = TblPaperType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelCoatingOption($id)
    {
        if (($model = TblCoatingOptions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelDicutOption($id)
    {
        if (($model = TblDicutOptions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelFoldOption($id)
    {
        if (($model = TblFoldOptions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelFoilingOption($id)
    {
        if (($model = TblFoilingOptions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelUnit($id)
    {
        if (($model = TblUnit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelPaper($id)
    {
        if (($model = TblPaper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelCoating($id)
    {
        if (($model = TblCoating::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelCoatingPrice($id)
    {
        if (($model = TblCoatingPrice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelFold($id)
    {
        if (($model = TblFold::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelDiecut($id)
    {
        if (($model = TblDiecut::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelDiecutGroup($id)
    {
        if (($model = TblDiecutGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function selectOptions($product_id)
    {
        $queryPrintOptions = TblPrintOptions::find()->where(['product_id' => $product_id])->asArray()->all();
        $printOptions = [];//แบบการพิมพ์
        $paperSizeOptions = [];//ขนาด
        $paperTypeOptions = [];//ประเภทกระดาษ
        $coatingOptions = []; //เคลือบ
        $dicutOptions = [];//ไดคัท
        $foldOptions = [];//การพับ
        $foilingOptions = [];//ฟอยล์
        foreach ($queryPrintOptions as $queryPrintOption) {
            $printOptions[] = [
                'print_option_id' => $queryPrintOption['print_option_id'],
                'print_option_name' => $queryPrintOption['print_option_name'] .
                    '<p>' . Html::tag('span', $queryPrintOption['print_option_description'], [
                        'class' => 'desc'
                    ]) .
                    '</p>'
            ];
        }
        //
        $paperSizes = (new \yii\db\Query())
            ->select([
                'tbl_paper_size.paper_size_id',
                'tbl_paper_size.paper_size_name',
                'tbl_paper_size.paper_size_description',
                'tbl_paper_unit.paper_unit_name'
            ])
            ->from('tbl_paper_size')
            ->leftJoin('tbl_paper_unit', 'tbl_paper_unit.paper_unit_id = tbl_paper_size.paper_unit_id')
            ->where(['tbl_paper_size.product_id' => $product_id])
            ->all();
        $paperSizeOptions[] = [
            'paper_size_id' => 'custom_size',
            'paper_size_name' => 'กำหนดขนาดเอง'
        ];
        foreach ($paperSizes as $paperSize) {
            $paperSizeOptions[] = [
                'paper_size_id' => $paperSize['paper_size_id'],
                'paper_size_name' => $paperSize['paper_size_name'] . ' ' . $paperSize['paper_unit_name'] .
                    '<p>' . Html::tag('span', $paperSize['paper_size_description'], [
                        'class' => 'desc'
                    ]) .
                    '</p>'
            ];
        }

        $paperTypes = TblPaperType::find()->where(['product_id' => $product_id])->asArray()->all();
        foreach ($paperTypes as $paperType) {
            $paperTypeOptions[] = [
                'paper_type_id' => $paperType['paper_type_id'],
                'paper_type_name' => $paperType['paper_type_name'] .
                    '<p>' . Html::tag('span', $paperType['paper_type_description'], [
                        'class' => 'desc'
                    ]) .
                    '</p>'
            ];
        }

        $queryCoatingOptions = TblCoatingOptions::find()->where(['product_id' => $product_id])->asArray()->all();
        foreach ($queryCoatingOptions as $coatingOption) {
            $coatingOptions[] = [
                'coating_option_id' => $coatingOption['coating_option_id'],
                'coating_option_name' => $coatingOption['coating_option_name'] .
                    '<p>' . Html::tag('span', $coatingOption['coating_option_description'], [
                        'class' => 'desc'
                    ]) .
                    '</p>'
            ];
        }

        $queryDicutOptions = TblDicutOptions::find()->where(['product_id' => $product_id])->asArray()->all();
        foreach ($queryDicutOptions as $dicutOption) {
            $dicutOptions[] = [
                'dicut_option_id' => $dicutOption['dicut_option_id'],
                'dicut_option_name' => $dicutOption['dicut_option_name'] .
                    '<p>' . Html::tag('span', $dicutOption['dicut_option_description'], [
                        'class' => 'desc'
                    ]) .
                    '</p>'
            ];
        }

        $queryFoldOptions = TblFoldOptions::find()->where(['product_id' => $product_id])->asArray()->all();
        foreach ($queryFoldOptions as $foldOption) {
            $foldOptions[] = [
                'fold_option_id' => $foldOption['fold_option_id'],
                'fold_option_name' => $foldOption['fold_option_name'] .
                    '<p>' . Html::tag('span', $foldOption['fold_option_description'], [
                        'class' => 'desc'
                    ]) .
                    '</p>'
            ];
        }

        $queryFoilingOptions = TblFoilingOptions::find()->where(['product_id' => $product_id])->asArray()->all();
        foreach ($queryFoilingOptions as $foilingOption) {
            $foilingOptions[] = [
                'foiling_option_id' => $foilingOption['foiling_option_id'],
                'foiling_option_name' => $foilingOption['foiling_option_name'] .
                    '<p>' . Html::tag('span', $foilingOption['foiling_option_description'], [
                        'class' => 'desc'
                    ]) .
                    '</p>'
            ];
        }
        return [
            'printOptions' => $printOptions,
            'paperSizeOptions' => $paperSizeOptions,
            'paperTypeOptions' => $paperTypeOptions,
            'coatingOptions' => $coatingOptions,
            'dicutOptions' => $dicutOptions,
            'foldOptions' => $foldOptions,
            'foilingOptions' => $foilingOptions
        ];
    }

    public function actionAddToCart()
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $modelQuotationDetail = new TblQuotationDetail();
        $modelQuotationDetail->scenario = TblQuotationDetail::SCENARIO_ADD_TO_CART;
        $params = $request->post('TblQuotationDetail');
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $modelSetting = $this->findModelProductSetting($params['product_id']);
            $carts = [];
            if ($modelQuotationDetail->load($request->post()) && $modelQuotationDetail->validate()) {
                if ($session->has('cart') && is_array($session->get('cart'))) {
                    $carts = $session->get('cart');
                    $carts[$params['product_id']] = $params;
                } else {
                    $carts[$params['product_id']] = $params;
                }
                $session->set('cart', $carts);
                return [
                    'success' => true,
                    'data' => $modelQuotationDetail,
                    'cart' => $carts,
                    'count' => count($carts),
                ];
            } else {
                $validate = ActiveForm::validate($modelQuotationDetail);
                //เคลือบ
                if ($modelSetting['coating'] && empty($params['coating_option_id'])) {
                    $validate['tblquotationdetail-coating_option_id'] = ['เคลือบต้องไม่ว่างเปล่า'];
                }
                //ไดคัท
                if ($modelSetting['dicut'] && empty($params['dicut_option_id'])) {
                    $validate['tblquotationdetail-dicut_option_id'] = ['ไดคัทต้องไม่ว่างเล่า'];
                }
                //การพับ
                if ($modelSetting['fold'] && empty($params['fold_option_id'])) {
                    $validate['tblquotationdetail-fold_option_id'] = ['วิธีพับต้องไม่ว่างเปล่า'];
                }
                //ฟอยล์
                if ($modelSetting['foiling'] && empty($params['foiling_option_id'])) {
                    $validate['tblquotationdetail-foiling_option_id'] = ['สีฟอยล์ต้องไม่ว่างเปล่า'];
                }
                if ($modelSetting['foiling'] && empty($params['foiling_size'])) {
                    $validate['tblquotationdetail-foiling_size'] = ['ขนาดฟอยล์ต้องไม่ว่างเปล่า'];
                }
                if ($modelSetting['foiling'] && empty($params['foiling_unit_id'])) {
                    $validate['tblquotationdetail-foiling_unit_id'] = ['หน่วยฟอยล์ต้องไม่ว่างเปล่า'];
                }
                //ปั๊มนูน
                if ($modelSetting['embosser'] && empty($params['embosser'])) {
                    $validate['tblquotationdetail-embosser'] = ['ขนาดปั๊มนูนต้องไม่ว่างเปล่า'];
                }
                if ($modelSetting['embosser'] && empty($params['embosser_unit_id'])) {
                    $validate['tblquotationdetail-embosser_unit_id'] = ['หน่วยปั๊มนูนต้องไม่ว่างเปล่า'];
                }
                return [
                    'success' => false,
                    'validate' => $validate,
                    'data' => $modelQuotationDetail
                ];
            }
        }
    }

    public function actionCart()
    {
        /*$response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;*/
        $session = Yii::$app->session;
        $carts = [];
        $items = [];
        //$session->remove('cart');
        if ($session->has('cart') && $session->get('cart')) {
            $carts = $session->get('cart');
            foreach ($carts as $cart) {
                $des = [];
                $modelProduct = $this->findModelProduct($cart['product_id']);
                $modelSetting = $this->findModelProductSetting($cart['product_id']);
                $modelFirstPage = $this->findModelPrintOption($cart['first_page']);
                $modelLastPage = $this->findModelPrintOption($cart['last_page']);
                $modelPaperType = $this->findModelPaperType($cart['paper_type_id']);

                //หน้าแรก
                $des['first_page'] = $modelFirstPage['print_option_name'];
                //หน้าแรก
                $des['last_page'] = $modelLastPage['print_option_name'];
                //กระดาษ
                $des['paper'] = $modelPaperType['paper_type_name'];

                //ถ้าขนาดกำหนดเอง
                $paperSize = 'ขนาด';
                if ($cart['paper_size_id'] === 'custom_size') {
                    $modelUnit = $this->findModelUnit($cart['custom_paper_unit']);
                    $paperSize = $cart['custom_paper_width'] . 'x' . $cart['custom_paper_height'] . ' ' . $modelUnit['unit_name'];
                } else {
                    $modelPaperSize = $this->findModelPaperSize($cart['paper_size_id']);
                    $paperSize = $modelPaperSize['paper_size_name'];
                }
                $des['paperSize'] = $paperSize;
                //รูปภาพ
                if ($modelProduct['product_icon_path']) {
                    $url = Url::base(true) . $modelProduct['product_icon_base_url'] . str_replace('\\', '/', $modelProduct['product_icon_path']);
                } else {//default image
                    $url = Url::base(true) . '/images/bag.png';
                }

                //เคลือบ
                $des['coating'] = false;
                if ($modelSetting['coating']) {
                    $modelCoating = $this->findModelCoatingOption($cart['coating_option_id']);
                    $des['coating'] = $modelCoating['coating_option_name'];
                }
                //ไดคัท
                $des['dicut'] = false;
                if ($modelSetting['dicut']) {
                    $modelDicut = $this->findModelDicutOption($cart['dicut_option_id']);
                    $des['dicut'] = $modelDicut['dicut_option_name'];
                }
                //การพับ
                $des['fold'] = false;
                if ($modelSetting['fold']) {
                    $modelFold = $this->findModelFoldOption($cart['fold_option_id']);
                    $des['fold'] = $modelFold['fold_option_name'];
                }
                //สีฟอยล์
                $des['foiling'] = false;
                if ($modelSetting['foiling']) {
                    $modelUnit = $this->findModelUnit($cart['foiling_unit_id']);
                    $modelFoiling = $this->findModelFoilingOption($cart['foiling_option_id']);
                    $des['foiling'] = $cart['foiling_width'] . 'x' . $cart['foiling_height'] . $modelUnit['unit_name'] . ', ' . $modelFoiling['foiling_option_name'];
                }
                //ปั๊มนูน
                $des['embosser'] = false;
                if ($modelSetting['embosser']) {
                    $modelUnit = $this->findModelUnit($cart['embosser_unit_id']);
                    $des['embosser'] = 'ขนาด ' . $cart['embosser_width'] . 'x' . $cart['embosser_height'] . $modelUnit['unit_name'];
                }

                $items[] = [
                    'product_id' => $cart['product_id'],
                    'product_name' => $modelProduct['product_name'],
                    'cartQty' => $cart['quotation_qty'],
                    'cartImage' => Html::img($url, ['class' => 'img-responsive img-rounded cart-image hidden-xs', 'alt' => 'image']),
                    'des' => $des
                ];
            }
        }
        return $this->render('cart', [
            'carts' => $items
        ]);
    }

    public function actionDeleteCart($itemId)
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $session = Yii::$app->session;
        if ($session->has('cart') && $session->get('cart')) {
            $carts = $session->get('cart');
            if (isset($carts[$itemId])) {
                ArrayHelper::remove($carts, $itemId);
                $session->set('cart', $carts);
            }
        }
        return 'Deleted!';
    }

    public function actionCheckout()
    {

    }

    public function actionCalculatePrice()
    {
        $request = Yii::$app->request;
        if($request->isPost) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $data = $request->post('TblQuotationDetail');
            $result = [];

            //กระดาษ
            $modelPaper = $this->findModelPaper($data['paper_id']);

            //ประเภทกระดาษ
            $modelPaperType = $this->findModelPaperType($modelPaper['paper_type_id']);

            //สติ๊กเกอร์ หรือไม่ใช่ สติ๊กเกอร์
            $isSticker = $modelPaperType['paper_type_flag'] === 1; // 1 หรือ 0

            // ขนาดกระดาษ เอาไว้คำนวณกรณีที่ไม่ใช่ sticker
            $papers = [
                ['paper_cut' => 4, 'print_area_width' => 12.5, 'print_area_length' => 18, 'paper_size' => 'S'],
                ['paper_cut' => 5, 'print_area_width' => 13, 'print_area_length' => 18, 'paper_size' => 'L'],
                ['paper_cut' => 8, 'print_area_width' => 15.5, 'print_area_length' => 10.75, 'paper_size' => 'L'],
            ];

            //ไดคัท
            $isDiecut = !($data['diecut'] === 'N');
            
            $paper_cut_final = 0; //ตัด
            $paper_size = ''; // ขนาด
            $print_area_final_width = 0; //กว้าง
            $print_area_final_length = 0; //ยาว
            //ถ้าเป็น sticker จากข้อ 3
            if($isSticker) {
                $paper_cut_final = 4;
                $paper_size = 'L';
                //ไม่มีไดคัท
                if(!$isDiecut){
                    $print_area_final_width = 13; // นิ้ว
                    $print_area_final_length = 19; // นิ้ว
                } else {
                    $print_area_final_width = 11.9; // นิ้ว
                    $print_area_final_length = 16.5; // นิ้ว
                }
            }

            //ถ้าเป็นขนาดกำหนดเอง
            $size_width = 0;
            $size_length = 0;
            if($data['paper_size_id'] === 'custom') {
                if($data['paper_size_unit'] == 2){
                    $size_width = number_format($data['paper_size_width']*0.3937, 2);
                    $size_length = number_format($data['paper_size_height']*0.3937, 2);
                } else {
                    $size_width = $data['paper_size_width'];//ความกว้างที่ลูกค้ากำหนด
                    $size_length = $data['paper_size_height'];//ความยาวที่ลูกค้ากำหนด
                }
            } else {
                $modelPaperSize = $this->findModelPaperSize($data['paper_size_id']);
                if($modelPaperSize['paper_unit_id'] == 2){
                    $size_width = number_format($modelPaperSize['paper_size_width']*0.3937, 2);
                    $size_length = number_format($modelPaperSize['paper_size_height']*0.3937, 2);
                } else {
                    $size_width = $modelPaperSize['paper_size_width'];//ความกว้างในฐานข้อมูล
                    $size_length = $modelPaperSize['paper_size_height'];//ความยาวในฐานข้อมูล
                }
            }

            //ถ้ามีการพับครึ่ง
            if($data['fold_id'] === 'FOLD-00003') {
                $size_width = ($size_width * 2);
                $size_length = ($size_length * 2);
            }

            //ขนาดที่ได้มาจากลูกค้าให้บวก 0.3 ซม. ทั้งสองด้าน
            $size_width_cal = ($size_width + 0.3);
            $size_length_cal = ($size_length + 0.3);

            //หาจานวนชิ้นงาน ข้อ 5
            $job_per_sheet = 0;
            if(!$isSticker) {// is not Sticker
                $dataJob = $this->calculateJobpersheet($isSticker, $papers, $size_width_cal, $size_length_cal);
                $print_area_final_width = $dataJob['result']['print_area_width'];
                $print_area_final_length  = $dataJob['result']['print_area_length'];
                $paper_cut_final = $dataJob['result']['paper_cut'];
                $paper_size = $dataJob['result']['paper_size'];
                $job_per_sheet = number_format($dataJob['result']['job_per_sheet'], 2);
            } else {// is sticker
                $vertical_lay_width = ($print_area_final_width / $size_width_cal);
                $vertical_lay_length = ($print_area_final_length / $size_length_cal);
                $vertical_lay_total = ($vertical_lay_width * $vertical_lay_length);

                $horizon_lay_width = ($print_area_final_width / $size_length_cal);
                $horizon_lay_length = ($print_area_final_length / $size_width_cal);
                $horizon_lay_total = ($horizon_lay_width * $horizon_lay_length);

                if($vertical_lay_total > $horizon_lay_total) {
                    $job_per_sheet = number_format($vertical_lay_total, 2);
                } else {
                    $job_per_sheet = number_format($horizon_lay_total, 2);
                }
            }

            //คำนวณหาจำนวนแผ่นพิมพ์ ข้อ 6
            $qty = [1000, 2000, 5000];
            if(!empty($request->post('qty'))){
                $qty = $request->post('qty');
            }
            foreach ($qty as $value) {
                $cust_quantity = $value; // จานวนที่ลูกค้าต้องการพิมพ์
                $print_sheet_total = ($cust_quantity / $job_per_sheet); //จำนวนแผ่นพิมพ์

                //ถ้ามีการเคลือบ ข้อ 7
                $isCoating = $data['coating_id'] !== 'N' && !empty($data['coating_id']);
                $laminate_price = 0; // ค่าเคลือบต่อใบ default ราคา เป็น 0 กรณีไม่เคลือบ
                if($isCoating) {
                    $modelCoating = $this->findModelCoating($data['coating_id']);
                    $print_sheet_total = ($print_sheet_total + 2); //ต้องมีการเผื่อกระดาษ
                    $coatingPrices = TblCoatingPrice::find()->all(); //ราคาเคลือบ
                    //หาขนาดพื้นที่ (ตร.นิ้ว) แล้วเอามาเปรียบเทียบ
                    $sq = ($print_area_final_width * $print_area_final_length);// ขนาดของลูกค้า
                    foreach ($coatingPrices as $key => $coatingPrice) {
                        if($sq <= $coatingPrice['coating_sq_in']) {
                            if($modelCoating['coating_id'] === 'C-00001'){ // PVC ด้าน
                                $laminate_price = $coatingPrice['coating_matte_price'] * $print_sheet_total;
                            }
                            if($modelCoating['coating_id'] === 'C-00002'){ // PVC เงา
                                $laminate_price = $coatingPrice['coating_varnish_price'] * $print_sheet_total;
                            }
                            if($modelCoating['coating_id'] === 'C-00003'){ // UV
                                $laminate_price = $coatingPrice['coating_uv_price'] * $print_sheet_total;
                            }
                            break;
                        }
                    }
                    //ถ้าเคลือบสองหน้า
                    if($data['coating_option'] === 'two_page') {
                        $laminate_price = ($laminate_price * 2);
                    }
                    // ตรวจสอบราคาขั้นต่ำ 200
                    if($laminate_price < 200){
                        $laminate_price = 200;
                    }
                }

                //ตรวจสอบหน้าจอว่ามีการปั๊มฟอยล์หรือไม่ ข้อ 8
                $isFoil = !empty($data['foil_size_width']) && !empty($data['foil_size_height']);
                $foil_price = 0;
                $block_foil_price = 0;//ค่าฟอยล์ต่อ ตรน.
                $sqFoilSize = 0;
                if($isFoil){//ปั๊มฟอยล์
                    $sq_foil_price = 0; //ค่าฟอยล์ต่อ ตรน.
                    if($data['foil_color_id'] === 'FOIL-00003' || $data['foil_color_id'] === 'FOIL-00005'){
                        $sq_foil_price = 0.5;
                    } elseif($data['foil_color_id'] === 'FOIL-00004') {
                        $sq_foil_price = 2;
                    }
                    $foil_price = $sq_foil_price * $cust_quantity;
                    if($foil_price < 300){
                        $foil_price = 300;
                    } else {
                        if($data['foil_size_unit'] == 2){//ถ้าหน่วยเป็น ซม.
                            $foil_size_width = number_format($data['foil_size_width']*0.3937, 2);
                            $foil_size_height = number_format($data['foil_size_height']*0.3937, 2);
                            $sqFoilSize = ($foil_size_width * $foil_size_height);//ขนาด ตรน จากหน้าจอ
                        } else {
                            $sqFoilSize = ($data['foil_size_width'] * $data['foil_size_height']);//ขนาด ตรน จากหน้าจอ
                        }
                        if($sqFoilSize >= 30){
                            $foil_price = ($sqFoilSize * 18);
                        } else {
                            $tablePrices = TblEmbossPrice::find()->all();// ค่าบล็อกจากฐานข้อมูล
                            //เปรียบเทียบ
                            foreach ($tablePrices as $key => $tablePrice) {
                                if($tablePrice['emboss_price_size'] >= $sqFoilSize) {//ถ้าขนาด ตรน จากหน้าจอ น้อยกว่า เท่ากับ ขนาด ตรน ในฐานข้อมูล
                                    $block_foil_price = $tablePrice['emboss_price'];//ค่าบล็อกจะเท่ากับค่าบล็อกในฐานข้อมูล
                                    break;
                                }
                            }
                            $foil_price = $block_foil_price * $foil_price;
                        }
                    }
                }

                //ตรวจสอบหน้าจอว่ามีการปั๊มนูนหรือไม่ ข้อ 9
                $isEmboss = !empty($data['emboss_size_width']) && !empty($data['emboss_size_height']);
                $emboss_price = 0;
                if($isEmboss) {
                    $embossPrices = TblEmbossPrice::find()->all();// ค่าปั๊มนูนจากฐานข้อมูล
                    if($data['emboss_size_unit'] == 2){//ถ้าหน่วยเป็น ซม.
                        $emboss_size_width = number_format($data['emboss_size_width']*0.3937, 2);
                        $emboss_size_height = number_format($data['emboss_size_height']*0.3937, 2);
                        $sqEmbossSize = ($emboss_size_width * $emboss_size_height);//ขนาด ตรน จากหน้าจอ
                    } else {
                        $sqEmbossSize = ($data['emboss_size_width'] * $data['emboss_size_height']);//ขนาด ตรน จากหน้าจอ
                    }
                    //เปรียบเทียบ
                    foreach ($embossPrices as $key => $embossPrice) {
                        if($sqEmbossSize <= $embossPrice['emboss_price_size']) {
                            $emboss_price = ($cust_quantity * 0.3); // จานวนที่ลูกค้าต้องการพิมพ์ * 0.3
                            if($emboss_price < 300) {//ราคาขั้นต่ำ
                                $emboss_price = 300;
                            } else {
                                $emboss_price = $embossPrice['emboss_price'] + $foil_price; // ค่าบล็อก บวก ค่าปั๊มฟอยล์
                            }
                            break;
                        }
                    }
                }

                //ตรวจสอบจากหน้าจอว่ามีการพับครึ่ง หรือไม่ ข้อ 10
                $price_block = 200;
                $fold_price = 0;
                if($data['fold_id'] === 'FOLD-00003') {//พับครึ่ง
                    $modelFold = $this->findModelFold($data['fold_id']);
                    if($modelPaper['paper_gram'] >= 200) {//ถ้าขนาดกระดาษ มากกว่าเท่ากับ 200 แกรม
                        if($print_sheet_total <= 50){//ถ้าจำนวนแผ่นพิมพ์ น้อยกว่า เท่ากับ 50
                            $fold_price = $print_sheet_total * 20;
                        } else {//ถ้าจำนวนแผ่นพิมพ์ มากกว่า 50 ต้องใช้บล็อก
                            $fold_price = $print_sheet_total * 0.3;
                            //ตรวจสอบราคาขั้นต่ำ 200
                            if($fold_price < 200) {
                                $fold_price = 200;
                            } else {
                                $fold_price = $price_block + $fold_price;
                            }
                        }
                    } else {//กระดาษบาง ตรวจสอบว่าพับกี่ตอน
                        if($cust_quantity <= 500) { // จำนวนที่ลูกค้าต้องการพิมพ์ 
                            $fold_price = $cust_quantity * 0.25 * $modelFold['fold_count']; //จำนวนที่ลูกค้าต้องการ + 0.25 + ตอนพับ
                        } else {
                            $fold_price = $cust_quantity * 1.25 * $modelFold['fold_count']; //จำนวนที่ลูกค้าต้องการ + 1.25 + ตอนพับ
                            //ตรวจสอบราคาขั้นต่ำ 300
                            if ($fold_price < 300) {
                                $fold_price = 300;
                            }
                        }
                    }
                }

                //ตรวจสอบจากหน้าจอว่าลูกค้าเลือกให้มีการไดคัทมุมมนหรือไม่ ข้อ 11
                $roundcurve_price = 0;//ราคามุม
                $dicut_price = 0; // ราคาไดคัท
                $dicut_block_price = 0; //ราคาบล็อกไดคัท
                if($data['diecut'] === 'Curve'){//ไดคัทมุมมน กี่มุม
                    $modelDiecut = $this->findModelDiecut($data['diecut_id']);
                    $modelDiecutGroup = $this->findModelDiecutGroup($modelDiecut['diecut_group_id']);

                    if($cust_quantity <= 1000){//จำนวนน้อยกว่า 1000 แผ่น
                        $roundcurve_price = $cust_quantity * 0.25 * $modelDiecutGroup['diecut_group_value'];
                    } 
                    /* if($isSticker && $print_sheet_total < 100) {//จำนวนน้อยกว่า 100 แผ่น และเป็นสติ๊กเกอร์
                        if($job_per_sheet < 30){
                            $dicut_price = $print_sheet_total * 10;
                        } else {
                            $dicut_price = $print_sheet_total * 20;
                        }
                    } else {// เป็นกระดาษ หรือเป็นสติกเกอร์ที่มากกว่า 100 แผ่น
                        $print_sheet_total = $print_sheet_total + 5;
                        $dicut_block_price = 800;
                        $dicut_price = ($print_sheet_total * 3) * 0.3;
                    }
                    if($dicut_price < 300){
                        $dicut_price = 300;
                    } else {
                        $dicut_price = $dicut_block_price + $dicut_price;
                    } */
                } elseif($data['diecut'] === 'Default') {//ไดคัทตามรูปแบบ ข้อ 12
                    if ($isSticker && $print_sheet_total < 100) {//จานวนน้อยกว่า 100 แผ่น
                        if ($job_per_sheet < 30) {
                            $dicut_price = $print_sheet_total * 10;
                        } else {
                            $dicut_price = $print_sheet_total * 20;
                        }
                    } else {// เป็นกระดาษ หรือเป็นสติกเกอร์ที่มากกว่า 100 แผ่น
                        $print_sheet_total = $print_sheet_total + 5;
                        $dicut_block_price = 800;
                        $dicut_price = ($print_sheet_total * 3) * 0.3;
                    }
                    // ตรวจสอบราคาขั้นต่ำ
                    if($dicut_price < 300){
                        $dicut_price = 300;
                    } else {
                        $dicut_price = $dicut_block_price + $dicut_price;
                    }
                }

                //คำนวณค่าพิมพ์ ข้อ 13
                //ถ้าพิมพ์หน้าเดียว หน้าแรกตรวจสอบว่าเป็น สี่สี หรือ สีเดียว (ไม่ใช่สีดา) หรือ สีเดียว (สีดา)
                $printing_price = 0;
                if($data['before_print'] === 'PT-00004' && !empty($data['before_print'])){//หน้าเดียว สีดำ
                    $printing_price = ($print_sheet_total * 5);
                } elseif($data['before_print'] !== 'PT-00004' && !empty($data['before_print'])) {
                    $printing_price = ($print_sheet_total * 20);
                }

                //ถ้าพิมพ์สองหน้า ให้ทาเหมือนกัน โดยตรวจสอบหน้าที่สองว่าเป็น สี่สี หรือ สีเดียว (ไม่ใช่สีดา) หรือ สีเดียว (สีดา)
                if($data['after_print'] === 'PT-00004' && !empty($data['after_print'])) {//สองหน้า สีดำ
                    $printing_price = $printing_price + ($print_sheet_total * 5);
                } elseif($data['after_print'] !== 'PT-00004' && !empty($data['after_print'])) {
                    $printing_price = $printing_price + ($print_sheet_total * 20);
                }

                $paper_bigsheet = ($print_sheet_total / $paper_cut_final); //หาราคากระดาษโดยนาจานวนแผ่นพิมพ์ที่ได้
                $paper_price = $paper_bigsheet * $modelPaper['paper_price']; //ราคากระดาษ

                $final_price_digital = $paper_price + $printing_price + $laminate_price + $dicut_price + $roundcurve_price + $fold_price + $foil_price + $emboss_price;
                $final_price = $final_price_digital + (($final_price_digital * 20) / 100);
                $summary = ceil($final_price/10)*10;
                $price_per_item = ($summary / $cust_quantity);
               

                $result[] = [
                    'final_price_digital' => Yii::$app->formatter->format($final_price_digital,['decimal', 2]),
                    'final_price' => Yii::$app->formatter->format($summary,['decimal', 2]),
                    'old_final_price' => Yii::$app->formatter->format(ceil($final_price),['decimal', 2]),
                    'price_per_item' =>  Yii::$app->formatter->format(ceil($price_per_item),['decimal', 2]),
                    'isSticker' => $isSticker,
                    'paper_cut_final' => $paper_cut_final,
                    'paper_size' => $paper_size,
                    'job_per_sheet' => Yii::$app->formatter->format($job_per_sheet,['decimal', 2]),
                    'print_area_final_width' => $print_area_final_width,
                    'print_area_final_length' => $print_area_final_length,
                    'paper_cut_final' => $paper_cut_final,
                    'paper_size' => $paper_size,
                    'print_sheet_total' => $print_sheet_total,
                    'laminate_price' => Yii::$app->formatter->format($laminate_price,['decimal', 2]),
                    'foil_price' => Yii::$app->formatter->format($foil_price,['decimal', 2]),
                    'emboss_price' => Yii::$app->formatter->format($emboss_price,['decimal', 2]),
                    'fold_price' => Yii::$app->formatter->format($fold_price,['decimal', 2]),
                    'dicut_price' => Yii::$app->formatter->format($dicut_price, ['decimal', 2]),
                    'printing_price' => Yii::$app->formatter->format($printing_price, ['decimal', 2]),
                    'paper_price' => Yii::$app->formatter->format($paper_price, ['decimal', 2]),
                    'isDiecut' => $isDiecut,
                    'isCoating' => $isCoating,
                    'cust_quantity' => $cust_quantity,
                    'size_width_cal' => $size_width_cal,
                    'size_length_cal' => $size_length_cal,
                    'size_width' => $size_width,
                    'size_length' => $size_length,
                    'block_foil_price' => $block_foil_price,
                    'sqFoilSize' => $sqFoilSize,
                    'isFoil' => $isFoil,
                ];
            }
            return $result;
        }
    }

    private function calculateJobpersheet($isSticker, $papers, $size_width_cal, $size_length_cal)
    {
        //แนวตั้ง
        $vertical_lay_width = 0;
        $vertical_lay_length = 0;
        $vertical_lay_total = 0;

        //แนวนอน
        $horizon_lay_width = 0;
        $horizon_lay_length = 0;
        $horizon_lay_total = 0;

        $job_per_arr = [];
        $per_sheet_arr = [];
        $job_per_sheet = 0;

        $result = [];

        foreach ($papers as $key => $paper) {
            $vertical_lay_width = ($paper['print_area_width'] / $size_width_cal);
            $vertical_lay_length = ($paper['print_area_length'] / $size_length_cal);
            $vertical_lay_total = ($vertical_lay_width * $vertical_lay_length);

            $horizon_lay_width = ($paper['print_area_width'] / $size_length_cal);
            $horizon_lay_length = ($paper['print_area_length'] / $size_width_cal);
            $horizon_lay_total = ($horizon_lay_width * $horizon_lay_length);

            //หาการวางงานที่ได้จานวนเยอะที่สุด
            if($vertical_lay_total > $horizon_lay_total) {
                $job_per_arr[] = ArrayHelper::merge($paper, ['job_per_sheet' => number_format($vertical_lay_total, 2)]);
                $per_sheet_arr[] = number_format($vertical_lay_total, 2);
            } else {
                $job_per_arr[] = ArrayHelper::merge($paper, ['job_per_sheet' => number_format($horizon_lay_total,2)]);
                $per_sheet_arr[] = number_format($horizon_lay_total,2);
            }
        }
        //หาค่าสูงสุดจากการคำนวณ
        $max_job_per_sheet = max($per_sheet_arr);
        $min_job_per_sheet = min($per_sheet_arr);
        //ถ้าได้ค่าเท่ากัน
        if($max_job_per_sheet === $min_job_per_sheet){
            $job_per_sheet = $min_job_per_sheet;
        } else {//เอาค่าที่น้อยที่สุด
            $job_per_sheet = $max_job_per_sheet;
        }

        // เอาค่าที่ได้จากการคำนวณมาหาค่า
        foreach($job_per_arr as $item) {
            if($item['job_per_sheet'] === $job_per_sheet) {
                $result = $item;
                break;
            }
        }
        return [
            'result' => $result,
            'job_per_arr' => $job_per_arr,
            'per_sheet_arr' => $per_sheet_arr,
        ];
    }
}
