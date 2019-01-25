<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_dicut_options".
 *
 * @property string $dicut_option_id
 * @property string $dicut_option_name ชื่อไดคัท
 * @property string $dicut_option_description รายละเอียด
 * @property string $product_id รหัสสินค้า
 */
class TblDicutOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_dicut_options';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'dicut_option_id', // required
                'value' => 'DI'.'.?' ,
                'group' => $this->dicut_option_id,
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
            [['dicut_option_name', 'product_id'], 'required'],
            [['dicut_option_id', 'product_id'], 'string', 'max' => 100],
            [['dicut_option_name', 'dicut_option_description'], 'string', 'max' => 255],
            [['dicut_option_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dicut_option_id' => Yii::t('app', 'Dicut Option ID'),
            'dicut_option_name' => Yii::t('app', 'ชื่อไดคัท'),
            'dicut_option_description' => Yii::t('app', 'รายละเอียด'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
        ];
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }
}
