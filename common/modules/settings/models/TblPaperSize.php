<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_paper_size".
 *
 * @property string $paper_size_id รหัสขนาด
 * @property string $paper_size_name ชื่อขนาด
 * @property string $paper_size_description รายละเอียด
 * @property double $paper_size_width ความกว้าง
 * @property double $paper_size_height ความยาว
 * @property int $paper_unit_id รหัสหน่วย
 * @property string $product_id รหัสสินค้า
 */
class TblPaperSize extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paper_size';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'paper_size_id', // required
                'value' => 'PPZ'.'.?' ,
                'group' => $this->paper_size_id,
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
            [['paper_size_name', 'product_id'], 'required'],
            [['paper_size_width', 'paper_size_height'], 'number'],
            [['paper_unit_id'], 'integer'],
            [['paper_size_id', 'paper_size_name', 'paper_size_description'], 'string', 'max' => 255],
            [['product_id'], 'string', 'max' => 100],
            [['paper_size_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paper_size_id' => Yii::t('app', 'รหัสขนาด'),
            'paper_size_name' => Yii::t('app', 'ชื่อขนาด'),
            'paper_size_description' => Yii::t('app', 'รายละเอียด'),
            'paper_size_width' => Yii::t('app', 'ความกว้าง'),
            'paper_size_height' => Yii::t('app', 'ความยาว'),
            'paper_unit_id' => Yii::t('app', 'รหัสหน่วย'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
        ];
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }

    //หน่วย
    public function getPaperUnit()
    {
        return $this->hasOne(TblPaperUnit::className(), ['paper_unit_id' => 'paper_unit_id']);
    }
}
