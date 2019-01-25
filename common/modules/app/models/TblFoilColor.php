<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_foil_color".
 *
 * @property string $foil_color_id รหัส
 * @property string $foil_color_name ชื่อสีฟอยล์
 * @property string $foil_color_code โค้ดสี
 * @property string $foil_color_description รายละเอียด
 */
class TblFoilColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_foil_color';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'foil_color_id', // required
                'value' => 'FOIL-'.'?' ,
                'group' => $this->foil_color_id,
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
            [['foil_color_name'], 'required'],
            [['foil_color_id'], 'string', 'max' => 100],
            [['foil_color_name', 'foil_color_description'], 'string', 'max' => 255],
            [['foil_color_code'], 'string', 'max' => 50],
            [['foil_color_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'foil_color_id' => Yii::t('app', 'รหัส'),
            'foil_color_name' => Yii::t('app', 'ชื่อสีฟอยล์'),
            'foil_color_code' => Yii::t('app', 'โค้ดสี'),
            'foil_color_description' => Yii::t('app', 'รายละเอียด'),
        ];
    }
}
