<?php

namespace common\modules\app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\modules\app\models\TblProductCategory;
use yii\helpers\Url;

class ApiController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'product-category-list' => ['GET'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['product-category-list'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProductCategoryList()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $catagorys = TblProductCategory::find()->all();
        $itemCatagorys = [];
        foreach ($catagorys as $key => $catagory) {
            $itemCatagorys[] = [
                'product_category_id' => $catagory['product_category_id'],
                'product_category_name' => $catagory['product_category_name'],
                'image_url' => Url::base(true) . $catagory->getImageUrl(),
            ];
        }
        return $itemCatagorys;
    }
}
