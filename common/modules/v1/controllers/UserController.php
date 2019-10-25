<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 21/10/2562
 * Time: 20:08
 */

namespace common\modules\v1\controllers;

use kidz\user\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use common\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\HttpException;

class UserController extends ActiveController
{
    public $modelClass = 'kidz\user\models\User';

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'view' => ['get'],
                'create' => ['post'],
                'update' => ['put'],
                'delete' => ['delete'],
                'login' => ['post']
            ],
        ];
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = [
            'options',
            'login'
        ];
        // setup access
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete'], //only be applied to
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
                    'roles' => ['admin', 'manageUsers'],
                ],
                [
                    'allow' => true,
                    'actions' => ['me'],
                    'roles' => ['user']
                ]
            ],
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $model = \Yii::createObject(LoginForm::className());
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate() && $model->login()) {
            $user = $model->getUser();
            $user->generateAccessTokenAfterUpdatingClientInfo(true);

            $responseData = [
                'access_token' => $user->access_token,
                'user' => $user
            ];

            return $responseData;
        } else {
            // Validation error
            return $this->apiBadRequest(Json::encode($model->errors));
        }
    }

    public function apiBadRequest($message = false)
    {
        throw new HttpException(400, $message ? $message : 'Error Bad request.');
    }

    public function apiDataNotFound($message = false)
    {
        throw new HttpException(404, $message ? $message : 'Resource not found.');
    }

    public function apiValidate($message = false)
    {
        throw new HttpException(422, $message ? $message : 'Error validation.');
    }
}
