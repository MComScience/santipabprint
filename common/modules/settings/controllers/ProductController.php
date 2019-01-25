<?php

namespace common\modules\settings\controllers;

use common\modules\settings\models\TblCoatingOptions;
use common\modules\settings\models\TblDicutOptions;
use common\modules\settings\models\TblFoilingOptions;
use common\modules\settings\models\TblFoldOptions;
use common\modules\settings\models\TblPaperSize;
use common\modules\settings\models\TblPaperType;
use common\modules\settings\models\TblPrintOptions;
use common\modules\settings\models\TblProductSetting;
use Intervention\Image\ImageManagerStatic;
use kartik\form\ActiveForm;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use common\modules\settings\models\TblProduct;
use common\modules\settings\models\search\TblProductSearch;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use adminlte\helpers\Html;
use mcomscience\data\DataColumn;
use mcomscience\data\ActionColumn;
use yii\data\ArrayDataProvider;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for TblProduct model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', 'admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-paper-size' => ['POST'],
                    'delete-print-option' => ['POST'],
                    'delete-paper-type' => ['POST'],
                    'delete-coating-option' => ['POST'],
                    'delete-dicut-option' => ['POST'],
                    'delete-fold-option' => ['POST'],
                    'delete-foiling-option' => ['POST'],
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
        ];
    }

    /**
     * Lists all TblProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblProduct model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TblProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new TblProduct();
        $modelSetting = new TblProductSetting();

        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $active = TblProductSetting::ACTIVE;
                $modelSetting->product_id = $model->product_id;
                $modelSetting->coating = $active;
                $modelSetting->dicut = $active;
                $modelSetting->fold = $active;
                $modelSetting->foiling = $active;
                $modelSetting->embosser = $active;
                $modelSetting->save();
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => [
                        'model' => $model,
                        'url' => Url::to(['update', 'id' => $model['product_id']])
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'validate' => ActiveForm::validate($model),
                    'message' => 'Oops!'
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->product_id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TblProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'data' => [
                        'model' => $model,
                        'url' => Url::to(['update', 'id' => $model['product_id']])
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'validate' => ActiveForm::validate($model),
                    'message' => 'Oops!'
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->product_id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TblProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();
        TblPaperSize::deleteAll(['product_id' => $id]);//ขนาดกระดาษ
        TblPrintOptions::deleteAll(['product_id' => $id]);//แบบการพิมพ์
        TblPaperType::deleteAll(['product_id' => $id]);
        TblCoatingOptions::deleteAll(['product_id' => $id]);
        TblDicutOptions::deleteAll(['product_id' => $id]);
        TblFoldOptions::deleteAll(['product_id' => $id]);
        TblFoilingOptions::deleteAll(['product_id' => $id]);
        TblProductSetting::deleteAll(['product_id' => $id]);

        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            return 'Your has been deleted.';
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TblProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblProduct::findOne($id)) !== null) {
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

    //บันทึกขนาด
    public function actionCreatePaperSize($id)
    {
        $request = Yii::$app->request;
        $model = new TblPaperSize();
        $modelProduct = $this->findModel($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกขนาดสินค้า : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_paper_size', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกขนาดสินค้า : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกขนาดสินค้า : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_paper_size', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    //แก้ไขขนาดกระดาษ
    public function actionUpdatePaperSize($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelPaperSize($id);
        $modelProduct = $this->findModel($model['product_id']);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกขนาดสินค้า : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_paper_size', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกขนาดสินค้า : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกขนาดสินค้า : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_paper_size', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    //ข้อมูลขนาด
    public function actionDataPaperSize($product_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (empty($product_id)) {
            return ['data' => []];
        }
        $model = $this->findModel($product_id);
        $rows = (new \yii\db\Query())
            ->select([
                'tbl_paper_size.paper_size_id',
                'tbl_paper_size.paper_size_name',
                'tbl_product.product_name',
                'tbl_paper_unit.paper_unit_name',
                'tbl_paper_size.paper_size_description',
                'tbl_paper_size.paper_size_width',
                'tbl_paper_size.paper_size_height',
                'tbl_paper_size.paper_unit_id'
            ])
            ->from('tbl_paper_size')
            ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_paper_size.product_id')
            ->leftJoin('tbl_paper_unit', 'tbl_paper_unit.paper_unit_id = tbl_paper_size.paper_unit_id')
            ->where(['tbl_paper_size.product_id' => $product_id])
            ->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => false,
            ],
            'key' => 'paper_size_id'
        ]);
        $columns = Yii::createObject([
            'class' => DataColumn::className(),
            'dataProvider' => $dataProvider,
            'formatter' => Yii::$app->formatter,
            'columns' => [
                [
                    'attribute' => 'paper_size_id',
                ],
                [
                    'attribute' => 'paper_size_name',
                ],
                [
                    'attribute' => 'paper_size_description',
                ],
                [
                    'attribute' => 'paper_size_width',
                ],
                [
                    'attribute' => 'paper_size_height',
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'attribute' => 'paper_unit_name',
                ],
                [
                    'attribute' => 'paper_unit_id',
                ],
                [
                    'attribute' => 'paper_size',
                    'value' => function ($model, $key, $index) {
                        return !empty($model['paper_unit_id']) ? $model['paper_size_width'] . 'x' . $model['paper_size_height'] . ' ' . $model['paper_unit_name'] : '';
                    }
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {delete}',
                    'updateOptions' => [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii', 'Edit'),
                        'class' => 'btn btn-sm btn-primary'
                    ],
                    'deleteOptions' => [
                        'class' => 'btn btn-sm btn-danger on-delete',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-ajax-reload' => 'tb-paper-size',
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['/settings/product/update-paper-size', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['/settings/product/delete-paper-size', 'id' => $key]);
                        }
                    },
                ],
            ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    //ลบข้อมูลขนาด
    public function actionDeletePaperSize($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelPaperSize($id);
        $model->delete();
        return 'Deleted';
    }

    //ลบรูปแบบการพิมพ์
    public function actionDeletePrintOption($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelPrintOption($id);
        $model->delete();
        return 'Deleted';
    }

    public function actionDeletePaperType($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelPaperType($id);
        $model->delete();
        return 'Deleted';
    }

    public function actionDeleteCoatingOption($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelCoatingOption($id);
        $model->delete();
        return 'Deleted';
    }

    public function actionDeleteDicutOption($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelDicutOption($id);
        $model->delete();
        return 'Deleted';
    }

    public function actionDeleteFoldOption($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelFoldOption($id);
        $model->delete();
        return 'Deleted';
    }

    public function actionDeleteFoilingOption($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelFoilingOption($id);
        $model->delete();
        return 'Deleted';
    }

    //บันทึกรูปแบบการพิมพ์
    public function actionCreatePrintOption($id)
    {
        $request = Yii::$app->request;
        $model = new TblPrintOptions();
        $modelProduct = $this->findModel($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกรูปแบบการพิมพ์ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_print_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกรูปแบบการพิมพ์ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกรูปแบบการพิมพ์ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_print_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    //แก้ไขรูปแบบการพิมพ์
    public function actionUpdatePrintOption($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelPrintOption($id);
        $modelProduct = $this->findModel($model['product_id']);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกรูปแบบการพิมพ์ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_print_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกรูปแบบการพิมพ์ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกรูปแบบการพิมพ์ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_print_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionDataPrintOption($product_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (empty($product_id)) {
            return ['data' => []];
        }
        $model = $this->findModel($product_id);
        $rows = (new \yii\db\Query())
            ->select([
                'tbl_print_options.print_option_id',
                'tbl_print_options.print_option_name',
                'tbl_print_options.print_option_description',
                'tbl_print_options.product_id',
                'tbl_product.product_name'
            ])
            ->from('tbl_print_options')
            ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_print_options.product_id')
            ->where(['tbl_print_options.product_id' => $product_id])
            ->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => false,
            ],
            'key' => 'print_option_id'
        ]);
        $columns = Yii::createObject([
            'class' => DataColumn::className(),
            'dataProvider' => $dataProvider,
            'formatter' => Yii::$app->formatter,
            'columns' => [
                [
                    'attribute' => 'print_option_id',
                ],
                [
                    'attribute' => 'print_option_name',
                ],
                [
                    'attribute' => 'print_option_description',
                ],
                [
                    'attribute' => 'product_id',
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {delete}',
                    'updateOptions' => [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii', 'Edit'),
                        'class' => 'btn btn-sm btn-primary'
                    ],
                    'deleteOptions' => [
                        'class' => 'btn btn-sm btn-danger on-delete',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-ajax-reload' => 'tb-print-option',
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['/settings/product/update-print-option', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['/settings/product/delete-print-option', 'id' => $key]);
                        }
                    },
                ],
            ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    public function actionCreatePaperType($id)
    {
        $request = Yii::$app->request;
        $model = new TblPaperType();
        $modelProduct = $this->findModel($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกประเภทกระดาษ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_paper_type', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกประเภทกระดาษ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกประเภทกระดาษ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_paper_type', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdatePaperType($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelPaperType($id);
        $modelProduct = $this->findModel($model['product_id']);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'แก้ไขประเภทกระดาษ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_paper_type', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'แก้ไขประเภทกระดาษ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'แก้ไขประเภทกระดาษ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_paper_type', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionDataPaperType($product_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (empty($product_id)) {
            return ['data' => []];
        }
        $model = $this->findModel($product_id);
        $rows = (new \yii\db\Query())
            ->select([
                'tbl_paper_type.paper_type_id',
                'tbl_paper_type.paper_type_name',
                'tbl_paper_type.paper_type_description',
                'tbl_paper_type.product_id',
                'tbl_product.product_name'
            ])
            ->from('tbl_paper_type')
            ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_paper_type.product_id')
            ->where(['tbl_paper_type.product_id' => $product_id])
            ->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => false,
            ],
            'key' => 'paper_type_id'
        ]);
        $columns = Yii::createObject([
            'class' => DataColumn::className(),
            'dataProvider' => $dataProvider,
            'formatter' => Yii::$app->formatter,
            'columns' => [
                [
                    'attribute' => 'paper_type_id',
                ],
                [
                    'attribute' => 'paper_type_name',
                ],
                [
                    'attribute' => 'paper_type_description',
                ],
                [
                    'attribute' => 'product_id',
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {delete}',
                    'updateOptions' => [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii', 'Edit'),
                        'class' => 'btn btn-sm btn-primary'
                    ],
                    'deleteOptions' => [
                        'class' => 'btn btn-sm btn-danger on-delete',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-ajax-reload' => 'tb-paper-type',
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['/settings/product/update-paper-type', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['/settings/product/delete-paper-type', 'id' => $key]);
                        }
                    },
                ],
            ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    public function actionCreateCoatingOption($id)
    {
        $request = Yii::$app->request;
        $model = new TblCoatingOptions();
        $modelProduct = $this->findModel($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกวิธีการเคลือบ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_coating_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกวิธีการเคลือบ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกวิธีการเคลือบ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_coating_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateCoatingOption($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelCoatingOption($id);
        $modelProduct = $this->findModel($model['product_id']);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'แก้ไขวิธีการเคลือบ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_coating_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'แก้ไขวิธีการเคลือบ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'แก้ไขวิธีการเคลือบ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_coating_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionDataCoatingOption($product_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (empty($product_id)) {
            return ['data' => []];
        }
        $model = $this->findModel($product_id);
        $rows = (new \yii\db\Query())
            ->select([
                'tbl_coating_options.coating_option_id',
                'tbl_coating_options.coating_option_name',
                'tbl_coating_options.coating_option_description',
                'tbl_coating_options.product_id',
                'tbl_product.product_name'
            ])
            ->from('tbl_coating_options')
            ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_coating_options.product_id')
            ->where(['tbl_coating_options.product_id' => $product_id])
            ->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => false,
            ],
            'key' => 'coating_option_id'
        ]);
        $columns = Yii::createObject([
            'class' => DataColumn::className(),
            'dataProvider' => $dataProvider,
            'formatter' => Yii::$app->formatter,
            'columns' => [
                [
                    'attribute' => 'coating_option_id',
                ],
                [
                    'attribute' => 'coating_option_name',
                ],
                [
                    'attribute' => 'coating_option_description',
                ],
                [
                    'attribute' => 'product_id',
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {delete}',
                    'updateOptions' => [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii', 'Edit'),
                        'class' => 'btn btn-sm btn-primary'
                    ],
                    'deleteOptions' => [
                        'class' => 'btn btn-sm btn-danger on-delete',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-ajax-reload' => 'tb-coating-option',
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['/settings/product/update-coating-option', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['/settings/product/delete-coating-option', 'id' => $key]);
                        }
                    },
                ],
            ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    public function actionCreateDicutOption($id)
    {
        $request = Yii::$app->request;
        $model = new TblDicutOptions();
        $modelProduct = $this->findModel($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกวิธีไดคัท : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_dicut_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกวิธีไดคัท : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกวิธีไดคัท : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_dicut_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateDicutOption($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelDicutOption($id);
        $modelProduct = $this->findModel($model['product_id']);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'แก้ไขวิธีไดคัท : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_dicut_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'แก้ไขวิธีไดคัท : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'แก้ไขวิธีไดคัท : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_dicut_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionDataDicutOption($product_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (empty($product_id)) {
            return ['data' => []];
        }
        $model = $this->findModel($product_id);
        $rows = (new \yii\db\Query())
            ->select([
                'tbl_dicut_options.dicut_option_id',
                'tbl_dicut_options.dicut_option_name',
                'tbl_dicut_options.dicut_option_description',
                'tbl_dicut_options.product_id',
                'tbl_product.product_name'
            ])
            ->from('tbl_dicut_options')
            ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_dicut_options.product_id')
            ->where(['tbl_dicut_options.product_id' => $product_id])
            ->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => false,
            ],
            'key' => 'dicut_option_id'
        ]);
        $columns = Yii::createObject([
            'class' => DataColumn::className(),
            'dataProvider' => $dataProvider,
            'formatter' => Yii::$app->formatter,
            'columns' => [
                [
                    'attribute' => 'dicut_option_id',
                ],
                [
                    'attribute' => 'dicut_option_name',
                ],
                [
                    'attribute' => 'dicut_option_description',
                ],
                [
                    'attribute' => 'product_id',
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {delete}',
                    'updateOptions' => [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii', 'Edit'),
                        'class' => 'btn btn-sm btn-primary'
                    ],
                    'deleteOptions' => [
                        'class' => 'btn btn-sm btn-danger on-delete',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-ajax-reload' => 'tb-dicut-option',
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['/settings/product/update-dicut-option', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['/settings/product/delete-dicut-option', 'id' => $key]);
                        }
                    },
                ],
            ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    public function actionCreateFoldOption($id)
    {
        $request = Yii::$app->request;
        $model = new TblFoldOptions();
        $modelProduct = $this->findModel($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกวิธีการพับ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_fold_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกวิธีการพับ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกวิธีการพับ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_fold_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateFoldOption($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelFoldOption($id);
        $modelProduct = $this->findModel($model['product_id']);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'แก้ไขวิธีการพับ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_fold_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'แก้ไขวิธีการพับ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'แก้ไขวิธีการพับ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_fold_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionDataFoldOption($product_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (empty($product_id)) {
            return ['data' => []];
        }
        $model = $this->findModel($product_id);
        $rows = (new \yii\db\Query())
            ->select([
                'tbl_fold_options.fold_option_id',
                'tbl_fold_options.fold_option_name',
                'tbl_fold_options.fold_option_description',
                'tbl_fold_options.product_id',
                'tbl_product.product_name'
            ])
            ->from('tbl_fold_options')
            ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_fold_options.product_id')
            ->where(['tbl_fold_options.product_id' => $product_id])
            ->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => false,
            ],
            'key' => 'fold_option_id'
        ]);
        $columns = Yii::createObject([
            'class' => DataColumn::className(),
            'dataProvider' => $dataProvider,
            'formatter' => Yii::$app->formatter,
            'columns' => [
                [
                    'attribute' => 'fold_option_id',
                ],
                [
                    'attribute' => 'fold_option_name',
                ],
                [
                    'attribute' => 'fold_option_description',
                ],
                [
                    'attribute' => 'product_id',
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {delete}',
                    'updateOptions' => [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii', 'Edit'),
                        'class' => 'btn btn-sm btn-primary'
                    ],
                    'deleteOptions' => [
                        'class' => 'btn btn-sm btn-danger on-delete',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-ajax-reload' => 'tb-fold-option',
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['/settings/product/update-fold-option', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['/settings/product/delete-fold-option', 'id' => $key]);
                        }
                    },
                ],
            ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    public function actionCreateFoilingOption($id)
    {
        $request = Yii::$app->request;
        $model = new TblFoilingOptions();
        $modelProduct = $this->findModel($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกสีฟอยล์ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_foiling_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'บันทึกสีฟอยล์ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึกสีฟอยล์ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_foiling_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdateFoilingOption($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelFoilingOption($id);
        $modelProduct = $this->findModel($model['product_id']);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'แก้ไขสีฟอยล์ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_foiling_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'title' => 'แก้ไขสีฟอยล์ : ' . $modelProduct['product_name'],
                    'content' => Html::alertSuccess('บันทึกสำเร็จ'),
                    'footer' => '',
                    'message' => 'บันทึกสำเร็จ!'
                ];
            } else {
                return [
                    'success' => false,
                    'title' => 'แก้ไขสีฟอยล์ : ' . $modelProduct['product_name'],
                    'content' => $this->renderAjax('_form_foiling_option', [
                        'model' => $model,
                        'modelProduct' => $modelProduct,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionDataFoilingOption($product_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (empty($product_id)) {
            return ['data' => []];
        }
        $model = $this->findModel($product_id);
        $rows = (new \yii\db\Query())
            ->select([
                'tbl_foiling_options.foiling_option_id',
                'tbl_foiling_options.foiling_option_name',
                'tbl_foiling_options.foiling_option_color_code',
                'tbl_foiling_options.foiling_option_description',
                'tbl_foiling_options.product_id',
                'tbl_product.product_name'
            ])
            ->from('tbl_foiling_options')
            ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_foiling_options.product_id')
            ->where(['tbl_foiling_options.product_id' => $product_id])
            ->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => false,
            ],
            'key' => 'foiling_option_id'
        ]);
        $columns = Yii::createObject([
            'class' => DataColumn::className(),
            'dataProvider' => $dataProvider,
            'formatter' => Yii::$app->formatter,
            'columns' => [
                [
                    'attribute' => 'foiling_option_id',
                ],
                [
                    'attribute' => 'foiling_option_name',
                ],
                [
                    'attribute' => 'foiling_option_color_code',
                    'value' => function ($model, $key, $index) {
                        return !empty($model['foiling_option_color_code']) ?
                            Html::tag('span', $model['foiling_option_color_code'], ['style' => 'background-color: ' . $model['foiling_option_color_code']]) :
                            '';
                    },
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'foiling_option_description',
                ],
                [
                    'attribute' => 'product_id',
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {delete}',
                    'updateOptions' => [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii', 'Edit'),
                        'class' => 'btn btn-sm btn-primary'
                    ],
                    'deleteOptions' => [
                        'class' => 'btn btn-sm btn-danger on-delete',
                        'title' => Yii::t('yii', 'Delete'),
                        'data-ajax-reload' => 'tb-foiling-option',
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') {
                            return Url::to(['/settings/product/update-foiling-option', 'id' => $key]);
                        }
                        if ($action == 'delete') {
                            return Url::to(['/settings/product/delete-foiling-option', 'id' => $key]);
                        }
                    },
                ],
            ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    public function actionProductDetail()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = $this->findModel($_POST['expandRowKey']);
            $rowsPaperSize = (new \yii\db\Query())
                ->select([
                    'tbl_paper_size.paper_size_id',
                    'tbl_paper_size.paper_size_name',
                    'tbl_product.product_name',
                    'tbl_paper_unit.paper_unit_name',
                    'tbl_paper_size.paper_size_description',
                    'tbl_paper_size.paper_size_width',
                    'tbl_paper_size.paper_size_height',
                    'tbl_paper_size.paper_unit_id'
                ])
                ->from('tbl_paper_size')
                ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_paper_size.product_id')
                ->leftJoin('tbl_paper_unit', 'tbl_paper_unit.paper_unit_id = tbl_paper_size.paper_unit_id')
                ->where(['tbl_paper_size.product_id' => $_POST['expandRowKey']])
                ->all();
            $dataPaperSize = new ArrayDataProvider([
                'allModels' => $rowsPaperSize,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'paper_size_id'
            ]);

            $rowsPrintOption = (new \yii\db\Query())
                ->select([
                    'tbl_print_options.print_option_id',
                    'tbl_print_options.print_option_name',
                    'tbl_print_options.print_option_description',
                    'tbl_print_options.product_id',
                    'tbl_product.product_name'
                ])
                ->from('tbl_print_options')
                ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_print_options.product_id')
                ->where(['tbl_print_options.product_id' => $_POST['expandRowKey']])
                ->all();
            $dataPrintOption = new ArrayDataProvider([
                'allModels' => $rowsPrintOption,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'print_option_id'
            ]);

            $rowsPaperType = (new \yii\db\Query())
                ->select([
                    'tbl_paper_type.paper_type_id',
                    'tbl_paper_type.paper_type_name',
                    'tbl_paper_type.paper_type_description',
                    'tbl_paper_type.product_id',
                    'tbl_product.product_name'
                ])
                ->from('tbl_paper_type')
                ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_paper_type.product_id')
                ->where(['tbl_paper_type.product_id' => $_POST['expandRowKey']])
                ->all();
            $dataPaperType = new ArrayDataProvider([
                'allModels' => $rowsPaperType,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'paper_type_id'
            ]);

            $rowsCoatingOption = (new \yii\db\Query())
                ->select([
                    'tbl_coating_options.coating_option_id',
                    'tbl_coating_options.coating_option_name',
                    'tbl_coating_options.coating_option_description',
                    'tbl_coating_options.product_id',
                    'tbl_product.product_name'
                ])
                ->from('tbl_coating_options')
                ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_coating_options.product_id')
                ->where(['tbl_coating_options.product_id' => $_POST['expandRowKey']])
                ->all();
            $dataCoatingOption = new ArrayDataProvider([
                'allModels' => $rowsCoatingOption,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'coating_option_id'
            ]);

            $rowsDicutOption = (new \yii\db\Query())
                ->select([
                    'tbl_dicut_options.dicut_option_id',
                    'tbl_dicut_options.dicut_option_name',
                    'tbl_dicut_options.dicut_option_description',
                    'tbl_dicut_options.product_id',
                    'tbl_product.product_name'
                ])
                ->from('tbl_dicut_options')
                ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_dicut_options.product_id')
                ->where(['tbl_dicut_options.product_id' => $_POST['expandRowKey']])
                ->all();
            $dataDicutOption = new ArrayDataProvider([
                'allModels' => $rowsDicutOption,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'dicut_option_id'
            ]);

            $rowsFoldOption = (new \yii\db\Query())
                ->select([
                    'tbl_fold_options.fold_option_id',
                    'tbl_fold_options.fold_option_name',
                    'tbl_fold_options.fold_option_description',
                    'tbl_fold_options.product_id',
                    'tbl_product.product_name'
                ])
                ->from('tbl_fold_options')
                ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_fold_options.product_id')
                ->where(['tbl_fold_options.product_id' => $_POST['expandRowKey']])
                ->all();
            $dataFoldOption = new ArrayDataProvider([
                'allModels' => $rowsFoldOption,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'fold_option_id'
            ]);

            $rowsFoilingOption = (new \yii\db\Query())
                ->select([
                    'tbl_foiling_options.foiling_option_id',
                    'tbl_foiling_options.foiling_option_name',
                    'tbl_foiling_options.foiling_option_color_code',
                    'tbl_foiling_options.foiling_option_description',
                    'tbl_foiling_options.product_id',
                    'tbl_product.product_name'
                ])
                ->from('tbl_foiling_options')
                ->innerJoin('tbl_product', 'tbl_product.product_id = tbl_foiling_options.product_id')
                ->where(['tbl_foiling_options.product_id' => $_POST['expandRowKey']])
                ->all();
            $dataFoilingOption = new ArrayDataProvider([
                'allModels' => $rowsFoilingOption,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'foiling_option_id'
            ]);
            return $this->renderAjax('_product-details', [
                'model' => $model,
                'dataPaperSize' => $dataPaperSize,
                'dataPrintOption' => $dataPrintOption,
                'dataPaperType' => $dataPaperType,
                'dataCoatingOption' => $dataCoatingOption,
                'dataDicutOption' => $dataDicutOption,
                'dataFoldOption' => $dataFoldOption,
                'dataFoilingOption' => $dataFoilingOption
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionQuotation()
    {
        $settings = TblProductSetting::find()->indexBy('product_id')->all();
        if (Model::loadMultiple($settings, Yii::$app->request->post()) && Model::validateMultiple($settings)) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $count = 0;
            foreach ($settings as $index => $setting) {
                if ($setting->save()) {
                    $count++;
                }
            }
            //Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            if ($count){
                return [
                    'success' => true,
                    'message' => "บันทึกสำเร็จ!"
                ];
            }else{
                return [
                    'success' => false,
                    'message' => "เกิดข้อผิดพลาด",
                    'validate' => ActiveForm::validateMultiple($settings)
                ];
            }
        }

        return $this->render('quotation',[
            'settings' => $settings
        ]);
    }

    public function actionExample()
    {
        $option = [];
        $option['diecut'] = [
            'value' => 1,
            'label' => 'ไดคัท',
            'required' => false,
        ];
        $option['before_print'] = [
            'value' => 1,
            'label' => 'ด้านหน้าพิมพ์',
            'required' => false
        ];
        $option['after_print'] = [
            'value' => 1,
            'label' => 'ด้านหลังพิมพ์',
            'required' => false
        ];
        $option['coating'] = [
            'value' => 1,
            'label' => 'เคลือบ',
            'required' => false
        ];
        $option['foil'] = [
            'value' => 1,
            'label' => 'ฟอยล์',
            'required' => false
        ];
        $option['fold'] = [
            'value' => 1,
            'label' => 'วิธีพับ',
            'required' => false
        ];
        $option['book_binding'] = [
            'value' => 1,
            'label' => 'เข้าเล่ม',
            'required' => false
        ];
        $option['embossing'] = [
            'value' => 1,
            'label' => 'ปั๊มนูน',
            'required' => false
        ];
        $option['page_qty'] = [
            'value' => 1,
            'label' => 'จำนวน หน้า/แผ่น',
            'required' => false
        ];
        $option['land_orient'] = [
            'value' => 1,
            'label' => 'ปฏิทิน (แนวตั้ง/แนวนอน)',
            'required' => false
        ];
        return Json::encode($option);
    }
}
