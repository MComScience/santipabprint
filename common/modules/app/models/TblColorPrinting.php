<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_color_printing".
 *
 * @property string $color_printing_id รหัส
 * @property string $color_printing_name หน้าพิมพ์/หลังพิมพ์
 * @property string $color_printing_descriotion รายละเอียด
 */
class TblColorPrinting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_color_printing';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'color_printing_id', // required
                'value' => 'PT-'.'?' ,
                'group' => $this->color_printing_id,
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
            [['color_printing_name'], 'required'],
            [['color_printing_id'], 'string', 'max' => 100],
            [['color_printing_name', 'color_printing_descriotion'], 'string', 'max' => 255],
            [['color_printing_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'color_printing_id' => Yii::t('app', 'รหัส'),
            'color_printing_name' => Yii::t('app', 'สีที่พิมพ์'),
            'color_printing_descriotion' => Yii::t('app', 'รายละเอียด'),
        ];
    }
}
