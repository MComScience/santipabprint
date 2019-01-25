<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_diecut".
 *
 * @property string $diecut_id รหัส
 * @property string $diecut_group_id รหัสรูปแบบ
 * @property string $diecut_name ไดคัท
 * @property string $diecut_description รายละเอียด
 */
class TblDiecut extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_diecut';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'diecut_id', // required
                'value' => 'D-'.'?' ,
                'group' => $this->diecut_id,
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
            [['diecut_name'], 'required'],
            [['diecut_id', 'diecut_group_id'], 'string', 'max' => 100],
            [['diecut_name', 'diecut_description'], 'string', 'max' => 255],
            [['diecut_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'diecut_id' => Yii::t('app', 'รหัส'),
            'diecut_group_id' => Yii::t('app', 'รหัสรูปแบบ'),
            'diecut_name' => Yii::t('app', 'ไดคัท'),
            'diecut_description' => Yii::t('app', 'รายละเอียด'),
        ];
    }

    public function getDiecutGroup()
    {
        return $this->hasOne(TblDiecutGroup::className(), ['diecut_group_id' => 'diecut_group_id']);
    }
}
