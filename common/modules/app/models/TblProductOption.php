<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_product_option".
 *
 * @property string $product_id รหัสสินค้า
 * @property string $paper_size_option ขนาดกระดาษ
 * @property string $before_printing ด้านหน้าพิมพ์
 * @property string $after_printing ด้านหลังพิมพ์
 * @property string $paper_option กระดาษ
 * @property string $coating_option เคลือบ
 * @property string $diecut_option ไดคัท
 * @property string $fold_option วิธีพับ
 * @property string $foil_color_option สีฟอยล์
 * @property string $book_binding_option วิธีเข้าเล่ม
 * @property string $two_page_option พิมพ์หน้าหลัง
 * @property string $one_page_option พิมพ์หน้าเดียว
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
            [['paper_size_option', 'before_printing', 'after_printing', 'paper_option', 'coating_option', 'diecut_option', 'fold_option', 'foil_color_option', 'book_binding_option', 'two_page_option', 'one_page_option'], 'safe'],
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
            'paper_size_option' => Yii::t('app', 'ขนาดกระดาษ'),
            'before_printing' => Yii::t('app', 'ด้านหน้าพิมพ์'),
            'after_printing' => Yii::t('app', 'ด้านหลังพิมพ์'),
            'paper_option' => Yii::t('app', 'กระดาษ'),
            'coating_option' => Yii::t('app', 'เคลือบ'),
            'diecut_option' => Yii::t('app', 'ไดคัท'),
            'fold_option' => Yii::t('app', 'วิธีพับ'),
            'foil_color_option' => Yii::t('app', 'สีฟอยล์'),
            'book_binding_option' => Yii::t('app', 'วิธีเข้าเล่ม'),
            'two_page_option' => Yii::t('app', 'พิมพ์หน้าหลัง'),
            'one_page_option' => Yii::t('app', 'พิมพ์หน้าเดียว'),
        ];
    }
}
