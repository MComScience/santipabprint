<?php
namespace kidz\user\models;

use Yii;
use dektrium\user\models\Profile as BaseProfile;
use trntv\filekit\behaviors\UploadBehavior;
use common\behaviors\CoreMultiValueBehavior;
use yii\db\ActiveRecord;
use common\components\DateConvert;

class Profile extends BaseProfile
{
    public $avatar;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['avatar', 'avatar_path', 'avatar_base_url'], 'safe'];
        $rules[] = [['sex_id', 'first_name', 'last_name', 'birthday', 'tel', 'province'], 'required'];
        return $rules;
    }

    public function behaviors()
    {
        return [
            'avatar-profile' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'avatar',
                'pathAttribute' => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url'
            ],
            [
                'class' => CoreMultiValueBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'birthday',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'birthday',
                ],
                'value' => function ($event) {
                    return DateConvert::convertToDatabase($event->sender[$event->data]);
                },
            ],
            [
                'class' => CoreMultiValueBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => 'birthday',
                ],
                'value' => function ($event) {
                    return DateConvert::convertToDisplay($event->sender[$event->data]);
                },
            ],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['avatar'] = 'รูปประจำตัว';
        $labels['sex_id'] = 'เพศ';
        $labels['first_name'] = 'ชื่อ';
        $labels['last_name'] = 'นามสกุล';
        $labels['birthday'] = 'ว/ด/ป เกิด';
        $labels['tel'] = 'เบอร์โทรศัพท์';
        $labels['province'] = 'จังหวัด';
        return $labels;
    }

    public function getAvatar($default = '/images/default-avatar.png')
    {
        $cache = Yii::$app->cache;
        $key = 'avatar-' . Yii::$app->user->id;
        $avatar = $cache->get($key);
        if ($this->avatar_path && $avatar != false) {
            return $avatar;
        } else {
            $path = $this->avatar_base_url . '/' . $this->avatar_path;
            if ($this->avatar_path) {
                $cache->set($key, $path, 60 * 60 * 1);
            }
            return $this->avatar_path
                ? Yii::getAlias($path)
                : $default;
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['connect'] = ['sex_id', 'first_name', 'last_name', 'birthday', 'tel', 'province'];
        $scenarios['update'] = ['sex_id', 'first_name', 'last_name', 'birthday', 'tel', 'province'];
        return $scenarios;
    }

    public function getTbSex()
    {
        return $this->hasOne(TbSex::className(), ['sex_id' => 'sex_id']);
    }

    public function getFullname()
    {
        return $this->first_name.' '.$this->last_name;
    }
}