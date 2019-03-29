<?php

namespace common\modules\app\controllers;

use Yii;
use common\modules\app\models\TblCatalog;
use common\modules\app\models\TblCatalogSearch;
use common\modules\app\models\TblCatalogTypeSearch;
use common\modules\app\models\TblCatalogType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;

/**
 * CatalogController implements the CRUD actions for TblCatalog model.
 */
class CatalogController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
     * Lists all TblCatalog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblCatalogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGroup()
    {
        $searchModel = new TblCatalogTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('group', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblCatalog model.
     * @param integer $id
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
     * Creates a new TblCatalog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblCatalog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash(\dominus77\sweetalert2\Alert::TYPE_SUCCESS, 'บันทึกเรียบร้อยแล้ว!');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblCatalog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash(\dominus77\sweetalert2\Alert::TYPE_SUCCESS, 'บันทึกเรียบร้อยแล้ว!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblCatalog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDelete($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }

    /**
     * Finds the TblCatalog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblCatalog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblCatalog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelCatalogType($id)
    {
        if (($model = TblCatalogType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreateGroup()
    {
        $request = Yii::$app->request;
        $model = new TblCatalogType();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'บันทึกหมวดหมู่',
                    'content' => $this->renderAjax('_form_group', [
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

    public function actionUpdateGroup($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelCatalogType($id);
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Icon::show('file-text-o') . 'แก้ไขหมวดหมู่',
                    'content' => $this->renderAjax('_form_group', [
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

    public function actionDeleteGroup($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelCatalogType($id);
        $model->delete();
        return [
            'success' => true,
        ];
    }
}
