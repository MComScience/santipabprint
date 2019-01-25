<?php

namespace common\modules\settings\controllers;

use common\modules\settings\models\TblProductGroupType;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use common\modules\settings\models\TblProductType;
use common\modules\settings\models\search\TblProductTypeSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use kartik\icons\Icon;
use adminlte\helpers\Html;

/**
 * ProductTypeController implements the CRUD actions for TblProductType model.
 */
class ProductTypeController extends Controller
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
     * Lists all TblProductType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblProductTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblProductType model.
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
     * Creates a new TblProductType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $title = 'บันทึกประเภทสินค้า';
        $model = new TblProductType();
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $btnCreateMore = Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create'], [
                'class' => 'btn btn-primary',
                'role' => 'modal-remote',
            ]);
            if ($request->isGet) {
                return [
                    'title' => $title,
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::btnCancelModal() . Html::btnSubmitModal()
                ];
            } elseif ($model->load(Yii::$app->request->post()) && $model->save()) {
                $data = $request->post('TblProductType');
                $productGroups = isset($data['product_group_id']) ? $data['product_group_id'] : null;
                if (!empty($productGroups)) {/**/
                    TblProductGroupType::deleteAll(['product_type_id' => $model['product_type_id']]);
                    foreach ($productGroups as $product_group_id) {
                        $modelProductGroupType = new TblProductGroupType();
                        $modelProductGroupType->product_group_id = $product_group_id;
                        $modelProductGroupType->product_type_id = $model['product_type_id'];
                        $modelProductGroupType->save();
                    }
                }
                return [
                    'forceReload' => '#crud-product-type-pjax',
                    'title' => $title,
                    'content' => Html::alertSuccess('บันทึกสำเร็จ!'),
                    'footer' => Html::btnCloseModal() . $btnCreateMore
                ];
            } else {
                return [
                    'title' => $title,
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::btnCancelModal() . Html::btnSubmitModal()
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->product_type_id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TblProductType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $title = 'แก้ไขประเภทสินค้า';
        $model = $this->findModel($id);

        if ($model->productGroupTypes) {
            $model->product_group_id = ArrayHelper::getColumn($model->productGroupTypes, 'product_group_id');
        }

        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $btnCreateMore = Html::a(Icon::show('plus') . 'เพิ่มรายการ', ['create'], [
                'class' => 'btn btn-primary',
                'role' => 'modal-remote',
            ]);
            if ($request->isGet) {
                return [
                    'title' => $title,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::btnCancelModal() . Html::btnSubmitModal()
                ];
            } elseif ($model->load(Yii::$app->request->post()) && $model->save()) {
                $data = $request->post('TblProductType');
                $productGroups = isset($data['product_group_id']) ? $data['product_group_id'] : null;
                if (!empty($productGroups)) {/**/
                    TblProductGroupType::deleteAll(['product_type_id' => $model['product_type_id']]);
                    foreach ($productGroups as $product_group_id) {
                        $modelProductGroupType = new TblProductGroupType();
                        $modelProductGroupType->product_group_id = $product_group_id;
                        $modelProductGroupType->product_type_id = $model['product_type_id'];
                        $modelProductGroupType->save();
                    }
                }
                return [
                    'forceReload' => '#crud-product-type-pjax',
                    'title' => $title,
                    'content' => Html::alertSuccess('บันทึกสำเร็จ!'),
                    'footer' => Html::btnCloseModal() . $btnCreateMore
                ];
            } else {
                return [
                    'title' => $title,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::btnCancelModal() . Html::btnSubmitModal()
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->product_type_id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TblProductType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            return 'Your has been deleted.';
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblProductType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TblProductType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblProductType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
