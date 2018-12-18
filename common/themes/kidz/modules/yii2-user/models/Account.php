<?php
namespace kidz\user\models;

use dektrium\user\models\Account as BaseAccount;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\authclient\ClientInterface as BaseClientInterface;
use dektrium\user\clients\ClientInterface;

class Account extends BaseAccount
{
    public static function create(BaseClientInterface $client)
    {
        /** @var Account $account */
        $name = $client->getName();
        $userAttributes = $client->getUserAttributes();
        if ($name == 'line'){
            unset($userAttributes['displayName']);
            unset($userAttributes['statusMessage']);
        }

        $account = \Yii::createObject([
            'class' => static::className(),
            'provider' => $client->getId(),
            'client_id' => $client->getUserAttributes()['id'],
            'data' => Json::encode($userAttributes),
        ]);

        if ($client instanceof ClientInterface) {
            $account->setAttributes([
                'username' => $client->getUsername(),
                'email' => $client->getEmail(),
            ], false);
        }

        if (($user = static::fetchUser($account)) instanceof User) {
            $account->user_id = $user->id;
            // the following three lines were added:
            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $user->getId());
        }

        $account->save(false);

        return $account;
    }
}