<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_coating".
 *
 * @property string $coating_id รหัส
 * @property string $coating_name วิธีเคลือบ
 * @property string $coating_description รายละเอียด
 */
class TblCoating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_coating';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'coating_id', // required
                'value' => 'C-'.'?' ,
                'group' => $this->coating_id,
                'digit' => 5
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coating_name'], 'required'],
            [['coating_id'], 'string', 'max' => 100],
            [['coating_name', 'coating_description'], 'string', 'max' => 255],
            [['coating_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'coating_id' => Yii::t('app', 'รหัส'),
            'coating_name' => Yii::t('app', 'วิธีเคลือบ'),
            'coating_description' => Yii::t('app', 'รายละเอียด'),
        ];
    }
}
