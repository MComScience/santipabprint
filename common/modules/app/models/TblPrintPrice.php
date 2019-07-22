<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_print_price".
 *
 * @property int $print_price_id รหัส
 * @property string $print_sheet_qty จำนวนรอบ
 * @property int $print_paper_cut เครื่องพิมพ์ ตัด
 * @property string $price ราคาพิมพ์
 */
class TblPrintPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_print_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['print_sheet_qty', 'print_paper_cut', 'price'], 'required'],
            [['print_sheet_qty', 'price'], 'number'],
            [['print_paper_cut'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'print_price_id' => 'รหัส',
            'print_sheet_qty' => 'จำนวนรอบ',
            'print_paper_cut' => 'เครื่องพิมพ์ ตัด',
            'price' => 'ราคาพิมพ์',
        ];
    }
}
