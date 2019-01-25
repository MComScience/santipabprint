<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_product_group_type".
 *
 * @property string $product_group_id รหัสกลุ่มสินค้า
 * @property string $product_type_id รหัสประเภทสินค้า
 */
class TblProductGroupType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product_group_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_group_id', 'product_type_id'], 'required'],
            [['product_group_id', 'product_type_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_group_id' => Yii::t('app', 'รหัสกลุ่มสินค้า'),
            'product_type_id' => Yii::t('app', 'รหัสประเภทสินค้า'),
        ];
    }
}
