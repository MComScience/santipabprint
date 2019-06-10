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
 * @property string $before_print ด้านหน้าพิมพ์
 * @property string $after_print ด้านหลังพิมพ์
 * @property string $paper_id กระดาษ
 * @property string $coating_id เคลือบ
 * @property string $diecut_id ไดคัท
 * @property string $fold_id วิธีพับ
 * @property int $foil_size_width กว้าง(ฟอยล์)
 * @property int $foil_size_height ยาว(ฟอยล์)
 * @property int $foil_size_unit หน่วย(ฟอยล์)
 * @property int $emboss_size_width กว้าง(ปั๊มนูน)
 * @property int $emboss_size_height ยาว(ปั๊มนูน)
 * @property int $emboss_size_unit หน่วย(ปั๊มนุน)
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
            [['paper_size_id', 'product_id', 'paper_id'], 'required'],
            [['paper_size_width', 'paper_size_height','paper_size_length', 'foil_size_width', 'foil_size_height', 'emboss_size_width', 'emboss_size_height', 'cust_quantity', 'final_price'], 'number'],
            [['paper_size_unit', 'page_qty', 'foil_size_unit', 'emboss_size_unit', 'land_orient'], 'integer'],
            [['quotation_id', 'product_id', 'paper_size_id', 'before_print', 'after_print', 'paper_id', 'coating_id', 'diecut_id', 'fold_id', 'foil_color_id', 'book_binding_id'], 'string', 'max' => 100],
            [['coating_option'], 'string', 'max' => 10],
            [['diecut'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quotation_detail_id' => Yii::t('app', 'รหัส'),
            'quotation_id' => Yii::t('app', 'เลขที่ใบเสนอราคา'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
            'paper_size_id' => Yii::t('app', 'ขนาด'),
            'paper_size_width' => Yii::t('app', 'กว้าง(กำหนดเอง)'),
            'paper_size_length' => Yii::t('app', 'ยาว(กำหนดเอง)'),
            'paper_size_height' => Yii::t('app', 'สูง(กำหนดเอง)'),
            'paper_size_unit' => Yii::t('app', 'หน่วย(กำหนดเอง)'),
            'page_qty' => Yii::t('app', 'จำนวนหน้า/จำนวนแผ่น'),
            'before_print' => Yii::t('app', 'ด้านหน้าพิมพ์'),
            'after_print' => Yii::t('app', 'ด้านหลังพิมพ์'),
            'paper_id' => Yii::t('app', 'กระดาษ'),
            'coating_id' => Yii::t('app', 'เคลือบ'),
            'coating_option' => Yii::t('app', 'เคลือบด้านเดียวหรือสองด้าน'),
            'diecut' => Yii::t('app', 'ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ'),
            'diecut_id' => Yii::t('app', 'ไดคัทมุมมน'),
            'fold_id' => Yii::t('app', 'วิธีพับ'),
            'foil_size_width' => Yii::t('app', 'กว้าง(ฟอยล์)'),
            'foil_size_height' => Yii::t('app', 'ยาว(ฟอยล์)'),
            'foil_size_unit' => Yii::t('app', 'หน่วย(ฟอยล์)'),
            'foil_color_id' => Yii::t('app', 'สีฟอยล์'),
            'emboss_size_width' => Yii::t('app', 'กว้าง(ปั๊มนูน)'),
            'emboss_size_height' => Yii::t('app', 'ยาว(ปั๊มนูน)'),
            'emboss_size_unit' => Yii::t('app', 'หน่วย(ปั๊มนุน)'),
            'land_orient' => Yii::t('app', 'แนวตั้ง/แนวนอน'),
            'book_binding_id' => Yii::t('app', 'วิธีเข้าเล่ม'),
            'final_price' => Yii::t('app', 'ราคา'),
            'cust_quantity' => Yii::t('app', 'จำนวนที่ต้องการ')
            
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
        return $this->hasOne(TblColorPrinting::className(), ['color_printing_id' => 'before_print']);
    }

    //หลังพิมพ์
    public function getAfterPrinting()
    {
        return $this->hasOne(TblColorPrinting::className(), ['color_printing_id' => 'after_print']);
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
