<?php

namespace common\modules\app\controllers;

use adminlte\helpers\Html;
use common\components\QueryBuilder;
use common\modules\app\models\TblQuotation;
use common\modules\app\models\TblQuotationDetail;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use Yii;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblProductCategory;
use common\modules\app\traits\ModelTrait;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\mpdf\Pdf;

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
        //หมวดหมู่
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
                    'validate' => $validate
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
                'validates' => $fetchOptions['validation']
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
                    'footer' => ''
                ];
            } elseif ($model->load($request->post())) {
                $modelDetail->setAttributes($request->post('TblQuotationDetail'));
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
                            'validate' => ArrayHelper::merge(ActiveForm::validate($model), ActiveForm::validate($modelDetail))
                        ];
                    }
                } else {
                    return [
                        'success' => false,
                        'message' => 'error',
                        'validate' => ArrayHelper::merge(ActiveForm::validate($model), ActiveForm::validate($modelDetail))
                    ];
                }
            }
        }
    }

    public function actionQuo($q)
    {
        $model = $this->findModelQuotation($q);
        $modelItems = TblQuotationDetail::find()->where(['quotation_id' => $q])->all();
        $items = [];
        foreach ($modelItems as $item) {
            $modelProduct = $this->findModelProduct($item['product_id']);
            $option = $modelProduct->options;
            $details = Html::tag('strong', $modelProduct['product_name']) . "\n";
            //ขนาด
            if (!empty($item['paper_size_id'])) {
                if ($item['paper_size_id'] === 'custom') {
                    $modelUnit = $this->findModelUnit($item['paper_size_unit']);
                    $details .= 'ขนาด : ' . '&nbsp;' .
                        $item['paper_size_width'] . 'x' . $item['paper_size_height'] . '&nbsp' .
                        $modelUnit['unit_name'] . "\n";
                } else {
                    $modelPaperSize = $this->findModelPaperSize($item['paper_size_id']);
                    $details .= 'ขนาด : ' . '&nbsp;' . $modelPaperSize['paper_size_name'] . "\n";
                }
            }
            //จำนวน
            if (!empty($item['page_qty'])) {
                $details .= 'จำนวน : ' . '&nbsp;' . $item['page_qty'] . "\n";
            }
            //ด้านหน้าพิมพ์
            if (!empty($item['before_print'])) {
                $modelBeforePrint = $this->findModelColorPrinting($item['before_print']);
                $details .= 'ด้านหน้าพิมพ์ : ' . '&nbsp;' . $modelBeforePrint['color_printing_name'] . "\n";
            }
            //ด้านหลังพิมพ์
            if (!empty($item['after_print'])) {
                $modelBeforePrint = $this->findModelColorPrinting($item['after_print']);
                $details .= 'ด้านหลังพิมพ์ : ' . '&nbsp;' . $modelBeforePrint['color_printing_name'] . "\n";
            }
            //กระดาษ
            if (!empty($item['paper_id'])) {
                $modelPaper = $this->findModelPaper($item['paper_id']);
                $details .= 'กระดาษ : ' . '&nbsp;(' . $modelPaper->paperType->paper_type_name . ') ' . $modelPaper['paper_name'] . "\n";
            }
            //เคลือบ
            if (!empty($item['coating_id'])) {
                if ($item['coating_id'] === 'N') {
                    $details .= 'เคลือบ : ' . '&nbsp;' . 'ไม่เคลือบ' . "\n";
                } else {
                    $modelCoating = $this->findModelCoating($item['coating_id']);
                    if ($item['coating_option'] === 'one_page') {
                        $details .= 'เคลือบ : ' . '&nbsp;' . $modelCoating['coating_name'] . ' (ด้านเดียว)' . "\n";
                    } elseif ($item['coating_option'] === 'two_page') {
                        $details .= 'เคลือบ : ' . '&nbsp;' . $modelCoating['coating_name'] . ' (สองด้าน)' . "\n";
                    } else {
                        $details .= 'เคลือบ : ' . '&nbsp;' . $modelCoating['coating_name'] . "\n";
                    }
                }
            }
            //ไดคัท
            if (!empty($item['diecut_id'])) {
                if ($item['diecut_id'] === 'N') {
                    $details .= 'ไดคัท : ' . '&nbsp;' . 'ไม่ไดคัท' . "\n";
                } elseif ($item['diecut_id'] === 'default') {
                    $details .= 'ไดคัท : ' . '&nbsp;' . 'ตามรูปแบบ' . "\n";
                } else {
                    $modelDiecut = $this->findModelDiecut($item['diecut_id']);
                    $details .= 'ไดคัท : ' . '&nbsp;(' . $modelDiecut->diecutGroup->diecut_group_name . ') ' . $modelDiecut['diecut_name'] . "\n";
                }
            }
            //วิธีพับ
            if (!empty($item['fold_id'])) {
                if ($item['fold_id'] === 'N') {
                    $details .= 'วิธีพับ : ' . '&nbsp;' . 'ไม่พับ' . "\n";
                } else {
                    $modelFold = $this->findModelFold($item['fold_id']);
                    $details .= 'วิธีพับ : ' . '&nbsp;' . $modelFold['fold_name'] . "\n";
                }
            }
            //ฟอยล์
            if (!empty($item['foil_color_id'])) {
                $modelFoil = $this->findModelFoilColor($item['foil_color_id']);
                $modelFoilUnit = $this->findModelUnit($item['foil_size_unit']);
                $details .= 'ฟอยล์ ขนาด: ' . '&nbsp;' . $item['foil_size_width'] . 'x' . $item['foil_size_height'] . $modelFoilUnit['unit_name'] . '&nbsp;' . $modelFoil['foil_color_name'] . "\n";
            }
            //ปั๊มนูน
            if (!empty($item['emboss_size_width']) || !empty($item['emboss_size_height']) || !empty($item['emboss_size_unit'])) {
                $modelEmBossUnit = $this->findModelUnit($item['emboss_size_unit']);
                $details .= 'ปั๊มนูน : ' . '&nbsp;' . $item['emboss_size_width'] . 'x' . $item['emboss_size_height'] . $modelEmBossUnit['unit_name'] . "\n";
            }
            //แนวตัง/แนวนอน
            if (!empty($item['land_orient'])) {
                $details .= 'แนวตั้ง/แนวนอน : ' . '&nbsp;' . ($item['land_orient'] === '1' ? 'แนวตั้ง' : 'แนวนอน') . "\n";
            }
            //เข้าเล่ม
            if (!empty($item['book_binding_id'])) {
                if ($item['book_binding_id'] === 'N') {
                    $details .= 'เข้าเล่ม : ' . '&nbsp;' . 'ไม่เข้าเล่ม' . "\n";
                } else {
                    $modelBookBinding = $this->findModelBookBinding($item['book_binding_id']);
                    $details .= 'เข้าเล่ม : ' . '&nbsp;' . $modelBookBinding['book_binding_name'] . "\n";
                }
            }
            $items[] = [
                'product_id' => $item['product_id'],
                'product_name' => $modelProduct['product_name'],
                'details' => $details
            ];
        }
        return $this->renderAjax('invoice', [
            'model' => $model,
            'items' => $items
        ]);
    }

    protected function fetchOptions($model, $option)
    {
        $attributes = $model->getAttributes();
        $validation = [];
        $requiredOps = [];
        $valueOps = [];
        $labelOps = [];
        foreach ($option as $key => $ops) {
            $requiredOps[$key] = (int)$ops['required'];
            $valueOps[$key] = (int)$ops['value'];
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
                    }')
                ];
            }
        }
        return [
            'validation' => $validation,
            'requiredOps' => $requiredOps,
            'labelOps' => $labelOps,
            'valueOps' => $valueOps,
            'attributes' => $attributes
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

}
