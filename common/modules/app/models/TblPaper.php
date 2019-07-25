<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_paper".
 *
 * @property string $paper_id รหัส
 * @property string $paper_type_id รหัสประเภท
 * @property string $paper_name ชื่อกระดาษ
 * @property string $paper_description รายละเอียด
 */
class TblPaper extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paper';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'paper_id', // required
                'value' => 'P-'.'?' ,
                'group' => $this->paper_id,
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
            [['paper_type_id', 'paper_name'], 'required'],
            [['paper_gram'], 'integer'],
            [['paper_id', 'paper_type_id'], 'string', 'max' => 100],
            [['paper_name', 'paper_description'], 'string', 'max' => 255],
            [['paper_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paper_id' => Yii::t('app', 'รหัส'),
            'paper_type_id' => Yii::t('app', 'รหัสประเภท'),
            'paper_name' => Yii::t('app', 'ชื่อกระดาษ'),
            'paper_gram' => Yii::t('app', 'ขนาดแกรม'),
            'paper_description' => Yii::t('app', 'รายละเอียด')
        ];
    }

    public function getPaperType()
    {
        return $this->hasOne(TblPaperType::className(), ['paper_type_id' => 'paper_type_id']);
    }

    public function getPaperName()
    {
        $gram = !empty($this->paper_gram) ? $this->paper_gram. ' แกรม' : '';
        $size = !empty($this->paper_width) && !empty($this->paper_length) ? 'ขนาด ('.$this->paper_width.'x'.$this->paper_length.')' : '';
        return $this->paper_name.' '.$gram.' '.$size;
    }
}
