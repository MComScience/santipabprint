<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_unit".
 *
 * @property int $unit_id
 * @property string $unit_name ชื่อหน่วย
 */
class TblUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_name'], 'required'],
            [['unit_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => Yii::t('app', 'รหัส'),
            'unit_name' => Yii::t('app', 'ชื่อหน่วย'),
        ];
    }
}
