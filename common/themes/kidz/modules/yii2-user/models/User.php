<?php
namespace kidz\user\models;

use common\traits\UserJwt;
use mdm\admin\models\Assignment;
use Yii;
use dektrium\user\models\User as BaseUser;
use dektrium\user\helpers\Password;
use yii\web\IdentityInterface;

class User extends BaseUser implements IdentityInterface
{
    use UserJwt;

	public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = $this->getDb()->beginTransaction();

        try {
            $this->password = $this->password == null ? Password::generate(8) : $this->password;

            $this->trigger(self::BEFORE_CREATE);

            if (!$this->save()) {
                $transaction->rollBack();
                return false;
            }

            $this->confirm();

            //$this->mailer->sendWelcomeMessage($this, null, true);
            $this->trigger(self::AFTER_CREATE);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            \Yii::warning($e->getMessage());
            throw $e;
        }
    }

    public function fields()
    {

        return [
            'id',
            'username',
            'email',
            'name' => function ($model) {
                return $model->profile->name;
            },
            'confirmed_at',
            'unconfirmed_email',
            'blocked_at',
            'registration_ip',
            'created_at',
            'updated_at',
            'flags',
            'last_login_at',
            'roles' => function ($model) {
                $permissions = new Assignment($model->id, $model);
                $items = $permissions->getItems();
                return array_keys($items['assigned']);
            },
            'profile' => function ($model) {
                return $model->profile;
            },
            'image_url' => function ($model) {
                return $model->profile->imageUrl;
            },
        ];
    }

    public function extraFields()
    {
        return ['profile'];
    }
}