<?php

namespace common\modules\settings\controllers;

use Yii;
use common\modules\settings\models\TblProductGroup;
use common\modules\settings\models\search\TblProductGroupSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use kartik\icons\Icon;
use adminlte\helpers\Html;
/**
 * ProductGroupController implements the CRUD actions for TblProductGroup model.
 */
class ProductGroupController extends Controller
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
                        'roles' => ['?','admin'],
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

    /**
     * Lists all TblProductGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblProductGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblProductGroup model.
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
     * Creates a new TblProductGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $title = 'บันทึกกลุ่มสินค้า';
        $model = new TblProductGroup();
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
                return [
                    'forceReload' => '#crud-product-group-pjax',
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
                return $this->redirect(['view', 'id' => $model->product_group_id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TblProductGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $title = 'แก้ไขกลุ่มสินค้า';
        $model = $this->findModel($id);

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
                return [
                    'forceReload' => '#crud-product-group-pjax',
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
                return $this->redirect(['view', 'id' => $model->product_group_id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TblProductGroup model.
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
     * Finds the TblProductGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TblProductGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblProductGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
