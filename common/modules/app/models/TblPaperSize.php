<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_paper_size".
 *
 * @property string $paper_size_id รหัส
 * @property string $paper_size_name ชื่อขนาด
 * @property string $paper_size_description รายละเอียด
 * @property int $paper_size_width ความกว้าง
 * @property int $paper_size_height ความยาว
 * @property int $paper_unit_id หน่วย
 */
class TblPaperSize extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paper_size';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'paper_size_id', // required
                'value' => 'PS-'.'?' ,
                'group' => $this->paper_size_id,
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
            [['paper_size_name'], 'required'],
            [['paper_unit_id'], 'integer'],
            [['paper_size_width', 'paper_size_height'], 'number'],
            [['paper_size_id'], 'string', 'max' => 100],
            [['paper_size_name', 'paper_size_description'], 'string', 'max' => 255],
            [['paper_size_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paper_size_id' => Yii::t('app', 'รหัส'),
            'paper_size_name' => Yii::t('app', 'ชื่อขนาด'),
            'paper_size_description' => Yii::t('app', 'รายละเอียด'),
            'paper_size_width' => Yii::t('app', 'ความกว้าง'),
            'paper_size_height' => Yii::t('app', 'ความยาว'),
            'paper_unit_id' => Yii::t('app', 'หน่วย'),
        ];
    }

    public function getUnit()
    {
        return $this->hasOne(TblUnit::className(), ['unit_id' => 'paper_unit_id']);
    }
}
