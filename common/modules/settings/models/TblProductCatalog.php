<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_product_catalog".
 *
 * @property int $product_catalog_id รหัส
 * @property string $product_id รหัสสินค้า
 * @property string $paper_size_id ขนาด
 * @property string $paper_size_width กว้าง(กำหนดเอง)
 * @property string $paper_size_height ยาว(กำหนดเอง)
 * @property int $paper_size_unit หน่วย(กำหนดเอง)
 * @property int $page_qty จำนวนหน้า/จำนวนแผ่น
 * @property string $before_print ด้านหน้าพิมพ์
 * @property string $after_print ด้านหลังพิมพ์
 * @property string $paper_id กระดาษ
 * @property string $coating_id เคลือบ
 * @property string $coating_option เคลือบด้านเดียวหรือสองด้าน
 * @property string $diecut ไม่ไดคัท, ไดคัทมุมมน, ไดคัทตามรูปแบบ
 * @property string $diecut_id ไดคัทมุมมน
 * @property string $fold_id วิธีพับ
 * @property string $foil_size_width กว้าง(ฟอยล์)
 * @property string $foil_size_height ยาว(ฟอยล์)
 * @property int $foil_size_unit หน่วย(ฟอยล์)
 * @property string $foil_color_id สีฟอยล์
 * @property string $emboss_size_width กว้าง(ปั๊มนูน)
 * @property string $emboss_size_height ยาว(ปั๊มนูน)
 * @property int $emboss_size_unit หน่วย(ปั๊มนุน)
 * @property int $land_orient แนวตั้ง/แนวนอน
 * @property string $book_binding_id วิธีเข้าเล่ม
 * @property string $cust_quantity จำนวนที่ต้องการ
 * @property string $final_price ราคา
 */
class TblProductCatalog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product_catalog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['paper_size_width', 'paper_size_height', 'foil_size_width', 'foil_size_height', 'emboss_size_width', 'emboss_size_height', 'cust_quantity', 'final_price'], 'number'],
            [['paper_size_unit', 'page_qty', 'foil_size_unit', 'emboss_size_unit', 'land_orient'], 'integer'],
            [['product_id', 'paper_size_id', 'before_print', 'after_print', 'paper_id', 'coating_id', 'diecut_id', 'fold_id', 'foil_color_id', 'book_binding_id'], 'string', 'max' => 100],
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
            'product_catalog_id' => Yii::t('app', 'Product Catalog ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'paper_size_id' => Yii::t('app', 'Paper Size ID'),
            'paper_size_width' => Yii::t('app', 'Paper Size Width'),
            'paper_size_height' => Yii::t('app', 'Paper Size Height'),
            'paper_size_unit' => Yii::t('app', 'Paper Size Unit'),
            'page_qty' => Yii::t('app', 'Page Qty'),
            'before_print' => Yii::t('app', 'Before Print'),
            'after_print' => Yii::t('app', 'After Print'),
            'paper_id' => Yii::t('app', 'Paper ID'),
            'coating_id' => Yii::t('app', 'Coating ID'),
            'coating_option' => Yii::t('app', 'Coating Option'),
            'diecut' => Yii::t('app', 'Diecut'),
            'diecut_id' => Yii::t('app', 'Diecut ID'),
            'fold_id' => Yii::t('app', 'Fold ID'),
            'foil_size_width' => Yii::t('app', 'Foil Size Width'),
            'foil_size_height' => Yii::t('app', 'Foil Size Height'),
            'foil_size_unit' => Yii::t('app', 'Foil Size Unit'),
            'foil_color_id' => Yii::t('app', 'Foil Color ID'),
            'emboss_size_width' => Yii::t('app', 'Emboss Size Width'),
            'emboss_size_height' => Yii::t('app', 'Emboss Size Height'),
            'emboss_size_unit' => Yii::t('app', 'Emboss Size Unit'),
            'land_orient' => Yii::t('app', 'Land Orient'),
            'book_binding_id' => Yii::t('app', 'Book Binding ID'),
            'cust_quantity' => Yii::t('app', 'Cust Quantity'),
            'final_price' => Yii::t('app', 'Final Price'),
        ];
    }
}
