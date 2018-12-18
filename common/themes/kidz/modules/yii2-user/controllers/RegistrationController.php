<?php
namespace kidz\user\controllers;

use common\components\LineBotBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Yii;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use yii\web\NotFoundHttpException;
use kidz\user\models\RegistrationForm;
use kidz\user\models\User;
use kidz\user\models\Profile;

class RegistrationController extends BaseRegistrationController
{
    public function actionRegister()
    {
        $request = Yii::$app->request;
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);

        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title' => 'Create An Account',
                    'content' => $this->renderAjax('register',[
                        'model'  => $model,
                        'module' => $this->module,
                    ]),
                    'footer' => ''
                ];
            }elseif ($model->load(\Yii::$app->request->post()) && $model->register()) {
                $this->trigger(self::EVENT_AFTER_REGISTER, $event);
                return $this->goBack();
            }else{
                return [
                    'title' => 'Create An Account',
                    'content' => $this->renderAjax('register',[
                        'model'  => $model,
                        'module' => $this->module,
                    ]),
                    'footer' => ''
                ];
            }
        }else{
            if ($model->load(\Yii::$app->request->post()) && $model->register()) {
                $this->trigger(self::EVENT_AFTER_REGISTER, $event);
    
                return $this->render('/message', [
                    'title'  => \Yii::t('user', 'Your account has been created'),
                    'module' => $this->module,
                ]);
            }
    
            return $this->render('register', [
                'model'  => $model,
                'module' => $this->module,
            ]);
        }
    }

    public function actionConnect($code)
    {
        $account = $this->finder->findAccount()->byCode($code)->one();

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException();
        }

        /** @var User $user */
        $user = \Yii::createObject([
            'class' => User::className(),
            'scenario' => 'connect',
            'username' => $account->username,
            'email' => $account->email,
        ]);

        $profile = \Yii::createObject(Profile::className());
        $profile->scenario = 'connect';

        $event = $this->getConnectEvent($account, $user);

        $this->trigger(self::EVENT_BEFORE_CONNECT, $event);

        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            $profile = Profile::findOne($user->getId());
            $profile->scenario = 'connect';
            $profile->setAttributes(\Yii::$app->request->post('Profile'));
            $profile->save();
            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $user->getId());
            $account->connect($user);
            if ($account->provider == 'line') {
                $this->sendWelcome($account, $profile, $user);
            }
            $this->trigger(self::EVENT_AFTER_CONNECT, $event);
            \Yii::$app->user->login($user, $this->module->rememberFor);
            //return $this->goBack();
            return $this->redirect(['/site/index#qrcode']);
        }

        return $this->render('connect', [
            'model' => $user,
            'account' => $account,
            'profile' => $profile,
        ]);
    }

    private function sendWelcome($account, $profile, $user)
    {
        $lineBot = new LineBotBuilder();
        $bot = $lineBot->getBot();
        $msg = \Yii::t('user', 'Your account on {0} has been created', \Yii::$app->name) . ' รหัสผ่านของคุณคือ : '.$user->password;
        $textMessageBuilder = new TextMessageBuilder('สวัสดีคุณ' . $profile->fullname. ' '.$msg);
        $response = $bot->pushMessage($account->client_id, $textMessageBuilder);
        if (!$response->isSucceeded()) {
            throw new \Exception($response->getHTTPStatus() . ' ' . $response->getRawBody());
        }
    }
}