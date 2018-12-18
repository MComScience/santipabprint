<?php

namespace kidz\user\models;

use Yii;

/**
 * This is the model class for table "tb_sex".
 *
 * @property int $sex_id
 * @property string $sex_name คำนำหน้า
 */
class TbSex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_sex';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex_name'], 'required'],
            [['sex_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sex_id' => 'Sex ID',
            'sex_name' => 'คำนำหน้า',
        ];
    }
}
