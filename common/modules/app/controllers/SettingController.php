<?php

namespace common\modules\app\controllers;

use common\base\DynamicModel;
use common\components\GridBuilder;
use common\modules\app\models\Options;
use common\modules\app\models\search\TblBookBindingSearch;
use common\modules\app\models\search\TblCoatingSearch;
use common\modules\app\models\search\TblColorPrintingSearch;
use common\modules\app\models\search\TblFoilColorSearch;
use common\modules\app\models\search\TblFoldSearch;
use common\modules\app\models\search\TblProductCategorySearch;
use common\modules\app\models\search\TblProductSearch;
use common\modules\app\models\TblBookBinding;
use common\modules\app\models\TblCoating;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblDiecut;
use common\modules\app\models\TblDiecutGroup;
use common\modules\app\models\TblDiecutGroupSearch;
use common\modules\app\models\TblDiecutSearch;
use common\modules\app\models\TblFoilColor;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblProductOption;
use common\modules\app\models\TblQuotationDetail;
use common\modules\app\models\TblUnit;
use common\modules\app\models\TblUnitSearch;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use common\modules\app\models\TblPaperSize;
use common\modules\app\traits\ModelTrait;
use common\modules\app\models\search\TblPaperSizeSearch;
use common\modules\app\models\search\TblPaperTypeSearch;
use common\modules\app\models\search\TblPaperSearch;
use common\modules\app\models\TblPaperType;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Response;

class SettingController extends \yii\web\Controller
{
    use ModelTrait;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@', 'admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-paper-size' => ['POST'],
                    'delete-paper-type' => ['POST'],
                    'delete-paper' => ['POST'],
                    'delete-fold' => ['POST'],
                    'delete-foil-color' => ['POST'],
                    'delete-coating' => ['POST'],
                    'delete-diecut' => ['POST'],
                    'delete-diecut-group' => ['POST'],
                    'delete-unit' => ['POST'],
                    'delete-book-binding' => ['POST'],
                    'delete-printing' => ['POST'],
                    'delete-product-category' => ['POST'],
                    'delete-product' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload-icon' => [
                'class' => UploadAction::className(),
                'deleteRoute' => 'delete-icon',
                'on afterSave' => function ($event) {
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(112, 112);
                    $file->put($img->encode());
                },
            ],
            'delete-icon' => [
                'class' => DeleteAction::className(),
            ],
            'upload-file' => [
                'class' => 'trntv\filekit\actions\UploadAction',
                'deleteRoute' => 'delete-file',
                'allowChangeFilestorage' => false,
                'fileStorage' => 'fileStorage', // Yii::$app->get('fileStorage')
                'fileStorageParam' => 'fileStorage', // ?fileStorage=someStorageComponent
            ],
            'delete-file' => [
                'class' => DeleteAction::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /* ###### ขนาดกระดาษ ##### */
    public function actionPaperSize()
    {
        $searchModel = new TblPaperSizeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_paper_size', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### ประเภทกระดาษ ##### */
    public function actionPaperType()
    {
        $searchModel = new TblPaperTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_paper_type', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### กระดาษ ##### */
    public function actionPaper()
    {
        $searchModel = new TblPaperSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_paper', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### วิธีพับ ##### */
    public function actionFold()
    {
        $searchModel = new TblFoldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_fold', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### สีฟอยล์ ##### */
    public function actionFoilColor()
    {
        $searchModel = new TblFoilColorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_foil_color', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### วิธีเคลือบ ##### */
    public function actionCoating()
    {
        $searchModel = new TblCoatingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_coating', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### วิธีเคลือบ ##### */
    public function actionDiecut()
    {
        $searchModel = new TblDiecutGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_diecut', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### วิธีเคลือบ ##### */
    public function actionUnit()
    {
        $searchModel = new TblUnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_unit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### วิธีเข้าเล่ม ##### */
    public function actionBookBinding()
    {
        $searchModel = new TblBookBindingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_book_binding', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### หน้าพิมพ์/หลังพิมพ์ ##### */
    public function actionPrinting()
    {
        $searchModel = new TblColorPrintingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_printing', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### หมวดหมู่สินค้า ##### */
    public function actionProductCategory()
    {
        $searchModel = new TblProductCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_product_category', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### สินค้า ##### */
    public function actionProduct()
    {
        $searchModel = new TblProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'product_category_id' => SORT_ASC,
        ];

        return $this->render('_product', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ###### ขนาดกระดาษ ##### */
    public function actionCreateUnit()
    {
        $request = Yii::$app->request;
        $model = new TblUnit();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกหน่วยกระดาษ',
                    'content' => $this->renderAjax('_form_unit', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateUnit($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelUnit($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขหน่วยกระดาษ',
                    'content' => $this->renderAjax('_form_unit', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### ขนาดกระดาษ ##### */
    public function actionCreatePaperSize()
    {
        $request = Yii::$app->request;
        $model = new TblPaperSize();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกขนาดกระดาษ',
                    'content' => $this->renderAjax('_form_paper_size', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### ขนาดกระดาษ ##### */
    public function actionUpdatePaperSize($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelPaperSize($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขขนาดกระดาษ',
                    'content' => $this->renderAjax('_form_paper_size', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### ประเภทกระดาษ ##### */
    public function actionCreatePaperType()
    {
        $request = Yii::$app->request;
        $model = new TblPaperType();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกประเภทกระดาษ',
                    'content' => $this->renderAjax('_form_paper_type', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdatePaperType($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelPaperType($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขประเภทกระดาษ',
                    'content' => $this->renderAjax('_form_paper_type', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### กระดาษ ##### */
    public function actionCreatePaper()
    {
        $request = Yii::$app->request;
        $model = new TblPaper();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกกระดาษ',
                    'content' => $this->renderAjax('_form_paper', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdatePaper($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelPaper($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขกระดาษ',
                    'content' => $this->renderAjax('_form_paper', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### วิธีพับ ##### */
    public function actionCreateFold()
    {
        $request = Yii::$app->request;
        $model = new TblFold();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกวิธีพับ',
                    'content' => $this->renderAjax('_form_fold', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateFold($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelFold($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขวิธีพับ',
                    'content' => $this->renderAjax('_form_fold', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### สีฟอยล์ ##### */
    public function actionCreateFoilColor()
    {
        $request = Yii::$app->request;
        $model = new TblFoilColor();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกสีฟอยล์',
                    'content' => $this->renderAjax('_form_foil_color', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateFoilColor($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelFoilColor($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขสีฟอยล์',
                    'content' => $this->renderAjax('_form_foil_color', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### วิธีเคลือบ ##### */
    public function actionCreateCoating()
    {
        $request = Yii::$app->request;
        $model = new TblCoating();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกวิธีเคลือบ',
                    'content' => $this->renderAjax('_form_coating', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateCoating($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelCoating($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขวิธีเคลือบ',
                    'content' => $this->renderAjax('_form_coating', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### ไดคัท ##### */
    public function actionCreateDiecut()
    {
        $request = Yii::$app->request;
        $model = new TblDiecutGroup();
        $modelsDiecuts = [new TblDiecut()];

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกไดคัท',
                    'content' => $this->renderAjax('_form_diecut', [
                        'model' => $model,
                        'modelsDiecuts' => (empty($modelsDiecuts)) ? [new TblDiecut()] : $modelsDiecuts
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $modelsDiecuts = DynamicModel::createMultiple(TblDiecut::classname(), $modelsDiecuts, 'diecut_id');
                DynamicModel::loadMultiple($modelsDiecuts, Yii::$app->request->post());

                // ajax validation
                /*if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                        ActiveForm::validateMultiple($modelsDiecuts),
                        ActiveForm::validate($model)
                    );
                }*/

                // validate all models
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsDiecuts) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsDiecuts as $modelsDiecut) {
                                $modelsDiecut->diecut_group_id = $model->diecut_group_id;
                                if (!($flag = $modelsDiecut->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            return [
                                'success' => true,
                                'message' => 'บันทึกสำเร็จ!',
                                'data' => $model
                            ];
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                    }
                } else {
                    return [
                        'success' => false,
                        'message' => $model->errors,
                        'data' => $model,
                        'validate' => ActiveForm::validateMultiple($modelsDiecuts)
                    ];
                }
            } else {
                return [
                    'title' => 'บันทึกไดคัท',
                    'content' => $this->renderAjax('_form_diecut', [
                        'model' => $model,
                        'modelsDiecuts' => (empty($modelsDiecuts)) ? [new TblDiecut()] : $modelsDiecuts
                    ]),
                    'footer' => ''
                ];
            }
        }
    }

    public function actionUpdateDiecut($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelDiecutGroup($id);
        $modelsDiecuts = $model->diecuts;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกไดคัท',
                    'content' => $this->renderAjax('_form_diecut', [
                        'model' => $model,
                        'modelsDiecuts' => (empty($modelsDiecuts)) ? [new TblDiecut()] : $modelsDiecuts
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $oldIDs = ArrayHelper::map($modelsDiecuts, 'diecut_id', 'diecut_id');
                $modelsDiecuts = DynamicModel::createMultiple(TblDiecut::classname(), $modelsDiecuts, 'diecut_id');
                DynamicModel::loadMultiple($modelsDiecuts, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsDiecuts, 'diecut_id', 'diecut_id')));

                // validate all models
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsDiecuts) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            if (!empty($deletedIDs)) {
                                TblDiecut::deleteAll(['diecut_id' => $deletedIDs]);
                            }
                            foreach ($modelsDiecuts as $modelsDiecut) {
                                $modelsDiecut->diecut_group_id = $model->diecut_group_id;
                                if (!($flag = $modelsDiecut->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            return [
                                'success' => true,
                                'message' => 'บันทึกสำเร็จ!',
                                'data' => $model
                            ];
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                    }
                } else {
                    return [
                        'success' => false,
                        'message' => $valid,
                        'data' => $model,
                        'validate' => ActiveForm::validateMultiple($modelsDiecuts)
                    ];
                }
            } else {
                return [
                    'title' => 'บันทึกไดคัท',
                    'content' => $this->renderAjax('_form_diecut', [
                        'model' => $model,
                        'modelsDiecuts' => (empty($modelsDiecuts)) ? [new TblDiecut()] : $modelsDiecuts
                    ]),
                    'footer' => ''
                ];
            }
        }
    }

    /* ###### วิธีเข้าเล่ม ##### */
    public function actionCreateBookBinding()
    {
        $request = Yii::$app->request;
        $model = new TblBookBinding();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกวิธีเข้าเล่ม',
                    'content' => $this->renderAjax('_form_book_binding', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateBookBinding($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelBookBinding($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขวิธีเข้าเล่ม',
                    'content' => $this->renderAjax('_form_book_binding', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### หน้าพิมพ์ / หลังพิมพ์ ##### */
    public function actionCreatePrinting()
    {
        $request = Yii::$app->request;
        $model = new TblColorPrinting();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกหน้าพิมพ์/หลังพิมพ์',
                    'content' => $this->renderAjax('_form_printing', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdatePrinting($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelColorPrinting($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขหน้าพิมพ์/หลังพิมพ์',
                    'content' => $this->renderAjax('_form_printing', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    /* ###### หมวดหมู่สินค้า ##### */
    public function actionCreateProductCategory()
    {
        $request = Yii::$app->request;
        $model = new TblProductCategory();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกหมวดหมู่สินค้า',
                    'content' => $this->renderAjax('_form_product_category', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateProductCategory($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelProductCategory($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขหมวดหมู่สินค้า',
                    'content' => $this->renderAjax('_form_product_category', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionCreateProduct()
    {
        $request = Yii::$app->request;
        $model = new TblProduct();
        $modelOption = new TblQuotationDetail();
        $gridBuilder = new GridBuilder();
        $modelProductOption = new TblProductOption();
        $attributes = $modelOption->getAttributes();
        $attrRemoves = ['quotation_detail_id', 'quotation_id', 'product_id'];
        foreach ($attrRemoves as $attr) {
            ArrayHelper::remove($attributes, $attr);
        }
        if ($model->load($request->post())) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $posted = $request->post();
            $options = $posted['Options'];
            $transaction = TblProduct::getDb()->beginTransaction();
            try {
                $model->product_options = !empty($options) ? Json::encode($options) : null;
                if ($model->save()) {
                    $modelProductOption->setAttributes([
                        'product_id' => $model->product_id,
                        'paper_size_option' => (isset($posted['paperSizeKeys']) && is_array($posted['paperSizeKeys'])) ? Json::encode($posted['paperSizeKeys']) : null,
                        'before_printing' => (isset($posted['beforePrintKeys']) && is_array($posted['beforePrintKeys']) && $options['before_print']['value'] === '1') ? Json::encode($posted['beforePrintKeys']) : null,
                        'after_printing' => (isset($posted['afterPrintKeys']) && is_array($posted['afterPrintKeys']) && $options['after_print']['value'] === '1') ? Json::encode($posted['afterPrintKeys']) : null,
                        'paper_option' => isset($posted['paperKeys']) && is_array($posted['paperKeys']) ? Json::encode($posted['paperKeys']) : null,
                        'coating_option' => (isset($posted['coatingKeys']) && is_array($posted['coatingKeys']) && $options['coating_id']['value'] === '1') ? Json::encode($posted['coatingKeys']) : null,
                        'diecut_option' => (isset($posted['dieCutKeys']) && is_array($posted['dieCutKeys']) && $options['diecut_id']['value'] === '1') ? Json::encode($posted['dieCutKeys']) : null,
                        'fold_option' => (isset($posted['foldKeys']) && is_array($posted['foldKeys']) && $options['fold_id']['value'] === '1') ? Json::encode($posted['foldKeys']) : null,
                        'foil_color_option' => (isset($posted['foilColorKeys']) && is_array($posted['foilColorKeys']) && $options['foil_color_id']['value'] === '1') ? Json::encode($posted['foilColorKeys']) : null,
                        'book_binding_option' => (isset($posted['bookBindingKeys']) && is_array($posted['bookBindingKeys']) && $options['book_binding_id']['value'] === '1') ? Json::encode($posted['bookBindingKeys']) : null,
                        'two_page_option' => '',
                        'one_page_option' => ''
                    ]);
                    if ($modelProductOption->save()) {
                        $transaction->commit();
                        return [
                            'success' => true,
                            'message' => 'บันทึกสำเร็จ',
                            'action' => 'create-product',
                            'data' => [
                                'url' => Url::to(['update-product', 'id' => $model['product_id']]),
                                'modelProductOption' => $modelProductOption,
                                'model' => $model
                            ]
                        ];
                    } else {
                        $transaction->rollBack();
                        return [
                            'success' => false,
                            'data' => $model,
                            'validate' => ArrayHelper::merge(
                                ActiveForm::validate($model),
                                ActiveForm::validate($modelProductOption)
                            )
                        ];
                    }
                } else {
                    $transaction->rollBack();
                    return [
                        'success' => false,
                        'data' => $model,
                        'validate' => ActiveForm::validate($model)
                    ];
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

        } else {
            return $this->render('_form_product', [
                'model' => $model,
                'modelOption' => $modelOption,
                'gridBuilder' => $gridBuilder,
                'attributes' => $attributes
            ]);
        }
    }

    public function actionUpdateProduct($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelProduct($id);
        $modelOption = new TblQuotationDetail();
        $gridBuilder = new GridBuilder();
        $modelProductOption = $this->findModelProductOption($id);
        $attributes = $modelOption->getAttributes();
        $attrRemoves = ['quotation_detail_id', 'quotation_id', 'product_id'];
        foreach ($attrRemoves as $attr) {
            ArrayHelper::remove($attributes, $attr);
        }
        if ($model->load($request->post())) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $posted = $request->post();
            $options = $posted['Options'];
            $transaction = TblProduct::getDb()->beginTransaction();
            try {
                $model->setAttributes($posted['TblProduct']);
                $model->product_options = !empty($options) ? Json::encode($options) : null;
                if ($model->save()) {
                    $modelProductOption->setAttributes([
                        'product_id' => $model->product_id,
                        'paper_size_option' => (isset($posted['paperSizeKeys']) && is_array($posted['paperSizeKeys'])) ? Json::encode($posted['paperSizeKeys']) : null,
                        'before_printing' => (isset($posted['beforePrintKeys']) && is_array($posted['beforePrintKeys']) && $options['before_print']['value'] === '1') ? Json::encode($posted['beforePrintKeys']) : null,
                        'after_printing' => (isset($posted['afterPrintKeys']) && is_array($posted['afterPrintKeys']) && $options['after_print']['value'] === '1') ? Json::encode($posted['afterPrintKeys']) : null,
                        'paper_option' => isset($posted['paperKeys']) && is_array($posted['paperKeys']) ? Json::encode($posted['paperKeys']) : null,
                        'coating_option' => (isset($posted['coatingKeys']) && is_array($posted['coatingKeys']) && $options['coating_id']['value'] === '1') ? Json::encode($posted['coatingKeys']) : null,
                        'diecut_option' => (isset($posted['dieCutKeys']) && is_array($posted['dieCutKeys']) && $options['diecut_id']['value'] === '1') ? Json::encode($posted['dieCutKeys']) : null,
                        'fold_option' => (isset($posted['foldKeys']) && is_array($posted['foldKeys']) && $options['fold_id']['value'] === '1') ? Json::encode($posted['foldKeys']) : null,
                        'foil_color_option' => (isset($posted['foilColorKeys']) && is_array($posted['foilColorKeys']) && $options['foil_color_id']['value'] === '1') ? Json::encode($posted['foilColorKeys']) : null,
                        'book_binding_option' => (isset($posted['bookBindingKeys']) && is_array($posted['bookBindingKeys']) && $options['book_binding_id']['value'] === '1') ? Json::encode($posted['bookBindingKeys']) : null,
                        'two_page_option' => '',
                        'one_page_option' => ''
                    ]);
                    if($modelProductOption->save()){
                        $transaction->commit();
                        return [
                            'success' => true,
                            'message' => 'บันทึกสำเร็จ',
                            'action' => 'update-product',
                            'data' => [
                                'url' => Url::to(['update-product', 'id' => $model['product_id']]),
                                'modelProductOption' => $modelProductOption,
                                'model' => $model
                            ]
                        ];
                    }else{
                        $transaction->rollBack();
                        return [
                            'success' => false,
                            'data' => $model,
                            'validate' => ArrayHelper::merge(
                                ActiveForm::validate($model),
                                ActiveForm::validate($modelProductOption)
                            )
                        ];
                    }
                } else {
                    $transaction->rollBack();
                    return [
                        'success' => false,
                        'data' => $model,
                        'validate' => ActiveForm::validate($model)
                    ];
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

        } else {
            return $this->render('_form_product', [
                'model' => $model,
                'modelOption' => $modelOption,
                'gridBuilder' => $gridBuilder,
                'attributes' => $attributes
            ]);
        }
    }

    /* ###### ลบขนาดกระดาษ ##### */
    public function actionDeletePaperSize($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelPaperSize($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบประเภทกระดาษ ##### */
    public function actionDeletePaperType($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelPaperType($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบกระดาษ ##### */
    public function actionDeletePaper($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelPaper($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบวิธีพับ ##### */
    public function actionDeleteFold($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelFold($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบสีฟอยล์ ##### */
    public function actionDeleteFoilColor($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelFoilColor($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบวิธีเคลือบ ##### */
    public function actionDeleteCoating($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelCoating($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ไดคัท ##### */
    public function actionDeleteDiecut($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelDiecut($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ไดคัท ##### */
    public function actionDeleteDiecutGroup($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelDiecutGroup($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบหน่วย ##### */
    public function actionDeleteUnit($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelUnit($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบวิธีเข้าเล่ม ##### */
    public function actionDeleteBookBinding($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelBookBinding($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบขนาดกระดาษ ##### */
    public function actionDeletePrinting($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelColorPrinting($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบหมวดหมู่สินค้า ##### */
    public function actionDeleteProductCategory($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelProductCategory($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /* ###### ลบขนาดกระดาษ ##### */
    public function actionDeleteProduct($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelProduct($id);
        $model->delete();
        TblProductOption::deleteAll(['product_id' => $id]);
        return [
            'success' => true,
        ];
    }

    public function actionDiecutDetail()
    {
        if (isset($_POST['expandRowKey'])) {
            $searchModel = new TblDiecutSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->where(['diecut_group_id' => $_POST['expandRowKey']]);
            return $this->renderPartial('_diecut-details', [
                'dataProvider' => $dataProvider
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public static function isEmpty($data)
    {
        return !isset($data) || empty($data) || ($data === null) || ($data === '');
    }
}
