<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_fold_options".
 *
 * @property string $fold_option_id
 * @property string $fold_option_name ชื่อแบบการพับ
 * @property string $fold_option_description รายละเอียด
 * @property string $product_id รหัสสินค้า
 */
class TblFoldOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_fold_options';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'fold_option_id', // required
                'value' => 'F'.'.?' ,
                'group' => $this->fold_option_id,
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
            [['fold_option_name', 'product_id'], 'required'],
            [['fold_option_id', 'product_id'], 'string', 'max' => 100],
            [['fold_option_name', 'fold_option_description'], 'string', 'max' => 255],
            [['fold_option_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fold_option_id' => Yii::t('app', 'Fold Option ID'),
            'fold_option_name' => Yii::t('app', 'ชื่อแบบการพับ'),
            'fold_option_description' => Yii::t('app', 'รายละเอียด'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
        ];
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }
}
