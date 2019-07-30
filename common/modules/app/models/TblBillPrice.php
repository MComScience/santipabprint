<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_bill_price".
 *
 * @property int $bill_price_id รหัส
 * @property string $paper_size_id รหัสประเภทกระดาษ
 * @property int $bill_floor จำนวนชั้น
 * @property string $paper_id กระดาษ
 */
class TblBillPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bill_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paper_size_id', 'bill_floor', 'paper_id'], 'required'],
            [['bill_floor'], 'integer'],
            [['paper_size_id', 'paper_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bill_price_id' => 'รหัส',
            'paper_size_id' => 'รหัสประเภทกระดาษ',
            'bill_floor' => 'จำนวนชั้น',
            'paper_id' => 'กระดาษ',
        ];
    }
    
    public function getPaperSize() {
        return $this->hasOne(TblPaperSize::className(), ['paper_size_id' => 'paper_size_id']);
    }
    
    public function getPaper() {
        return $this->hasOne(TblPaper::className(), ['paper_id' => 'paper_id']);
    }
}
