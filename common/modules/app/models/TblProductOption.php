<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_product_option".
 *
 * @property string $product_id รหัสสินค้า
 * @property string $paper_size_option ขนาดกระดาษ
 * @property string $print_one_page พิมพ์หน้าเดียว
 * @property string $print_two_page พิมพ์สองหน้า
 * @property string $paper_option กระดาษ
 * @property string $coating_option เคลือบ
 * @property string $diecut_option ไดคัท
 * @property string $fold_option วิธีพับ
 * @property string $foil_color_option สีฟอยล์
 * @property string $book_binding_option วิธีเข้าเล่ม
 * @property string $two_page_option พิมพ์หน้าหลัง
 * @property string $one_page_option พิมพ์หน้าเดียว
 * @property string $perforate_option รูปแบบ tag/ที่คั่นหนังสือ
 */
class TblProductOption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['paper_size_option', 'print_one_page', 'print_two_page', 'paper_option', 'coating_option', 'diecut_option', 'fold_option', 'foil_color_option', 'book_binding_option', 'two_page_option', 'one_page_option', 'perforate_option'], 'string'],
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
            'product_id' => 'รหัสสินค้า',
            'paper_size_option' => 'ขนาดกระดาษ',
            'print_one_page' => 'พิมพ์หน้าเดียว',
            'print_two_page' => 'พิมพ์สองหน้า',
            'paper_option' => 'กระดาษ',
            'coating_option' => 'เคลือบ',
            'diecut_option' => 'ไดคัท',
            'fold_option' => 'วิธีพับ',
            'foil_color_option' => 'สีฟอยล์',
            'book_binding_option' => 'วิธีเข้าเล่ม',
            'two_page_option' => 'พิมพ์หน้าหลัง',
            'one_page_option' => 'พิมพ์หน้าเดียว',
            'perforate_option' => 'รูปแบบ tag/ที่คั่นหนังสือ',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TblProductOptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TblProductOptionQuery(get_called_class());
    }
}
