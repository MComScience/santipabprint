<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_product_category".
 *
 * @property string $product_category_id รหัส
 * @property string $product_category_name หมวดหมู่
 */
class TblProductCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product_category';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'product_category_id', // required
                'value' => 'PC-'.'?' ,
                'group' => $this->product_category_id,
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
            [['product_category_name'], 'required'],
            [['product_category_id'], 'string', 'max' => 100],
            [['product_category_name'], 'string', 'max' => 255],
            [['product_category_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_category_id' => Yii::t('app', 'รหัส'),
            'product_category_name' => Yii::t('app', 'หมวดหมู่'),
        ];
    }
}
