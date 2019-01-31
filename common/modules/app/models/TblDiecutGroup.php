<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_diecut_group".
 *
 * @property string $diecut_group_id รหัส
 * @property string $diecut_group_name รูปแบบไดคัท
 */
class TblDiecutGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_diecut_group';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'diecut_group_id', // required
                'value' => 'DG-'.'?' ,
                'group' => $this->diecut_group_id,
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
            [['diecut_group_name'], 'required'],
            [['diecut_group_id'], 'string', 'max' => 100],
            [['diecut_group_name'], 'string', 'max' => 255],
            [['diecut_group_id'], 'unique'],
            [['diecut_group_value'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'diecut_group_id' => Yii::t('app', 'รหัส'),
            'diecut_group_name' => Yii::t('app', 'รูปแบบไดคัท'),
            'diecut_group_value' => Yii::t('app', 'จำนวนมุม'),
        ];
    }

    public function getDiecuts()
    {
        return $this->hasMany(TblDiecut::className(), ['diecut_group_id' => 'diecut_group_id']);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        TblDiecut::deleteAll(['diecut_group_id' => $this->diecut_group_id]);
    }
}
