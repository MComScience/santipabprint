<?php

namespace common\modules\app\controllers;

use adminlte\helpers\Html;
use common\components\InPutOptions;
use common\components\QueryBuilder;
use common\modules\app\models\TblPaperDetail;
use common\modules\app\models\TblPerforate;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblProductCategory;
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

    public function beforeAction($action)
    {
        if (in_array($action->id, ['download'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index', []);
        /* $catagorys = TblProductCategory::find()->all();
        $itemCatagorys = [];
        foreach ($catagorys as $key => $catagory) {
        $itemCatagorys[] = [
        'product_category_id' => $catagory['product_category_id'],
        'product_category_name' => $catagory['product_category_name'],
        'image_url' => Url::base(true) . $catagory->getImageUrl(),
        ];
        }
        return $this->render('index', [
        'catagorys' => $itemCatagorys
        ]); */
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
        if ($catagory) {
            $products = TblProduct::find()->where(['product_category_id' => $id])->orderBy('package_type_id ASC')->all();
            foreach ($products as $key => $product) {
                $itemProducts[] = [
                    'product_id' => $product['product_id'],
                    'product_name' => $product['product_name'],
                    'image_url' => Url::base(true) . $product->getImageUrl(),
                ];
            }
        }
        return $this->render('category', [
            'products' => $itemProducts,
            'catagory' => $catagory,
        ]);
    }

    public function actionQuotation($p, $slug = null)
    {
        $modelProduct = $this->findModelProduct($p);
        return $this->render('quotation-vue', [
            'modelProduct' => $modelProduct,
        ]);
        /* $request = Yii::$app->request;
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
    return $this->render('quotation-vue', [
    'option' => $option,
    'modelProduct' => $modelProduct,
    'modelQuotation' => $modelQuotation,
    'model' => $model,
    'queryBuilder' => $queryBuilder,
    'update' => $update,
    'validates' => $fetchOptions['validation'],
    ]);
    } */
    }

    public function actionDownload($p)
    {
        $request = Yii::$app->request;
        $model = new TblQuotation();
        $modelDetail = new TblQuotationDetail();
        $modelDetail->product_id = $p;
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        if ($request->isGet) {
            return [
                'title' => Icon::show('download') . 'ดาวน์โหลดใบเสนอราคา',
                'content' => $this->renderAjax('_form_download', [
                    'model' => $model,
                    'modelDetail' => $modelDetail,
                ]),
                'footer' => '',
            ];
        } elseif ($model->load($request->post(), '')) {
            $modelDetail->setAttributes($request->post());
            $modelDetail->final_price = str_replace(',', '', $request->post('final_price'));
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
                        'url' => Url::to(['quo', 'q' => $model['quotation_id']]),
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

    private function convertNumber($number)
    {
        if (empty($number)) {
            return '';
        }

        return (int) preg_replace("/.*\./", "", $number) > 0 ? number_format($number, 1) : number_format($number, 0);
    }

    public function actionQuo($q)
    {
        $modelQuotation = $this->findModelQuotation($q);
        $modelQuotationDetail = TblQuotationDetail::findOne(['quotation_id' => $q]);
        $modelProduct = $this->findModelProduct($modelQuotationDetail['product_id']);
        $skipAttributes = InPutOptions::skipAttributes();
        $attributes = array_keys($modelQuotationDetail->getAttributes());
        $productOptions = unserialize($modelProduct['product_options']);
        $skipAttributes = ArrayHelper::merge($skipAttributes, [
            'perforate_option_id',
        ]);

        $result = $this->getProductDetail($productOptions, $skipAttributes, $modelProduct, $modelQuotationDetail);

        return $this->renderAjax('invoice1', [
            'model' => $modelQuotation,
            'modelDetail' => $modelQuotationDetail,
            'details' => $result['details'],
        ]);
    }

    private function getProductDetail($productOptions, $skipAttributes, $modelProduct, $model)
    {
        $inputOptions = [];
        $x = 'x';
        $spacebar = ' ';
        $newline = "\n";
        $details = '';

        // flex
        $baseUrl = 'https://santipab.info';
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
                // ปั๊มฟอยล์
                if ($attribute === 'emboss_status') {
                    $embossStatusOptions = InPutOptions::getOption('emboss_status');
                    $emboss_status = InPutOptions::getAttributeValue($model['emboss_status'], $embossStatusOptions);
                    // ปั๊ม
                    if ($model['foil_status'] !== 'N') {
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

    private function getFlexMessage($q)
    {
        $baseUrl = 'https://santipab.info';
        $model = $this->findModelQuotation($q);
        $item = TblQuotationDetail::find()->where(['quotation_id' => $q])->one();
        $items = [];
        $summary = 0;
        $nbsp = '&nbsp';
        $nbsp2 = ': &nbsp;';
        $x = 'x';
        $newline = "\n";
        // foreach ($modelItems as $item) {
        $modelProduct = $this->findModelProduct($item['product_id']);
        $modelProductCategory = $this->findModelProductCategory($modelProduct['product_category_id']);
        $option = unserialize($modelProduct['product_options']); //$modelProduct->options;
        $modelProductOption = $this->findModelProductOption($item['product_id']);
        $queryBuilder = new QueryBuilder([
            'modelOption' => $modelProductOption,
            'product' => $modelProduct,
        ]);
        $details = Html::tag('strong', $modelProduct['product_name']) . $newline;

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

        //ขนาด
        if (!empty($item['paper_size_id'])) {
            if ($item['paper_size_id'] === 'custom') {
                $modelUnit = $this->findModelUnit($item['paper_size_unit']);
                $paper_size_width = $this->convertNumber($item['paper_size_width']);
                $paper_size_lenght = $this->convertNumber($item['paper_size_lenght']);
                $paper_size_height = $this->convertNumber($item['paper_size_height']);
                if (empty($paper_size_height)) {
                    $details .= $queryBuilder->getInputLabel($option, 'paper_size_id', $item) . $nbsp2 .
                        $paper_size_width . $x . $paper_size_lenght . $nbsp .
                        $modelUnit['unit_name'] . $newline;
                    //
                    $contents[] = ArrayHelper::merge($box, [
                        'contents' => [
                            ArrayHelper::merge($contentLeft, [
                                "text" => "ขนาด",
                            ]),
                            ArrayHelper::merge($contentRight, [
                                "text" => $paper_size_width . $x . $paper_size_lenght . ' ' . $modelUnit['unit_name'],
                            ]),
                        ],
                    ]);
                } else {
                    $details .= $queryBuilder->getInputLabel($option, 'paper_size_id', $item) . $nbsp2 .
                        $paper_size_width . $x . $paper_size_lenght . $x . $paper_size_height . $nbsp .
                        $modelUnit['unit_name'] . $newline;
                    //
                    $contents[] = ArrayHelper::merge($box, [
                        'contents' => [
                            ArrayHelper::merge($contentLeft, [
                                "text" => "ขนาด",
                            ]),
                            ArrayHelper::merge($contentRight, [
                                "text" => $paper_size_width . $x . $paper_size_lenght . $x . $paper_size_height . ' ' . $modelUnit['unit_name'],
                            ]),
                        ],
                    ]);
                }
            } else {
                $modelPaperSize = $this->findModelPaperSize($item['paper_size_id']);
                $modelUnit = $this->findModelUnit($modelPaperSize['paper_unit_id']);
                $details .= $queryBuilder->getInputLabel($option, 'paper_size_id', $item) . $nbsp2 . $modelPaperSize['paper_size_name'] . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ขนาด",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => $modelPaperSize['paper_size_name'],
                        ]),
                    ],
                ]);
            }
        }
        //จำนวน
        if (!empty($item['page_qty'])) {
            $details .= $queryBuilder->getInputLabel($option, 'page_qty', $item) . $nbsp2 . $item['page_qty'] . $newline;
            //
            $contents[] = ArrayHelper::merge($box, [
                'contents' => [
                    ArrayHelper::merge($contentLeft, [
                        "text" => "จำนวนหน้า",
                    ]),
                    ArrayHelper::merge($contentRight, [
                        "text" => $item['page_qty'],
                    ]),
                ],
            ]);
        }
        //กระดาษ
        if (!empty($item['paper_id'])) {
            $modelPaper = $this->findModelPaper($item['paper_id']);
            $paperDetail = TblPaperDetail::findOne($item['paper_detail_id']);
            $size = '&nbsp;(ขนาด ' . $this->convertNumber($paperDetail['paper_width']) . 'x' . $this->convertNumber($paperDetail['paper_length']) . ')';
            $details .= $queryBuilder->getInputLabel($option, 'paper_id', $item) . ': &nbsp;(' . $modelPaper->paperType->paper_type_name . ') ' . $modelPaper['paper_name'] . $size . $newline;
            //
            $contents[] = ArrayHelper::merge($box, [
                'contents' => [
                    ArrayHelper::merge($contentLeft, [
                        "text" => "กระดาษ",
                    ]),
                    ArrayHelper::merge($contentRight, [
                        "text" => $modelPaper['paper_name'],
                    ]),
                ],
            ]);
        }
        // จำนวนแผ่นต่อชุด
        if (!empty($item['bill_detail_qty'])) {
            $billPrice = $this->findModelBillPrice($item['bill_detail_qty']);
            $details .= 'จำนวนแผ่นต่อชุด:' . $nbsp2 . $billPrice['bill_floor'] . $newline;
            //
            $contents[] = ArrayHelper::merge($box, [
                'contents' => [
                    ArrayHelper::merge($contentLeft, [
                        "text" => "จำนวนแผ่นต่อชุด",
                    ]),
                    ArrayHelper::merge($contentRight, [
                        "text" => $billPrice['bill_floor'],
                    ]),
                ],
            ]);
        }
        //พิมพ์สองหน้า
        if (!empty($item['print_option'])) {
            $print_text = $item['print_option'] == 'one_page' ? 'หน้าเดียว' : 'สองหน้า';
            $modelBeforePrint = $this->findModelColorPrinting($item['print_color']);
            $details .= $print_text . $nbsp2 . $modelBeforePrint['color_printing_name'] . $newline;
            //
            $contents[] = ArrayHelper::merge($box, [
                'contents' => [
                    ArrayHelper::merge($contentLeft, [
                        "text" => "พิมพ์",
                    ]),
                    ArrayHelper::merge($contentRight, [
                        "text" => $print_text . ' ' . $modelBeforePrint['color_printing_name'],
                    ]),
                ],
            ]);
        }
        //พิมพ์หน้าเดียว
        // if (!empty($item['after_print'])) {
        //     $modelBeforePrint = $this->findModelColorPrinting($item['after_print']);
        //     $details .= $queryBuilder->getInputLabel($option, 'after_print', $item) . $nbsp2 . $modelBeforePrint['color_printing_name'] . $newline;
        // }

        //เคลือบ
        if (!empty($item['coating_id']) && $queryBuilder->isShowInput($option, 'coating_id')) {
            if ($item['coating_id'] === 'N') {
                $details .= 'เคลือบ : ' . $nbsp . 'ไม่เคลือบ' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "เคลือบ",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่เคลือบ",
                        ]),
                    ],
                ]);
            } else {
                $modelCoating = $this->findModelCoating($item['coating_id']);
                if ($item['coating_option'] === 'one_page') {
                    $details .= $queryBuilder->getInputLabel($option, 'coating_id', $item) . $nbsp2 . $modelCoating['coating_name'] . ' (ด้านเดียว)' . $newline;
                    //
                    $contents[] = ArrayHelper::merge($box, [
                        'contents' => [
                            ArrayHelper::merge($contentLeft, [
                                "text" => "เคลือบ",
                            ]),
                            ArrayHelper::merge($contentRight, [
                                "text" => $modelCoating['coating_name'] . ' (ด้านเดียว)',
                            ]),
                        ],
                    ]);
                } elseif ($item['coating_option'] === 'two_page') {
                    $details .= $queryBuilder->getInputLabel($option, 'coating_id', $item) . $nbsp2 . $modelCoating['coating_name'] . ' (สองด้าน)' . $newline;
                    //
                    $contents[] = ArrayHelper::merge($box, [
                        'contents' => [
                            ArrayHelper::merge($contentLeft, [
                                "text" => "เคลือบ",
                            ]),
                            ArrayHelper::merge($contentRight, [
                                "text" => $modelCoating['coating_name'] . ' (สองด้าน)',
                            ]),
                        ],
                    ]);
                } else {
                    $details .= $queryBuilder->getInputLabel($option, 'coating_id', $item) . $nbsp2 . $modelCoating['coating_name'] . $newline;
                    //
                    $contents[] = ArrayHelper::merge($box, [
                        'contents' => [
                            ArrayHelper::merge($contentLeft, [
                                "text" => "เคลือบ",
                            ]),
                            ArrayHelper::merge($contentRight, [
                                "text" => $modelCoating['coating_name'],
                            ]),
                        ],
                    ]);
                }
            }
        }
        //ไดคัท
        if ($queryBuilder->isShowInput($option, 'diecut')) {
            if ($item['diecut'] === 'N') {
                $details .= 'ไดคัท: ' . $nbsp2 . 'ไม่ไดคัท' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ไดคัท",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่ไดคัท",
                        ]),
                    ],
                ]);
            } elseif ($item['diecut'] === 'Default') {
                $details .= 'ไดคัท: ' . $nbsp2 . 'ตามรูปแบบ' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ไดคัท",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ตามรูปแบบ",
                        ]),
                    ],
                ]);
            } else {
                $modelDiecut = $this->findModelDiecut($item['diecut_id']);
                $details .= $queryBuilder->getInputLabel($option, 'diecut_id', $item) . ': &nbsp;(' . $modelDiecut->diecutGroup->diecut_group_name . ') ' . $modelDiecut['diecut_name'] . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ไดคัท",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => $modelDiecut['diecut_name'],
                        ]),
                    ],
                ]);
            }
        }
        // ตัด
        if ($queryBuilder->isShowInput($option, 'perforate')) {
            if ($item['perforate'] == 0) {
                $details .= 'ตัดเป็นตัว/เจาะ: ตัดเป็นตัวอย่างเดียว' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ตัด/เจาะ",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ตัดเป็นตัวอย่างเดียว",
                        ]),
                    ],
                ]);
            }
            if ($item['perforate'] == 1) {
                $perforate = TblPerforate::findOne($item['perforate']);
                $details .= 'ตัดเป็นตัว/เจาะ: ตัดเป็นตัว + เจาะรูกลม' . $nbsp . $perforate['perforate_name'] . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ตัด/เจาะ",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ตัดเป็นตัว + เจาะรูกลม" . " " . $perforate['perforate_name'],
                        ]),
                    ],
                ]);
            }
        }

        //วิธีพับ
        if (!empty($item['fold_id'])) {
            if ($item['fold_id'] === 'N') {
                $details .= $queryBuilder->getInputLabel($option, 'fold_id', $item) . $nbsp2 . 'ไม่พับ' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "วิธีพับ",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่พับ",
                        ]),
                    ],
                ]);
            } else {
                $modelFold = $this->findModelFold($item['fold_id']);
                $details .= $queryBuilder->getInputLabel($option, 'fold_id', $item) . $nbsp2 . $modelFold['fold_name'] . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "วิธีพับ",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => $modelFold['fold_name'],
                        ]),
                    ],
                ]);
            }
        }
        //ฟอยล์
        if (!empty($item['foil_status'])) {
            if ($item['foil_status'] == 'N') {
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ปั๊มฟอยล์",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => 'ไม่ปั๊ม',
                        ]),
                    ],
                ]);
                $details .= 'ปั๊มฟอยล์: ไม่ปั๊ม' . $newline;
            } else {
                $foil_size_width = $this->convertNumber($item['foil_size_width']);
                $foil_size_height = $this->convertNumber($item['foil_size_height']);

                $modelFoil = $this->findModelFoilColor($item['foil_color_id']);
                $modelFoilUnit = $this->findModelUnit($item['foil_size_unit']);

                $foil_print = '';
                if ($item['foil_print'] == 'two_page') {
                    $foil_print = 'ทั้งหน้า/หลัง';
                }
                if ($item['foil_print'] == 'one_page') {
                    $foil_print = 'หน้าเดียว';
                }

                $details .= 'ปั๊มฟอยล์ ขนาด: ' . $nbsp . $foil_size_width . $x . $foil_size_height . $modelFoilUnit['unit_name'] . $nbsp . $modelFoil['foil_color_name'] . $nbsp . $foil_print . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ปั๊มฟอยล์",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => $foil_size_width . $x . $foil_size_height . $modelFoilUnit['unit_name'] . ' ' . $modelFoil['foil_color_name'] . ' ' . $foil_print,
                        ]),
                    ],
                ]);
            }
        }
        //ปั๊มนูน
        if (!empty($item['emboss_status'])) {
            if ($item['emboss_status'] == 'N') {
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ปั๊มนูน",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => 'ไม่ปั๊ม',
                        ]),
                    ],
                ]);
                $details .= 'ปั๊มนูน: ไม่ปั๊ม' . $newline;
            } else {
                $emboss_size_width = $this->convertNumber($item['emboss_size_width']);
                $emboss_size_height = $this->convertNumber($item['emboss_size_height']);

                $modelEmBossUnit = $this->findModelUnit($item['emboss_size_unit']);

                $emboss_print = '';
                if ($item['emboss_print'] == 'two_page') {
                    $emboss_print = 'ทั้งหน้า/หลัง';
                }
                if ($item['emboss_print'] == 'one_page') {
                    $emboss_print = 'หน้าเดียว';
                }

                $details .= 'ปั๊มนูน ขนาด: ' . $nbsp . $emboss_size_width . $x . $emboss_size_height . $modelEmBossUnit['unit_name'] . $nbsp . $emboss_print . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ปั๊มนูน",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => $emboss_size_width . $x . $emboss_size_height . $modelEmBossUnit['unit_name'] . ' ' . $emboss_print,
                        ]),
                    ],
                ]);
            }
        }
        //แนวตัง/แนวนอน
        if (!empty($item['land_orient'])) {
            $details .= 'แนวตั้ง/แนวนอน : ' . $nbsp . ($item['land_orient'] === '1' ? 'แนวตั้ง' : 'แนวนอน') . $newline;
            //
            $contents[] = ArrayHelper::merge($box, [
                'contents' => [
                    ArrayHelper::merge($contentLeft, [
                        "text" => "แนวตั้ง/แนวนอน",
                    ]),
                    ArrayHelper::merge($contentRight, [
                        "text" => ($item['land_orient'] === '1' ? 'แนวตั้ง' : 'แนวนอน'),
                    ]),
                ],
            ]);
        }
        //เข้าเล่ม
        if (!empty($item['book_binding_id'])) {
            if ($item['book_binding_id'] === 'N') {
                $details .= 'เข้าเล่ม : ' . $nbsp . 'ไม่เข้าเล่ม' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "เข้าเล่ม",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่เข้าเล่ม",
                        ]),
                    ],
                ]);
            } else {
                $modelBookBinding = $this->findModelBookBinding($item['book_binding_id']);
                $details .= 'เข้าเล่ม : ' . $nbsp . $modelBookBinding['book_binding_name'] . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "เข้าเล่ม",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => $modelBookBinding['book_binding_name'],
                        ]),
                    ],
                ]);
            }
        }

        if (!empty($item['glue'])) {
            if ($item['glue'] == 1) {
                $details .= 'ปะกาว : มีปะกาว' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ปะกาว",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ปะ",
                        ]),
                    ],
                ]);
            } else {
                //
                $details .= 'ปะกาว : ไม่มีปะกาว' . $newline;
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ปะกาว",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่ปะ",
                        ]),
                    ],
                ]);
            }
        }

        if (!empty($item['rope'])) {
            if ($item['rope'] == 1) {
                $details .= 'ร้อยเชือกหูถุง : มีเชือกร้อยหู' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ร้อยเชือกหูถุง",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ร้อยเชือกหูถุง",
                        ]),
                    ],
                ]);
            } else {
                $details .= 'ร้อยเชือกหูถุง : ไม่มีเชือกร้อยหู' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ร้อยเชือกหูถุง",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่ร้อยเชือกหูถุง",
                        ]),
                    ],
                ]);
            }
        }

        // ปรุฉีก
        if (!empty($item['perforated_ripped'])) {
            if ($item['perforated_ripped'] == 1) {
                $details .= 'ปรุฉีก : ปรุฉีก' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ปรุฉีก",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ปรุฉีก",
                        ]),
                    ],
                ]);
            } else {
                $details .= 'ปรุฉีก : ไม่ปรุฉีก' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ปรุฉีก",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่ปรุฉีก",
                        ]),
                    ],
                ]);
            }
        }

        // running number
        if (!empty($item['running_number'])) {
            if ($item['running_number'] == 1) {
                $details .= 'running number : มี running number' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "running number",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "มี running number",
                        ]),
                    ],
                ]);
            } else {
                $details .= 'running number : ไม่ running number' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "running number",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่ running number",
                        ]),
                    ],
                ]);
            }
        }

        // ติดหน้าต่าง
        if (!empty($item['window_box'])) {
            if ($item['window_box'] == 1) {
                $window_box_unit = '';

                if (!empty($item['window_box_unit'])) {
                    $modelUnit = $this->findModelUnit($item['window_box_unit']);
                    $window_box_unit = $modelUnit['unit_name'];
                }

                $details .= 'ติดหน้าต่าง : มีติดหน้าต่าง ขนาด' . $item['window_box_width'] . 'x' . $item['window_box_lenght'] . ' ' . $window_box_unit . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ติดหน้าต่าง",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "มีติดหน้าต่าง" . $item['window_box_width'] . 'x' . $item['window_box_lenght'] . ' ' . $window_box_unit,
                        ]),
                    ],
                ]);
            } else {
                $details .= 'ติดหน้าต่าง : ไม่ติดหน้าต่าง' . $newline;
                //
                $contents[] = ArrayHelper::merge($box, [
                    'contents' => [
                        ArrayHelper::merge($contentLeft, [
                            "text" => "ติดหน้าต่าง",
                        ]),
                        ArrayHelper::merge($contentRight, [
                            "text" => "ไม่ติดหน้าต่าง",
                        ]),
                    ],
                ]);
            }
        }

        //
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
                    "text" => Yii::$app->formatter->format($item['cust_quantity'], ['decimal', 0]) . " ชิ้น",
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
                    "text" => Yii::$app->formatter->format($item['final_price'], ['decimal', 2]) . " บ.",
                    "color" => "#ea7066",
                ]),
            ],
        ]);

        $items[] = [
            'product_id' => $item['product_id'],
            'data' => $item,
            'product_name' => $modelProduct['product_name'],
            'details' => str_replace('<span class="text-danger">*</span>', '', $details),
        ];
        $summary = $summary + $item['final_price'];

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
                            "text" => "#" . $q,
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
                        "uri" => $baseUrl . Url::to(['quo', 'q' => $q]),
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
            'model' => $model,
            'items' => $items,
            'summary' => $summary,
            'flex' => $flex,
        ];
    }

}
