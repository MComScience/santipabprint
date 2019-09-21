<?php

namespace common\modules\app\controllers;

use common\base\DynamicModel;
use common\components\GridBuilder;
use common\modules\app\models\search\TblBookBindingSearch;
use common\modules\app\models\search\TblCoatingSearch;
use common\modules\app\models\search\TblColorPrintingSearch;
use common\modules\app\models\search\TblFoilColorSearch;
use common\modules\app\models\search\TblFoldSearch;
use common\modules\app\models\search\TblPackageTypeSearch;
use common\modules\app\models\search\TblPaperSearch;
use common\modules\app\models\search\TblPaperSizeSearch;
use common\modules\app\models\search\TblPaperTypeSearch;
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
use common\modules\app\models\TblPackageType;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblPaperDetail;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblPaperType;
use common\modules\app\models\TblPerforate;
use common\modules\app\models\TblPerforateOption;
use common\modules\app\models\TblPerforateSearch;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblProductOption;
use common\modules\app\models\TblQuotationDetail;
use common\modules\app\models\TblUnit;
use common\modules\app\models\TblUnitSearch;
use common\modules\app\models\TblBillPrice;
use common\modules\app\models\TblBillPriceDetail;
use common\modules\app\models\TblBillPriceSearch;
use common\modules\app\traits\ModelTrait;
use Intervention\Image\ImageManagerStatic;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Response;
use yii\base\Model;

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
                    'delete-perforate' => ['POST'],
                    'delete-perforate-option' => ['POST'],
                    'delete-bill-price' => ['POST'],
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
//                'on afterSave' => function ($event) {
//                    $file = $event->file;
//                    // $img = ImageManagerStatic::make($file->read())->fit(112, 112);
//                    // $img = ImageManagerStatic::make($file->read())->fit(1024, 1024);
//                    $file->put($img->encode());
//                },
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
        $dataProvider->query->orderBy('paper_type_id asc,paper_gram asc');

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
        $dataProvider->query->orderBy('fold_id asc');

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

    /* ###### เจาะมุม ##### */

    public function actionPerforate()
    {
        $searchModel = new TblPerforateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_perforate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ######  ประเภทสินค้าบรรจุภัณฑ์ ##### */

    public function actionPackageType()
    {
        $searchModel = new TblPackageTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_package_type', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBillPrice()
    {
        $searchModel = new TblBillPriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_bill_price', [
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
                ];
            }
        }
    }

    /* ###### กระดาษ ##### */

    public function actionCreatePaper()
    {
        $request = Yii::$app->request;
        $model = new TblPaper();
        $modelsDetails = [new TblPaperDetail()];
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกกระดาษ',
                    'content' => $this->renderAjax('_form_paper', [
                        'model' => $model,
                        'modelsDetails' => (empty($modelsDetails)) ? [new TblPaperDetail()] : $modelsDetails,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post())) {
                $modelsDetails = DynamicModel::createMultiple(TblPaperDetail::classname(), $modelsDetails, 'paper_detail_id');
                DynamicModel::loadMultiple($modelsDetails, $request->post());

                // validate all models
                $valid = $model->validate();
                $valid = Model::validateMultiple($modelsDetails) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsDetails as $modelsDetail) {
                                $modelsDetail->paper_id = $model->paper_id;
                                if (!($flag = $modelsDetail->save(false))) {
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
                                'data' => $model,
                            ];
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                } else {
                    return [
                        'success' => false,
                        'message' => $model->errors,
                        'data' => $model,
                        'validate' => ActiveForm::validateMultiple($modelsDetails),
                    ];
                }
            } else {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกกระดาษ',
                    'content' => $this->renderAjax('_form_paper', [
                        'model' => $model,
                        'modelsDetails' => (empty($modelsDetails)) ? [new TblPaperDetail()] : $modelsDetails,
                    ]),
                    'footer' => '',
                ];
            }
        }
    }

    public function actionUpdatePaper($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelPaper($id);
        $modelsDetails = TblPaperDetail::find()->where(['paper_id' => $id])->all();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขกระดาษ',
                    'content' => $this->renderAjax('_form_paper', [
                        'model' => $model,
                        'modelsDetails' => (empty($modelsDetails)) ? [new TblPaperDetail()] : $modelsDetails,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post())) {
                $oldIDs = ArrayHelper::map($modelsDetails, 'paper_detail_id', 'paper_detail_id');
                $modelsDetails = DynamicModel::createMultiple(TblPaperDetail::classname(), $modelsDetails, 'paper_detail_id');
                DynamicModel::loadMultiple($modelsDetails, $request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsDetails, 'paper_detail_id', 'paper_detail_id')));

                // validate all models
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsDetails) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            if (!empty($deletedIDs)) {
                                TblPaperDetail::deleteAll(['diecut_id' => $deletedIDs]);
                            }
                            foreach ($modelsDetails as $modelsDetail) {
                                $modelsDetail->paper_id = $model->paper_id;
                                if (!($flag = $modelsDetail->save(false))) {
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
                                'data' => $model,
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
                        'validate' => ActiveForm::validateMultiple($modelsDetails),
                    ];
                }
            } else {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกกระดาษ',
                    'content' => $this->renderAjax('_form_paper', [
                        'model' => $model,
                        'modelsDetails' => (empty($modelsDetails)) ? [new TblPaperDetail()] : $modelsDetails,
                    ]),
                    'footer' => '',
                ];
            }
        }
    }

    public function actionPaperDetails()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = $this->findModelPaper($_POST['expandRowKey']);
            $query = TblPaperDetail::find()->where(['paper_id' => $_POST['expandRowKey']]);

            $provider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => false,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'paper_size' => SORT_DESC
                    ],
                ],
            ]);
            return $this->renderPartial('_paper-details', ['model' => $model, 'dataProvider' => $provider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                        'modelsDiecuts' => (empty($modelsDiecuts)) ? [new TblDiecut()] : $modelsDiecuts,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $modelsDiecuts = DynamicModel::createMultiple(TblDiecut::classname(), $modelsDiecuts, 'diecut_id');
                DynamicModel::loadMultiple($modelsDiecuts, Yii::$app->request->post());

                // ajax validation
                /* if (Yii::$app->request->isAjax) {
                  Yii::$app->response->format = Response::FORMAT_JSON;
                  return ArrayHelper::merge(
                  ActiveForm::validateMultiple($modelsDiecuts),
                  ActiveForm::validate($model)
                  );
                  } */

                // validate all models
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsDiecuts) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($model->save()) {
                            foreach ($modelsDiecuts as $modelsDiecut) {
                                $modelsDiecut->diecut_group_id = $model->diecut_group_id;
                                if (!$modelsDiecut->save()) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                            $transaction->commit();
                            return [
                                'success' => true,
                                'message' => 'บันทึกสำเร็จ!',
                                'data' => $model,
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
                        'validate' => ActiveForm::validateMultiple($modelsDiecuts),
                    ];
                }
            } else {
                return [
                    'title' => 'บันทึกไดคัท',
                    'content' => $this->renderAjax('_form_diecut', [
                        'model' => $model,
                        'modelsDiecuts' => (empty($modelsDiecuts)) ? [new TblDiecut()] : $modelsDiecuts,
                    ]),
                    'footer' => '',
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
                        'modelsDiecuts' => (empty($modelsDiecuts)) ? [new TblDiecut()] : $modelsDiecuts,
                    ]),
                    'footer' => '',
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
                                'data' => $model,
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
                        'validate' => ActiveForm::validateMultiple($modelsDiecuts),
                    ];
                }
            } else {
                return [
                    'title' => 'บันทึกไดคัท',
                    'content' => $this->renderAjax('_form_diecut', [
                        'model' => $model,
                        'modelsDiecuts' => (empty($modelsDiecuts)) ? [new TblDiecut()] : $modelsDiecuts,
                    ]),
                    'footer' => '',
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'title' => Icon::show('file-text-o') . 'บันทึก พิมพ์สองหน้า/พิมพ์หน้าเดียว',
                    'content' => $this->renderAjax('_form_printing', [
                        'model' => $model,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
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
                    'title' => Icon::show('file-text-o') . 'แก้ไข พิมพ์สองหน้า/พิมพ์หน้าเดียว',
                    'content' => $this->renderAjax('_form_printing', [
                        'model' => $model,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $model->errors,
                    'data' => $model,
                    'validate' => ActiveForm::validate($model),
                ];
            }
        }
    }

    /* ###### หมวดหมู่สินค้า ##### */

    public function actionCreateProductCategory()
    {
        $request = Yii::$app->request;
        $model = new TblProductCategory();
        $modelsPackageTypes = [new TblPackageType()];

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกหมวดหมู่สินค้า',
                    'content' => $this->renderAjax('_form_product_category', [
                        'model' => $model,
                        'modelsPackageTypes' => (empty($modelsPackageTypes)) ? [new TblPackageType()] : $modelsPackageTypes,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $modelsPackageTypes = DynamicModel::createMultiple(TblPackageType::classname(), $modelsPackageTypes, 'package_type_id');
                DynamicModel::loadMultiple($modelsPackageTypes, Yii::$app->request->post());
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsPackageTypes) && $valid;
                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsPackageTypes as $modelsPackageType) {
                                $modelsPackageType->product_category_id = $model->product_category_id;
                                if (!($flag = $modelsPackageType->save(false))) {
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
                                'data' => $model,
                            ];
                        } else {
                            return [
                                'success' => false,
                                'message' => $model->errors,
                                'data' => $model,
                                'validate' => ActiveForm::validateMultiple($modelsPackageTypes),
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
                        'validate' => ActiveForm::validateMultiple($modelsPackageTypes),
                    ];
                }
            } else {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกหมวดหมู่สินค้า',
                    'content' => $this->renderAjax('_form_product_category', [
                        'model' => $model,
                        'modelsPackageTypes' => (empty($modelsPackageTypes)) ? [new TblPackageType()] : $modelsPackageTypes,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validateMultiple($modelsPackageTypes),
                ];
            }
        }
    }

    public function actionUpdateProductCategory($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelProductCategory($id);
        $modelsPackageTypes = TblPackageType::find()->where(['product_category_id' => $id])->all();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกหมวดหมู่สินค้า',
                    'content' => $this->renderAjax('_form_product_category', [
                        'model' => $model,
                        'modelsPackageTypes' => (empty($modelsPackageTypes)) ? [new TblPackageType()] : $modelsPackageTypes,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $oldIDs = ArrayHelper::map($modelsPackageTypes, 'package_type_id', 'package_type_id');
                $modelsPackageTypes = DynamicModel::createMultiple(TblPackageType::classname(), $modelsPackageTypes, 'package_type_id');
                DynamicModel::loadMultiple($modelsPackageTypes, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPackageTypes, 'package_type_id', 'package_type_id')));

                // validate all models
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsPackageTypes) && $valid;
                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            if (!empty($deletedIDs)) {
                                TblPackageType::deleteAll(['package_type_id' => $deletedIDs]);
                            }
                            foreach ($modelsPackageTypes as $modelsPackageType) {
                                $modelsPackageType->product_category_id = $model->product_category_id;
                                if (!($flag = $modelsPackageType->save(false))) {
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
                                'data' => $model,
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
                        'validate' => ActiveForm::validateMultiple($modelsPackageTypes),
                    ];
                }
            } else {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกหมวดหมู่สินค้า',
                    'content' => $this->renderAjax('_form_product_category', [
                        'model' => $model,
                        'modelsPackageTypes' => (empty($modelsPackageTypes)) ? [new TblPackageType()] : $modelsPackageTypes,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validateMultiple($modelsPackageTypes),
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
        $attrRemoves = ['quotation_detail_id', 'quotation_id', 'product_id', 'final_price', 'cust_quantity', 'paper_detail_id', 'print_one_page', 'print_two_page'];
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
                        'print_one_page' => (isset($posted['printOnePageKeys']) && is_array($posted['printOnePageKeys']) && $options['print_color']['value'] === '1') ? Json::encode($posted['printOnePageKeys']) : null,
                        //'print_two_page' => (isset($posted['printTwoPageKeys']) && is_array($posted['printTwoPageKeys']) && $options['print_two_page']['value'] === '1') ? Json::encode($posted['printTwoPageKeys']) : null,
                        'paper_option' => isset($posted['paperKeys']) && is_array($posted['paperKeys']) ? Json::encode($posted['paperKeys']) : null,
                        'coating_option' => (isset($posted['coatingKeys']) && is_array($posted['coatingKeys']) && $options['coating_id']['value'] === '1') ? Json::encode($posted['coatingKeys']) : null,
                        'diecut_option' => (isset($posted['dieCutKeys']) && is_array($posted['dieCutKeys']) && $options['diecut_id']['value'] === '1') ? Json::encode($posted['dieCutKeys']) : null,
                        'fold_option' => (isset($posted['foldKeys']) && is_array($posted['foldKeys']) && $options['fold_id']['value'] === '1') ? Json::encode($posted['foldKeys']) : null,
                        'foil_color_option' => (isset($posted['foilColorKeys']) && is_array($posted['foilColorKeys']) && $options['foil_color_id']['value'] === '1') ? Json::encode($posted['foilColorKeys']) : null,
                        'book_binding_option' => (isset($posted['bookBindingKeys']) && is_array($posted['bookBindingKeys']) && $options['book_binding_id']['value'] === '1') ? Json::encode($posted['bookBindingKeys']) : null,
                        'perforate_option' => (isset($posted['perforateKeys']) && is_array($posted['perforateKeys'])) ? Json::encode($posted['perforateKeys']) : null,
                        'two_page_option' => '',
                        'one_page_option' => '',
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
                                'model' => $model,
                            ],
                        ];
                    } else {
                        $transaction->rollBack();
                        return [
                            'success' => false,
                            'data' => $model,
                            'validate' => ArrayHelper::merge(
                                ActiveForm::validate($model), ActiveForm::validate($modelProductOption)
                            ),
                        ];
                    }
                } else {
                    $transaction->rollBack();
                    return [
                        'success' => false,
                        'data' => $model,
                        'validate' => ActiveForm::validate($model),
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
                'attributes' => $attributes,
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
        $attrRemoves = ['quotation_detail_id', 'quotation_id', 'product_id', 'final_price', 'cust_quantity', 'paper_detail_id', 'print_one_page', 'print_two_page'];
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
                        'print_one_page' => (isset($posted['printOnePageKeys']) && is_array($posted['printOnePageKeys']) && $options['print_color']['value'] === '1') ? Json::encode($posted['printOnePageKeys']) : null,
                        //'print_two_page' => (isset($posted['printTwoPageKeys']) && is_array($posted['printTwoPageKeys']) && $options['print_two_page']['value'] === '1') ? Json::encode($posted['printTwoPageKeys']) : null,
                        'paper_option' => isset($posted['paperKeys']) && is_array($posted['paperKeys']) ? Json::encode($posted['paperKeys']) : null,
                        'coating_option' => (isset($posted['coatingKeys']) && is_array($posted['coatingKeys']) && $options['coating_id']['value'] === '1') ? Json::encode($posted['coatingKeys']) : null,
                        'diecut_option' => (isset($posted['dieCutKeys']) && is_array($posted['dieCutKeys']) && $options['diecut_id']['value'] === '1') ? Json::encode($posted['dieCutKeys']) : null,
                        'fold_option' => (isset($posted['foldKeys']) && is_array($posted['foldKeys']) && $options['fold_id']['value'] === '1') ? Json::encode($posted['foldKeys']) : null,
                        'foil_color_option' => (isset($posted['foilColorKeys']) && is_array($posted['foilColorKeys']) && $options['foil_color_id']['value'] === '1') ? Json::encode($posted['foilColorKeys']) : null,
                        'book_binding_option' => (isset($posted['bookBindingKeys']) && is_array($posted['bookBindingKeys']) && $options['book_binding_id']['value'] === '1') ? Json::encode($posted['bookBindingKeys']) : null,
                        'perforate_option' => (isset($posted['perforateKeys']) && is_array($posted['perforateKeys'])) ? Json::encode($posted['perforateKeys']) : null,
                        'two_page_option' => '',
                        'one_page_option' => '',
                    ]);
                    if ($modelProductOption->save()) {
                        $transaction->commit();
                        return [
                            'success' => true,
                            'message' => 'บันทึกสำเร็จ',
                            'action' => 'update-product',
                            'data' => [
                                'url' => Url::to(['update-product', 'id' => $model['product_id']]),
                                'modelProductOption' => $modelProductOption,
                                'model' => $model,
                            ],
                        ];
                    } else {
                        $transaction->rollBack();
                        return [
                            'success' => false,
                            'data' => $model,
                            'validate' => ArrayHelper::merge(
                                ActiveForm::validate($model), ActiveForm::validate($modelProductOption)
                            ),
                        ];
                    }
                } else {
                    $transaction->rollBack();
                    return [
                        'success' => false,
                        'data' => $model,
                        'validate' => ActiveForm::validate($model),
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
                'attributes' => $attributes,
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

    /* ###### ลบไดคัท ##### */

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
        TblPackageType::deleteAll(['product_category_id' => $id]);
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
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public static function isEmpty($data)
    {
        return !isset($data) || empty($data) || ($data === null) || ($data === '');
    }

    /* ###### รูปแบบการเจาะมุม ##### */

    public function actionCreatePerforate()
    {
        $request = Yii::$app->request;
        $model = new TblPerforate();
        $modelsPerforateOptions = [new TblPerforateOption()];

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกรูปแบบการเจาะมุม',
                    'content' => $this->renderAjax('_form_perforate', [
                        'model' => $model,
                        'modelsPerforateOptions' => (empty($modelsPerforateOptions)) ? [new TblPerforateOption()] : $modelsPerforateOptions,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $modelsPerforateOptions = DynamicModel::createMultiple(TblPerforateOption::classname(), $modelsPerforateOptions, 'perforate_option_id');
                DynamicModel::loadMultiple($modelsPerforateOptions, Yii::$app->request->post());
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsPerforateOptions) && $valid;
                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsPerforateOptions as $modelsPerforateOption) {
                                $modelsPerforateOption->perforate_id = $model->perforate_id;
                                if (!($flag = $modelsPerforateOption->save(false))) {
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
                                'data' => $model,
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
                        'validate' => ActiveForm::validateMultiple($modelsPerforateOptions),
                    ];
                }
            } else {
                return [
                    'title' => 'บันทึกรูปแบบการเจาะมุม',
                    'content' => $this->renderAjax('_form_perforate', [
                        'model' => $model,
                        'modelsPerforateOptions' => (empty($modelsPerforateOptions)) ? [new TblPerforateOption()] : $modelsPerforateOptions,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validateMultiple($modelsPerforateOptions),
                ];
            }
        }
    }

    public function actionUpdatePerforate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelPerforate($id);
        $modelsPerforateOptions = $model->perforateOptions;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'แก้ไข บันทึกรูปแบบการเจาะมุม',
                    'content' => $this->renderAjax('_form_perforate', [
                        'model' => $model,
                        'modelsPerforateOptions' => (empty($modelsPerforateOptions)) ? [new TblPerforateOption()] : $modelsPerforateOptions,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $oldIDs = ArrayHelper::map($modelsPerforateOptions, 'perforate_option_id', 'perforate_option_id');
                $modelsPerforateOptions = DynamicModel::createMultiple(TblPerforateOption::classname(), $modelsPerforateOptions, 'perforate_option_id');
                DynamicModel::loadMultiple($modelsPerforateOptions, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPerforateOptions, 'perforate_option_id', 'perforate_option_id')));

                // validate all models
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsPerforateOptions) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            if (!empty($deletedIDs)) {
                                TblPerforateOption::deleteAll(['perforate_option_id' => $deletedIDs]);
                            }
                            foreach ($modelsPerforateOptions as $modelsPerforateOption) {
                                $modelsPerforateOption->perforate_id = $model->perforate_id;
                                if (!($flag = $modelsPerforateOption->save(false))) {
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
                                'data' => $model,
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
                        'validate' => ActiveForm::validateMultiple($modelsPerforateOptions),
                    ];
                }
            } else {
                return [
                    'title' => 'แก้ไข บันทึกรูปแบบการเจาะมุม',
                    'content' => $this->renderAjax('_form_perforate', [
                        'model' => $model,
                        'modelsPerforateOptions' => (empty($modelsPerforateOptions)) ? [new TblPerforateOption()] : $modelsPerforateOptions,
                    ]),
                    'footer' => '',
                ];
            }
        }
    }

    public function actionDeletePerforate($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelPerforate($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    public function actionDeletePerforateOption($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelPerforateOption($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    public function actionPerforateDetail()
    {
        if (isset($_POST['expandRowKey'])) {
            $searchModel = TblPerforateOption::find()->where(['perforate_id' => $_POST['expandRowKey']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $searchModel,
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            return $this->renderPartial('_perforate-details', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSubProductCategory()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = TblPackageType::find()->andWhere(['product_category_id' => $id])->asArray()->all();
            $selected = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $item) {
                    $out[] = ['id' => $item['package_type_id'], 'name' => $item['package_type_name']];
                    if ($i == 0) {
                        $selected = $item['package_type_id'];
                    }
                }
                // Shows how you can preselect a value
                return ['output' => $out, 'selected' => $selected];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionProductCategoryDetail()
    {
        if (isset($_POST['expandRowKey'])) {

            $searchModel = TblPackageType::find()->where(['product_category_id' => $_POST['expandRowKey']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $searchModel,
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            return $this->renderPartial('_product_category_detail', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionCreateBillPrice()
    {
        $request = Yii::$app->request;
        $model = new TblBillPrice();
        $modelsDetails = [new TblBillPriceDetail()];

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกบิล ใบเสร็จ ใบส่งของ',
                    'content' => $this->renderAjax('_form_bill_price', [
                        'model' => $model,
                        'modelsDetails' => (empty($modelsDetails)) ? [new TblBillPriceDetail()] : $modelsDetails,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $modelsDetails = DynamicModel::createMultiple(TblBillPriceDetail::classname(), $modelsDetails, 'bill_detail_id');
                DynamicModel::loadMultiple($modelsDetails, Yii::$app->request->post());
                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsDetails) && $valid;
                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsDetails as $modelsDetail) {
                                $modelsDetail->bill_price_id = $model->bill_price_id;
                                if (!($flag = $modelsDetail->save(false))) {
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
                                'data' => $model,
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
                        'validate' => ActiveForm::validateMultiple($modelsDetails),
                    ];
                }
            } else {
                return [
                    'title' => 'บันทึกบิล ใบเสร็จ ใบส่งของ',
                    'content' => $this->renderAjax('_form_bill_price', [
                        'model' => $model,
                        'modelsDetails' => (empty($modelsDetails)) ? [new TblBillPriceDetail()] : $modelsDetails,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validateMultiple($modelsDetails),
                ];
            }
        }
    }

    public function actionUpdateBillPrice($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelBillPrice($id);
        $modelsDetails = TblBillPriceDetail::find()->where(['bill_price_id' => $id])->all();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกบิล ใบเสร็จ ใบส่งของ',
                    'content' => $this->renderAjax('_form_bill_price', [
                        'model' => $model,
                        'modelsDetails' => (empty($modelsDetails)) ? [new TblBillPriceDetail()] : $modelsDetails,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load(Yii::$app->request->post())) {
                $oldIDs = ArrayHelper::map($modelsDetails, 'bill_detail_id', 'bill_detail_id');
                $modelsDetails = DynamicModel::createMultiple(TblBillPriceDetail::classname(), $modelsDetails, 'bill_detail_id');
                DynamicModel::loadMultiple($modelsDetails, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsDetails, 'bill_detail_id', 'bill_detail_id')));

                $valid = $model->validate();
                $valid = DynamicModel::validateMultiple($modelsDetails) && $valid;
                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            if (!empty($deletedIDs)) {
                                TblBillPriceDetail::deleteAll(['bill_price_id' => $deletedIDs]);
                            }
                            foreach ($modelsDetails as $modelsDetail) {
                                $modelsDetail->bill_price_id = $model->bill_price_id;
                                if (!($flag = $modelsDetail->save(false))) {
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
                                'data' => $model,
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
                        'validate' => ActiveForm::validateMultiple($modelsDetails),
                    ];
                }
            } else {
                return [
                    'title' => 'บันทึกบิล ใบเสร็จ ใบส่งของ',
                    'content' => $this->renderAjax('_form_bill_price', [
                        'model' => $model,
                        'modelsDetails' => (empty($modelsDetails)) ? [new TblBillPriceDetail()] : $modelsDetails,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validateMultiple($modelsDetails),
                ];
            }
        }
    }

    public function actionBillDetails()
    {
        if (isset($_POST['expandRowKey'])) {

            $searchModel = TblBillPriceDetail::find()->where(['bill_price_id' => $_POST['expandRowKey']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $searchModel,
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            return $this->renderPartial('_bill-details', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionDeleteBillPrice($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelBillPrice($id);
        $model->delete();
        TblBillPriceDetail::deleteAll(['bill_price_id' => $id]);
        return [
            'success' => true,
        ];
    }

    public function actionCopyBillPrice($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelBillPrice($id);
        $details = TblBillPriceDetail::findAll(['bill_price_id' => $id]);
        $modelCopy = new TblBillPrice();
        $modelCopy->setAttributes([
            'paper_size_id' => $model['paper_size_id'],
            'bill_floor' => $model['bill_floor'],
            'paper_id' => $model['paper_id'],
        ]);
        $modelCopy->bill_price_id = null;
        if ($modelCopy->save()) {
            foreach ($details as $detail) {
                $billPriceDetail = new TblBillPriceDetail();
                $billPriceDetail->setAttributes([
                    'bill_detail_qty' => $detail['bill_detail_qty'],
                    'bill_detail_price' => $detail['bill_detail_price'],
                ]);
                $billPriceDetail->bill_detail_id = null;
                $billPriceDetail->bill_price_id = $modelCopy['bill_price_id'];
                $billPriceDetail->save();
            }
        }
        return [
            'success' => true,
            'error' => ActiveForm::validate($modelCopy)
        ];
    }

}
