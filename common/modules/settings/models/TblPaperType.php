<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_paper_type".
 *
 * @property string $paper_type_id
 * @property string $paper_type_name ชื่อประเภทกระดาษ
 * @property string $paper_type_description รายละเอียด
 * @property string $product_id รหัสสินค้า
 */
class TblPaperType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paper_type';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'paper_type_id', // required
                'value' => 'PPT'.'.?' ,
                'group' => $this->paper_type_id,
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
            [['paper_type_name', 'product_id'], 'required'],
            [['paper_type_id', 'product_id'], 'string', 'max' => 100],
            [['paper_type_name', 'paper_type_description'], 'string', 'max' => 255],
            [['paper_type_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paper_type_id' => Yii::t('app', 'Paper Type ID'),
            'paper_type_name' => Yii::t('app', 'ชื่อประเภทกระดาษ'),
            'paper_type_description' => Yii::t('app', 'รายละเอียด'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
        ];
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }
}
