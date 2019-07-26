<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_paper_type".
 *
 * @property string $paper_type_id รหัส
 * @property string $paper_type_name ชื่อประเภทกระดาษ
 */
class TblPaperType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paper_type';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'paper_type_id', // required
                'value' => 'PT-' . '?',
                'group' => $this->paper_type_id,
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
            [['paper_type_name'], 'required'],
            [['paper_type_flag'], 'integer'],
            [['paper_type_id'], 'string', 'max' => 100],
            [['paper_type_name'], 'string', 'max' => 255],
            [['paper_type_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paper_type_id' => Yii::t('app', 'รหัส'),
            'paper_type_name' => Yii::t('app', 'ชื่อประเภทกระดาษ'),
            'paper_type_flag' => Yii::t('app', 'เป็นกระดาษสติ๊กเกอร์หรือไม่?'),
        ];
    }

    public function getPapers()
    {
        return $this->hasMany(TblPaper::className(), ['paper_type_id' => 'paper_type_id']);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        TblPaper::deleteAll(['paper_type_id' => $this->paper_type_id]);
    }

    public function getFlagOptions()
    {
        return [
            '0' => 'ไม่ใช่สติ๊กเกอร์',
            '1' => 'สติ๊กเกอร์'
        ];
    }
}
