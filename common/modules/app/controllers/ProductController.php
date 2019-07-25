<?php

namespace common\modules\app\controllers;

use adminlte\helpers\Html;
use common\components\QueryBuilder;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblQuotation;
use common\modules\app\models\TblQuotationDetail;
use common\modules\app\traits\ModelTrait;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

class ProductController extends \yii\web\Controller
{

    use ModelTrait;

    public $layout = '@kidz/views/layouts/main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['quotation', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@', 'admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['quotation', 'index'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            /* 'httpCache' => [
        'class' => 'yii\filters\HttpCache',
        'only' => ['index'],
        'lastModified' => function ($action, $params) {
        return time();
        },
        //'sessionCacheLimiter' => 'public',
        'cacheControlHeader' => 'public, max-age=3600',
        ] */
        ];
    }

    public function actionIndex()
    {
        $catagorys = TblProductCategory::find()->all();
        $itemCatagorys = [];
        foreach ($catagorys as $key => $catagory) {
            $itemCatagorys[] = [
                'product_category_id' => $catagory['product_category_id'],
                'product_category_name' => $catagory['product_category_name'],
                'image_url' => Url::base(true) . Url::to(['/site/glide', 'path' => $catagory->getImageUrl(), 'w' => '112', 'h' => '112']),
            ];
        }
        return $this->render('index', [
            'catagorys' => $itemCatagorys
        ]);
        /* //หมวดหมู่
    $categorys = TblProductCategory::find()->all();
    //สินค้าทั้งหมด
    $allProducts = TblProduct::find()->all();
    $productGroups = [];
    foreach ($categorys as $category) {
    $productGroups[] = [
    'product_category_id' => $category['product_category_id'],
    'product_category_name' => $category['product_category_name'],
    'items' => TblProduct::find()->where(['product_category_id' => $category['product_category_id']])->all()
    ];
    }
    return $this->render('index', [
    'categorys' => $categorys,
    'allProducts' => $allProducts,
    'productGroups' => $productGroups
    ]); */
    }

    public function actionCategory($id)
    {
        $catagory = TblProductCategory::findOne($id);
        $itemProducts = [];
        if($catagory) {
            $products = TblProduct::find()->where(['product_category_id' => $id])->orderBy('package_type_id ASC')->all();
            foreach ($products as $key => $product) {
                $itemProducts[] = [
                    'product_id' => $product['product_id'],
                    'product_name' => $product['product_name'],
                    'image_url' =>  Url::base(true) . $product->getImageUrl(),
                ];
            }
        }
        return $this->render('category', [
            'products' => $itemProducts,
            'catagory' => $catagory
        ]);
    }

    public function actionQuotation($p, $slug = null)
    {
        $request = Yii::$app->request;
        $update = false;
        $modelProduct = $this->findModelProduct($p);
        $modelProductOption = $this->findModelProductOption($p);
        $modelQuotation = new TblQuotation();
        $model = new TblQuotationDetail();
        $model->product_id = $modelProduct['product_id'];
        $option = $modelProduct->options;
        $fetchOptions = $this->fetchOptions($model, $option);
        if ($model->load($request->post())) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $params = $request->post('TblQuotationDetail');
            $validate = $this->fetchValidate($model, $params, $fetchOptions);
            if ($validate) {
                return [
                    'success' => false,
                    'validate' => $validate,
                ];
            } else if ($modelQuotation->save()) {

            }
        } else {
            $queryBuilder = new QueryBuilder(['modelOption' => $modelProductOption]);
            //return Json::encode($validates);
            return $this->render('quotation', [
                'option' => $option,
                'modelProduct' => $modelProduct,
                'modelQuotation' => $modelQuotation,
                'model' => $model,
                'queryBuilder' => $queryBuilder,
                'update' => $update,
                'validates' => $fetchOptions['validation'],
            ]);
        }
    }

    public function actionDownload($p)
    {
        $request = Yii::$app->request;
        $model = new TblQuotation();
        $modelDetail = new TblQuotationDetail();
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('download') . 'ดาวน์โหลดใบเสนอราคา',
                    'content' => $this->renderAjax('_form_download', [
                        'model' => $model,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post())) {
                $modelDetail->setAttributes($request->post('TblQuotationDetail'));
                $modelDetail->final_price = str_replace(',', '', $request->post('final_price'));
                if ($model->save()) {
                    $modelDetail->quotation_id = $model['quotation_id'];
                    if ($modelDetail->save()) {
                        return [
                            'success' => true,
                            'message' => 'Success',
                            'url' => Url::to(['quo', 'q' => $model['quotation_id']]),
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
    }

    private function convertNumber($number)
    {
        if (empty($number)) {
            return '';
        }

        return (int) preg_replace("/.*\./", "", $number) > 0 ? number_format($number, 1) : number_format($number, 0);
    }

    public function actionQuo($q)
    {
        $model = $this->findModelQuotation($q);
        $modelItems = TblQuotationDetail::find()->where(['quotation_id' => $q])->all();
        $items = [];
        $summary = 0;
        $nbsp = '&nbsp';
        $nbsp2 = ': &nbsp;';
        $x = 'x';
        $newline = "\n";
        foreach ($modelItems as $item) {
            $modelProduct = $this->findModelProduct($item['product_id']);
            $option = $modelProduct->options;
            $modelProductOption = $this->findModelProductOption($item['product_id']);
            $queryBuilder = new QueryBuilder(['modelOption' => $modelProductOption]);
            $details = Html::tag('strong', $modelProduct['product_name']) . $newline;
            //ขนาด
            if (!empty($item['paper_size_id'])) {
                if ($item['paper_size_id'] === 'custom') {
                    $modelUnit = $this->findModelUnit($item['paper_size_unit']);
                    $paper_size_width = $this->convertNumber($item['paper_size_width']);
                    $paper_size_height = $this->convertNumber($item['paper_size_height']);
                    $paper_height = $this->convertNumber($item['paper_height']);
                    if (empty($paper_height)) {
                        $details .= $queryBuilder->getInputLabel($option, 'paper_size_id', $item) . $nbsp2 .
                            $paper_size_width . $x . $paper_size_height . $nbsp .
                            $modelUnit['unit_name'] . $newline;
                    } else {
                        $details .= $queryBuilder->getInputLabel($option, 'paper_size_id', $item) . $nbsp2 .
                            $paper_size_width . $x . $paper_size_height . $x . $paper_height . $nbsp .
                            $modelUnit['unit_name'] . $newline;
                    }
                } else {
                    $modelPaperSize = $this->findModelPaperSize($item['paper_size_id']);
                    $details .= $queryBuilder->getInputLabel($option, 'paper_size_id', $item) . $nbsp2 . $modelPaperSize['paper_size_name'] . $newline;
                }
            }
            //จำนวน
            if (!empty($item['page_qty'])) {
                $details .= $queryBuilder->getInputLabel($option, 'page_qty', $item) . $nbsp2 . $item['page_qty'] . $newline;
            }
            //กระดาษ
            if (!empty($item['paper_id'])) {
                $modelPaper = $this->findModelPaper($item['paper_id']);
                $size = '&nbsp;(ขนาด ' . $this->convertNumber($modelPaper['paper_width']) . 'x' . $this->convertNumber($modelPaper['paper_length']) . ')';
                $details .= $queryBuilder->getInputLabel($option, 'paper_id', $item) . ': &nbsp;(' . $modelPaper->paperType->paper_type_name . ') ' . $modelPaper['paper_name'] . '  ' . $modelPaper['paper_gram'] . ' แกรม ' . $size . $newline;
            }
            //พิมพ์สองหน้า
            if (!empty($item['before_print'])) {
                $modelBeforePrint = $this->findModelColorPrinting($item['before_print']);
                $details .= $queryBuilder->getInputLabel($option, 'before_print', $item) . $nbsp2 . $modelBeforePrint['color_printing_name'] . $newline;
            }
            //พิมพ์หน้าเดียว
            if (!empty($item['after_print'])) {
                $modelBeforePrint = $this->findModelColorPrinting($item['after_print']);
                $details .= $queryBuilder->getInputLabel($option, 'after_print', $item) . $nbsp2 . $modelBeforePrint['color_printing_name'] . $newline;
            }

            //เคลือบ
            if (!empty($item['coating_id']) && $item['coating_id'] != 'N') {
                if ($item['coating_id'] === 'N') {
                    $details .= 'เคลือบ : ' . $nbsp . 'ไม่เคลือบ' . $newline;
                } else {
                    $modelCoating = $this->findModelCoating($item['coating_id']);
                    if ($item['coating_option'] === 'one_page') {
                        $details .= $queryBuilder->getInputLabel($option, 'coating_id', $item) . $nbsp2 . $modelCoating['coating_name'] . ' (ด้านเดียว)' . $newline;
                    } elseif ($item['coating_option'] === 'two_page') {
                        $details .= $queryBuilder->getInputLabel($option, 'coating_id', $item) . $nbsp2 . $modelCoating['coating_name'] . ' (สองด้าน)' . $newline;
                    } else {
                        $details .= $queryBuilder->getInputLabel($option, 'coating_id', $item) . $nbsp2 . $modelCoating['coating_name'] . $newline;
                    }
                }
            }
            //ไดคัท
            if (!empty($item['diecut_id']) && $item['diecut'] != 'N') {
                if ($item['diecut_id'] === 'N') {
                    $details .= $queryBuilder->getInputLabel($option, 'diecut_id', $item) . $nbsp2 . 'ไม่ไดคัท' . $newline;
                } elseif ($item['diecut_id'] === 'default') {
                    $details .= $queryBuilder->getInputLabel($option, 'diecut_id', $item) . $nbsp2 . 'ตามรูปแบบ' . $newline;
                } else {
                    $modelDiecut = $this->findModelDiecut($item['diecut_id']);
                    $details .= $queryBuilder->getInputLabel($option, 'diecut_id', $item) . ': &nbsp;(' . $modelDiecut->diecutGroup->diecut_group_name . ') ' . $modelDiecut['diecut_name'] . $newline;
                }
            }
            //วิธีพับ
            if (!empty($item['fold_id']) && $item['fold_id'] != 'N') {
                if ($item['fold_id'] === 'N') {
                    $details .= $queryBuilder->getInputLabel($option, 'fold_id', $item) . $nbsp2 . 'ไม่พับ' . $newline;
                } else {
                    $modelFold = $this->findModelFold($item['fold_id']);
                    $details .= $queryBuilder->getInputLabel($option, 'fold_id', $item) . $nbsp2 . $modelFold['fold_name'] . $newline;
                }
            }
            //ฟอยล์
            if (!empty($item['foil_color_id'])) {
                $foil_size_width = $this->convertNumber($item['foil_size_width']);
                $foil_size_height = $this->convertNumber($item['foil_size_height']);

                $modelFoil = $this->findModelFoilColor($item['foil_color_id']);
                $modelFoilUnit = $this->findModelUnit($item['foil_size_unit']);

                $details .= 'ฟอยล์ ขนาด: ' . $nbsp . $foil_size_width . $x . $foil_size_height . $modelFoilUnit['unit_name'] . $nbsp . $modelFoil['foil_color_name'] . $newline;
            }
            //ปั๊มนูน
            if (!empty($item['emboss_size_width']) && !empty($item['emboss_size_height']) && !empty($item['emboss_size_unit'])) {

                $emboss_size_width = $this->convertNumber($item['emboss_size_width']);
                $emboss_size_height = $this->convertNumber($item['emboss_size_height']);

                $modelEmBossUnit = $this->findModelUnit($item['emboss_size_unit']);

                $details .= 'ปั๊มนูน ขนาด: ' . $nbsp . $emboss_size_width . $x . $emboss_size_height . $modelEmBossUnit['unit_name'] . $newline;
            }
            //แนวตัง/แนวนอน
            if (!empty($item['land_orient'])) {
                $details .= 'แนวตั้ง/แนวนอน : ' . $nbsp . ($item['land_orient'] === '1' ? 'แนวตั้ง' : 'แนวนอน') . $newline;
            }
            //เข้าเล่ม
            if (!empty($item['book_binding_id']) && $item['book_binding_id'] != 'N') {
                if ($item['book_binding_id'] === 'N') {
                    $details .= 'เข้าเล่ม : ' . $nbsp . 'ไม่เข้าเล่ม' . $newline;
                } else {
                    $modelBookBinding = $this->findModelBookBinding($item['book_binding_id']);
                    $details .= 'เข้าเล่ม : ' . $nbsp . $modelBookBinding['book_binding_name'] . $newline;
                }
            }
            $items[] = [
                'product_id' => $item['product_id'],
                'data' => $item,
                'product_name' => $modelProduct['product_name'],
                'details' => str_replace('<span class="text-danger">*</span>', '', $details),
            ];
            $summary = $summary + $item['final_price'];
        }
        return $this->renderAjax('invoice1', [
            'model' => $model,
            'items' => $items,
            'summary' => $summary,
            'modelItems' => $modelItems,
        ]);

//        return $this->renderAjax('invoice1', [
        //            'model' => $model,
        //            'items' => $items,
        //            'summary' => $summary,
        //            'modelItems' => $modelItems
        //        ]);
    }

    protected function fetchOptions($model, $option)
    {
        $attributes = $model->getAttributes();
        $validation = [];
        $requiredOps = [];
        $valueOps = [];
        $labelOps = [];
        foreach ($option as $key => $ops) {
            $requiredOps[$key] = (int) $ops['required'];
            $valueOps[$key] = (int) $ops['value'];
            $labelOps[$key] = $ops['label'];
        }
        foreach ($attributes as $attribute => $value) {
            $msg = $model->getAttributeLabel($attribute);
            $required = ArrayHelper::getValue($requiredOps, $attribute, false);
            $skip = ArrayHelper::getValue($valueOps, $attribute, false);
            if ($required && $skip) {
                $message = ArrayHelper::getValue($labelOps, $attribute, $msg) . 'ต้องไม่ว่างเปล่า';
                $validation[] = [
                    'id' => Html::getInputId($model, $attribute),
                    'name' => $attribute,
                    'container' => '.field-' . Html::getInputId($model, $attribute),
                    'input' => '#' . Html::getInputId($model, $attribute),
                    'error' => '.help-block',
                    'validate' => new JsExpression('function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {message: ' . Json::encode($message) . '});
                    }'),
                ];
            }
        }
        return [
            'validation' => $validation,
            'requiredOps' => $requiredOps,
            'labelOps' => $labelOps,
            'valueOps' => $valueOps,
            'attributes' => $attributes,
        ];
    }

    protected function fetchValidate($model, $params, $fetchOptions)
    {
        $validate = ActiveForm::validate($model);
        $attributes = $model->getAttributes();
        $attrs = ['paper_size_width', 'paper_size_height', 'paper_size_unit'];
        foreach ($attributes as $attribute => $item) {
            $required = ArrayHelper::getValue($fetchOptions['requiredOps'], $attribute, false);
            if (isset($params[$attribute]) && ($attribute === 'paper_size_id') && ($params[$attribute] === 'custom')) {
                foreach ($attrs as $attr) {
                    if (empty($params[$attr])) {
                        $msg = $model->getAttributeLabel($attr);
                        $message = ArrayHelper::getValue($fetchOptions['labelOps'], $attr, $msg) . 'ต้องไม่ว่างเปล่า';
                        $inputId = Html::getInputId($model, $attr);
                        $validate[$inputId] = [$message];
                    }
                }
            } elseif (isset($params[$attribute]) && empty($params[$attribute]) && $required) {
                if (!ArrayHelper::isIn($attribute, ['paper_size_width', 'paper_size_height', 'paper_size_unit'])) {
                    $msg = $model->getAttributeLabel($attribute);
                    $message = ArrayHelper::getValue($fetchOptions['labelOps'], $attribute, $msg) . 'ต้องไม่ว่างเปล่า';
                    $inputId = Html::getInputId($model, $attribute);
                    $validate[$inputId] = [$message];
                }
            }
        }
        return $validate;
    }

    public function actionTest($id)
    {
        $model = \frontend\modules\app\models\TblProductCategory::findOne(['product_category_id' => $id]);
        return $this->render('_test_form', [
            'model' => $model,
        ]);
    }

}
