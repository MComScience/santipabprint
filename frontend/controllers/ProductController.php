<?php

namespace frontend\controllers;

use adminlte\helpers\Html;
use common\modules\settings\models\TblCoatingOptions;
use common\modules\settings\models\TblDicutOptions;
use common\modules\settings\models\TblFoilingOptions;
use common\modules\settings\models\TblFoldOptions;
use common\modules\settings\models\TblPaperSize;
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
}
