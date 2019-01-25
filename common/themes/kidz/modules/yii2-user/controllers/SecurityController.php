<?php
namespace kidz\user\controllers;

use Yii;
use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;

class SecurityController extends BaseSecurityController
{
    public function actionLogin()
    {
        $request = Yii::$app->request;
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title' => Yii::t('user', 'Sign in'),
                    'content' => $this->renderAjax('login',[
                        'model'  => $model,
                        'module' => $this->module,
                    ]),
                    'footer' => ''
                ];
            }elseif($model->load(\Yii::$app->getRequest()->post()) && $model->login()){
                $this->trigger(self::EVENT_AFTER_LOGIN, $event);
                return $this->goBack();
            }else{
                return [
                    'title' => Yii::t('user', 'Sign in'),
                    'content' => $this->renderAjax('login',[
                        'model'  => $model,
                        'module' => $this->module,
                    ]),
                    'footer' => ''
                ]; 
            }
        }else{
            if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
                $this->trigger(self::EVENT_AFTER_LOGIN, $event);
                return $this->goBack();
            }
            return $this->render('login', [
                'model'  => $model,
                'module' => $this->module,
            ]);
        }
    }
}