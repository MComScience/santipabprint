<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_quotation_detail".
 *
 * @property int $quotation_detail_id รหัส
 * @property string $quotation_id เลขที่ใบเสนอราคา
 * @property string $product_id รหัสสินค้า
 * @property string $paper_size_id ขนาด
 * @property int $paper_size_width กว้าง(กำหนดเอง)
 * @property int $paper_size_height ยาว(กำหนดเอง)
 * @property int $paper_size_unit หน่วย(กำหนดเอง)
 * @property int $page_qty จำนวนหน้า/จำนวนแผ่น
 * @property string $print_one_page ด้านหน้าพิมพ์
 * @property string $print_two_page ด้านหลังพิมพ์
 * @property string $paper_id กระดาษ
 * @property string $coating_id เคลือบ
 * @property string $diecut_id ไดคัท
 * @property string $fold_id วิธีพับ
 * @property int $foil_size_width กว้าง(ฟอยล์)
 * @property int $foil_size_height ยาว(ฟอยล์)
 * @property int $foil_size_unit หน่วย(ฟอยล์)
 * @property int $emboss_size_width กว้าง(ปั๊มนูน)
 * @property int $emboss_size_height ยาว(ปั๊มนูน)
 * @property int $emboss_size_unit หน่วย(ปั๊มนูน)
 * @property int $land_orient แนวตั้ง/แนวนอน
 * @property string $book_binding_id วิธีเข้าเล่ม
 */
class TblQuotationDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_quotation_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quotation_id', 'product_id', 'paper_detail_id'], 'required'],
            [['paper_size_width', 'paper_size_lenght', 'paper_size_height', 'foil_size_width', 'foil_size_height', 'emboss_size_width', 'emboss_size_height', 'cust_quantity', 'final_price'], 'number'],
            [['paper_size_unit', 'page_qty', 'paper_detail_id', 'perforate', 'perforate_option_id', 'foil_size_unit', 'emboss_size_unit', 'glue', 'land_orient','bill_detail_qty'], 'integer'],
            [['quotation_id', 'product_id', 'paper_size_id', 'print_one_page', 'print_two_page', 'paper_id', 'coating_id', 'diecut_id', 'fold_id', 'foil_color_id', 'book_binding_id'], 'string', 'max' => 100],
            [['print_option', 'print_color', 'diecut', 'foli_print', 'emboss_print'], 'string', 'max' => 50],
            [['coating_option'], 'string', 'max' => 10],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quotation_detail_id' => 'รหัส',
            'quotation_id' => 'เลขที่ใบเสนอราคา',
            'product_id' => 'รหัสสินค้า',
            'paper_size_id' => 'ขนาด',
            'paper_size_width' => 'กว้าง(กำหนดเอง)',
            'paper_size_lenght' => 'ยาว(กำหนดเอง)',
            'paper_size_height' => 'สูง(กำหนดเอง)',
            'paper_size_unit' => 'หน่วย(กำหนดเอง)',
            'page_qty' => 'จำนวนหน้า/จำนวนแผ่น',
            'print_one_page' => 'พิมพ์หน้าเดียว',
            'print_two_page' => 'พิมพ์สองหน้า',
            'print_option' => 'พิมพ์สองหน้าหรือหน้าเดียว',
            'print_color' => 'สีที่พิมพ์',
            'paper_id' => 'กระดาษ',
            'paper_detail_id' => 'ขนาดกระดาษ',
            'coating_id' => 'เคลือบ',
            'coating_option' => 'เคลือบด้านเดียวหรือสองด้าน',
            'diecut' => 'ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ',
            'diecut_id' => 'ไดคัทมุมมน',
            'perforate' => 'ตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว',
            'perforate_option_id' => 'มุมที่เจาะ',
            'fold_id' => 'วิธีพับ',
            'foil_size_width' => 'กว้าง(ฟอยล์)',
            'foil_size_height' => 'ยาว(ฟอยล์)',
            'foil_size_unit' => 'หน่วย(ฟอยล์)',
            'foil_color_id' => 'สีฟอยล์',
            'foli_print' => 'ปั๊มฟอยล์ทั้งหน้า/หลังหรือหน้าเดียว',
            'emboss_size_width' => 'กว้าง(ปั๊มนูน)',
            'emboss_size_height' => 'ยาว(ปั๊มนูน)',
            'emboss_size_unit' => 'หน่วย(ปั๊มนูน)',
            'emboss_print' => 'ปั๊มนูนทั้งหน้า/หลังหรือหน้าเดียว',
            'glue' => 'ปะกาว',
            'land_orient' => 'แนวตั้ง/แนวนอน',
            'book_binding_id' => 'วิธีเข้าเล่ม',
            'cust_quantity' => 'จำนวนที่ต้องการ',
            'final_price' => 'ราคา',
            'bill_detail_qty' => 'จำนวนแผ่นต่อชุด ',
        ];
    }


    //ใบเสนอราคา
    public function getQuotation()
    {
        return $this->hasOne(TblQuotation::className(), ['quotation_id' => 'quotation_id']);
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }

    //ขนาดกระดาษ
    public function getPaperSize()
    {
        return $this->hasOne(TblPaperSize::className(), ['paper_size_id' => 'paper_size_id']);
    }

    //หน่วยขนาด
    public function getPaperSizeUnit()
    {
        return $this->hasOne(TblUnit::className(), ['unit_id' => 'paper_size_unit']);
    }

    //หน้าพิมพ์
    public function getBeforePrinting()
    {
        return $this->hasOne(TblColorPrinting::className(), ['color_printing_id' => 'print_one_page']);
    }

    //หลังพิมพ์
    public function getAfterPrinting()
    {
        return $this->hasOne(TblColorPrinting::className(), ['color_printing_id' => 'print_two_page']);
    }

    //กระดาษ
    public function getPaper()
    {
        return $this->hasOne(TblPaper::className(), ['paper_id' => 'paper_id']);
    }

    //เคลือบ
    public function getCoating()
    {
        return $this->hasOne(TblCoating::className(), ['coating_id' => 'coating_id']);
    }

    //ไดคัท
    public function getDiecut()
    {
        return $this->hasOne(TblDiecut::className(), ['diecut_id' => 'diecut_id']);
    }

    //วิธีพับ
    public function getFold()
    {
        return $this->hasOne(TblFold::className(), ['fold_id' => 'fold_id']);
    }

    //หน่วยฟอยล์
    public function getFoilSizeUnit()
    {
        return $this->hasOne(TblUnit::className(), ['unit_id' => 'foil_size_unit']);
    }

    //หน่วยปั๊มนูน
    public function getEmbossUnit()
    {
        return $this->hasOne(TblUnit::className(), ['unit_id' => 'emboss_size_unit']);
    }

    //วิธีเข้าเล่ม
    public function getBookBinding()
    {
        return $this->hasOne(TblBookBinding::className(), ['book_binding_id' => 'book_binding_id']);
    }
}
