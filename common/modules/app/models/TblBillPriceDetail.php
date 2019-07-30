<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_bill_price_detail".
 *
 * @property int $bill_detail_id รหัส
 * @property int $bill_price_id รหัสราคาบิล
 * @property int $bill_detail_qty จำนวนเล่ม
 * @property string $bill_detail_price ราคาต่อเล่ม
 */
class TblBillPriceDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bill_price_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_detail_qty', 'bill_detail_price'], 'required'],
            [['bill_price_id', 'bill_detail_qty'], 'integer'],
            [['bill_detail_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bill_detail_id' => 'รหัส',
            'bill_price_id' => 'รหัสราคาบิล',
            'bill_detail_qty' => 'จำนวนเล่ม',
            'bill_detail_price' => 'ราคาต่อเล่ม',
        ];
    }
}
