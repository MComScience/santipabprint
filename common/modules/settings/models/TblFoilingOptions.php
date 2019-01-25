<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_foiling_options".
 *
 * @property string $foiling_option_id
 * @property string $foiling_option_name ชื่อสีฟอยล์
 * @property string $foiling_option_color_code โค้ดสี
 * @property string $foiling_option_description รายละเอียด
 * @property string $product_id รหัสสินค้า
 */
class TblFoilingOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_foiling_options';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'foiling_option_id', // required
                'value' => 'FO'.'.?' ,
                'group' => $this->foiling_option_id,
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
            [['foiling_option_name', 'product_id'], 'required'],
            [['foiling_option_id', 'product_id'], 'string', 'max' => 100],
            [['foiling_option_name', 'foiling_option_description'], 'string', 'max' => 255],
            [['foiling_option_color_code'], 'string', 'max' => 50],
            [['foiling_option_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'foiling_option_id' => Yii::t('app', 'Foiling Option ID'),
            'foiling_option_name' => Yii::t('app', 'ชื่อสีฟอยล์'),
            'foiling_option_color_code' => Yii::t('app', 'โค้ดสี'),
            'foiling_option_description' => Yii::t('app', 'รายละเอียด'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
        ];
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }
}
