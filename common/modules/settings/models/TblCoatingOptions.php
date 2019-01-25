<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_coating_options".
 *
 * @property string $coating_option_id รหัสการเคลือบ
 * @property string $coating_option_name ชื่อรูปแบบการเคลือบ
 * @property string $coating_option_description รายละเอียด
 * @property string $product_id รหัสสินค้า
 */
class TblCoatingOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_coating_options';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'coating_option_id', // required
                'value' => 'CO'.'.?' ,
                'group' => $this->coating_option_id,
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
            [['coating_option_name', 'product_id'], 'required'],
            [['coating_option_id', 'product_id'], 'string', 'max' => 100],
            [['coating_option_name', 'coating_option_description'], 'string', 'max' => 255],
            [['coating_option_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'coating_option_id' => Yii::t('app', 'รหัสการเคลือบ'),
            'coating_option_name' => Yii::t('app', 'ชื่อรูปแบบการเคลือบ'),
            'coating_option_description' => Yii::t('app', 'รายละเอียด'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
        ];
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }
}
