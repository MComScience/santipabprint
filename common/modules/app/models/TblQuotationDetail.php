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
 * @property string $paper_size_width กว้าง(กำหนดเอง)
 * @property string $paper_size_height สูง(กำหนดเอง)
 * @property string $paper_size_lenght ยาว(กำหนดเอง)
 * @property int $paper_size_unit หน่วย(กำหนดเอง)
 * @property string $print_one_page พิมพ์หน้าเดียว
 * @property string $print_two_page พิมพ์สองหน้า
 * @property string $print_option พิมพ์ สองหน้า/หน้าเดียว
 * @property string $print_color สีที่พิมพ์
 * @property string $paper_id กระดาษ
 * @property int $paper_detail_id ขนาดกระดาษ
 * @property string $coating_id เคลือบ
 * @property string $coating_option เคลือบ ด้านเดียว/สองด้าน
 * @property string $diecut_status ไดคัท
 * @property string $diecut ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ
 * @property string $diecut_id ไดคัทมุมมน
 * @property int $perforate ตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว
 * @property int $perforate_option_id มุมที่เจาะ
 * @property string $fold_id วิธีพับ
 * @property string $foil_status สถานะปั๊มฟอยล์
 * @property string $foil_size_width กว้าง(ฟอยล์)
 * @property string $foil_size_height ยาว(ฟอยล์)
 * @property int $foil_size_unit หน่วย(ฟอยล์)
 * @property string $foil_color_id สีฟอยล์
 * @property string $foil_print ปั๊มฟอยล์ หน้า-หลัง/หน้าเดียว
 * @property string $emboss_status สถานะปั๊มนูน
 * @property string $emboss_size_width กว้าง(ปั๊มนูน)
 * @property string $emboss_size_height ยาว(ปั๊มนูน)
 * @property int $emboss_size_unit หน่วย(ป๊มนูน)
 * @property string $emboss_print ปั๊มนูน หน้า-หลัง/หน้าเดียว
 * @property int $glue ปะกาว
 * @property int $rope ร้อยเชือกหูถุง
 * @property int $perforated_ripped ปรุฉีก
 * @property int $running_number running number
 * @property int $window_box ติดหน้าต่างกล่องบรรจุภัณฑ์ 
 * @property string $window_box_width กว้าง (ติดหน้าต่าง)
 * @property string $window_box_lenght ยาว(ติดหน้าต่าง)
 * @property int $window_box_unit หน่วย(ติดหน้าต่าง)
 * @property int $land_orient แนวตั้ง/แนวนอน
 * @property int $book_binding_status วิธีเข้าเล่ม
 * @property string $book_binding_id เข้าเล่มคูปอง
 * @property string $cust_quantity จำนวนที่ต้องการ
 * @property int $page_qty จำนวนหน้า
 * @property string $final_price ราคา
 * @property int $bill_detail_qty จำนวนแผ่นต่อชุด(bill)
 * @property int $book_binding_qty จำนวนแผ่นต่อเล่ม(คูปอง)
 * @property string $book_type ปกนอก/เนื้อใน หนังสือ
 * @property string $book_covers_paper กระดาษปกหนังสือ
 * @property string $book_covers_color สีที่พิมพ์ปกหนังสือ
 * @property int $book_covers_qty จำนวนหน้าปกหนังสือ
 * @property string $book_inner_paper กระดาษเนื้อใน
 * @property string $book_inner_color สี่ที่พิมพ์(เนื้อใน)
 * @property int $book_inner_paper_qty จำนวนหน้า(เนื้อใน)
 * @property string $book_inner_paper_without_color กระดาษขาวดำ(เนื้อใน)
 * @property int $book_inner_without_color_qty จำนวนหน้าขาวดำ(เนื้อใน)
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
            [['quotation_id', 'product_id'], 'required'],
            [['paper_size_width', 'paper_size_height', 'paper_size_lenght', 'foil_size_width', 'foil_size_height', 'emboss_size_width', 'emboss_size_height', 'window_box_width', 'window_box_lenght', 'cust_quantity', 'final_price'], 'number'],
            [['paper_size_unit', 'paper_detail_id', 'perforate', 'perforate_option_id', 'foil_size_unit', 'emboss_size_unit', 'glue', 'rope', 'perforated_ripped', 'running_number', 'window_box', 'window_box_unit', 'land_orient', 'book_binding_status', 'page_qty', 'bill_detail_qty', 'book_binding_qty', 'book_covers_qty', 'book_inner_paper_qty', 'book_inner_without_color_qty','book_paper_status'], 'integer'],
            [['quotation_id', 'product_id', 'paper_size_id', 'print_one_page', 'print_two_page', 'paper_id', 'coating_id', 'diecut_id', 'fold_id', 'foil_color_id', 'book_binding_id', 'book_covers_paper', 'book_covers_color', 'book_inner_paper', 'book_inner_color', 'book_inner_paper_without_color'], 'string', 'max' => 100],
            [['print_option', 'print_color', 'diecut_status', 'diecut', 'foil_print', 'emboss_print', 'book_type'], 'string', 'max' => 50],
            [['coating_option'], 'string', 'max' => 10],
            [['foil_status', 'emboss_status'], 'string', 'max' => 4],
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
            'page_qty' => 'จำนวนหน้า',
            'print_one_page' => 'พิมพ์หน้าเดียว',
            'print_two_page' => 'พิมพ์สองหน้า',
            'print_option' => 'พิมพ์ สองหน้า/หน้าเดียว',
            'print_color' => 'สีที่พิมพ์',
            'paper_id' => 'กระดาษ',
            'paper_detail_id' => 'ขนาดกระดาษ',
            'coating_id' => 'เคลือบ',
            'coating_option' => 'เคลือบ ด้านเดียว/สองด้าน',
            'diecut_status' => 'ไดคัท',
            'diecut' => 'รูปแบบไดคัท',
            'diecut_id' => 'ไดคัทมุมมน',
            'perforate' => 'ตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว',
            'perforate_option_id' => 'มุมที่เจาะ',
            'fold_id' => 'วิธีพับ',
            'foil_size_width' => 'กว้าง(ฟอยล์)',
            'foil_size_height' => 'ยาว(ฟอยล์)',
            'foil_size_unit' => 'หน่วย(ฟอยล์)',
            'foil_color_id' => 'สีฟอยล์',
            'foil_print' => 'ปั๊มฟอยล์ หน้า-หลัง/หน้าเดียว',
            'emboss_size_width' => 'กว้าง(ปั๊มนูน)',
            'emboss_size_height' => 'ยาว(ปั๊มนูน)',
            'emboss_size_unit' => 'หน่วย(ปั๊มนูน)',
            'emboss_print' => 'ปั๊มนูน หน้า-หลัง/หน้าเดียว',
            'glue' => 'ปะกาว',
            'land_orient' => 'แนวตั้ง/แนวนอน',
            'book_binding_id' => 'เข้าเล่มคูปอง',
            'cust_quantity' => 'จำนวนที่ต้องการ',
            'final_price' => 'ราคา',
            'bill_detail_qty' => 'จำนวนแผ่นต่อชุด(bill) ',
            'foil_status' => 'ปั๊มฟอยล์',
            'emboss_status' => 'ปั๊มนูน',
            'rope' => 'ร้อยเชือกหูถุง',
            'perforated_ripped' => 'ปรุฉีก',
            'running_number' => 'running number',
            'book_binding_status' => 'วิธีเข้าเล่ม',
            'book_binding_qty' => 'จำนวนแผ่นต่อเล่ม(คูปอง)',
            'window_box' => 'ติดหน้าต่างกล่องบรรจุภัณฑ์',
            'window_box_width' => 'กว้าง(ติดหน้าต่าง)',
            'window_box_lenght' => 'ยาว(ติดหน้าต่าง)',
            'window_box_unit' => 'หน่วย(ติดหน้าต่าง)',
            'book_paper_status' => 'ปกหนังสือกับเนื้อในเป็นกระดาษเดียวกัน',
            'book_type' => 'ปกนอก/เนื้อใน หนังสือ',
            'book_covers_paper' => 'กระดาษปกหนังสือ',
            'book_covers_color' => 'สีที่พิมพ์ปกหนังสือ',
            'book_covers_qty' => 'จำนวนหน้าปกหนังสือ',
            'book_inner_paper' => 'กระดาษเนื้อใน',
            'book_inner_color' => 'สี่ที่พิมพ์(เนื้อใน)',
            'book_inner_paper_qty' => 'จำนวนหน้า(เนื้อใน)',
            'book_inner_paper_without_color' => 'กระดาษขาวดำ(เนื้อใน)',
            'book_inner_without_color_qty' => 'จำนวนหน้าขาวดำ(เนื้อใน)',
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
