<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_product_setting".
 *
 * @property string $product_id รหัสสินค้า
 * @property int $coating การเคลือบ
 * @property int $dicut ไดคัท
 * @property int $fold การพับ
 * @property int $foiling ฟอยล์
 * @property int $embosser ปั๊มนูน
 */
class TblProductSetting extends \yii\db\ActiveRecord
{
    public $product_name;

    const ACTIVE = 1;
    const UNACTIVE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['coating', 'dicut', 'fold', 'foiling', 'embosser'], 'integer'],
            [['product_id'], 'string', 'max' => 100],
            [['product_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
            'coating' => Yii::t('app', 'การเคลือบ'),
            'dicut' => Yii::t('app', 'ไดคัท'),
            'fold' => Yii::t('app', 'การพับ'),
            'foiling' => Yii::t('app', 'ฟอยล์'),
            'embosser' => Yii::t('app', 'ปั๊มนูน'),
        ];
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }
}
