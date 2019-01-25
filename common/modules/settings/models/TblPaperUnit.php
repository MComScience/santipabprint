<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_paper_unit".
 *
 * @property int $paper_unit_id รหัสหน่วย
 * @property string $paper_unit_name ชื่อหน่วย
 */
class TblPaperUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paper_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paper_unit_name'], 'required'],
            [['paper_unit_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paper_unit_id' => Yii::t('app', 'รหัสหน่วย'),
            'paper_unit_name' => Yii::t('app', 'ชื่อหน่วย'),
        ];
    }
}
