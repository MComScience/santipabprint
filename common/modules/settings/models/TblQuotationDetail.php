<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_quotation_detail".
 *
 * @property int $quotation_detail_id
 * @property string $quotation_id เลขที่ใบเสนอราคา
 * @property string $product_id รหัสสินค้า
 * @property string $paper_size_id ขนาดกระดาษ
 * @property int $quotation_qty จำนวนที่ต้องการ
 * @property string $print_option_id รูปแบบการพิมพ์
 * @property string $paper_type_id ประเภทกระดาษ
 * @property string $coating_option_id เคลือบ
 * @property string $dicut_option_id ไดคัท
 * @property string $fold_option_id การพับ
 * @property string $foiling_option_id สีฟอยล์
 * @property string $foiling_size ขนาดฟอยล์ (กว้างxยาว)
 * @property string $foiling_unit_id หน่วยฟอยล์
 * @property string $embosser ขนาดปั๊มนูน (กว้างxยาว)
 * @property string $embosser_unit_id หน่วยปั๊มนูน
 */
class TblQuotationDetail extends \yii\db\ActiveRecord
{
    const SCENARIO_ADD_TO_CART = 'add-to-cart';
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
            [['quotation_id', 'product_id', 'paper_size_id', 'print_option_id', 'paper_type_id'], 'required'],
            [['custom_paper', 'custom_paper_width', 'custom_paper_height', 'custom_paper_unit', 'quotation_qty', 'foiling_width', 'foiling_height','embosser_width', 'embosser_height'], 'integer'],
            [['quotation_id', 'product_id', 'paper_size_id', 'paper_type_id', 'coating_option_id', 'dicut_option_id', 'fold_option_id', 'foiling_option_id', 'foiling_unit_id', 'embosser_unit_id', 'first_page', 'last_page'], 'string', 'max' => 100],
            [['product_id', 'paper_size_id', 'print_option_id', 'paper_type_id'], 'required', 'on' => self::SCENARIO_ADD_TO_CART],
            ['paper_size_id', 'validatePaperSize'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quotation_detail_id' => Yii::t('app', 'Quotation Detail ID'),
            'quotation_id' => Yii::t('app', 'เลขที่ใบเสนอราคา'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
            'paper_size_id' => Yii::t('app', 'ขนาดกระดาษ'),
            'custom_paper' => Yii::t('app', 'กำหนดขนาดเอง'),
            'custom_paper_width' => Yii::t('app', 'กว้าง(กำหนดเอง)'),
            'custom_paper_height' => Yii::t('app', 'สูง(กำหนดเอง)'),
            'custom_paper_unit' => Yii::t('app', 'หน่วย(กำหนดเอง)'),
            'custom_paper_size' => Yii::t('app', 'กำหนดขนาดเอง'),
            'quotation_qty' => Yii::t('app', 'จำนวนที่ต้องการ'),
            'paper_type_id' => Yii::t('app', 'ประเภทกระดาษ'),
            'coating_option_id' => Yii::t('app', 'เคลือบ'),
            'dicut_option_id' => Yii::t('app', 'ไดคัท'),
            'fold_option_id' => Yii::t('app', 'การพับ'),
            'foiling_option_id' => Yii::t('app', 'สีฟอยล์'),
            'foiling_width' => Yii::t('app', 'ขนาดฟอยล์ (กว้าง)'),
            'foiling_height' => Yii::t('app', 'ขนาดฟอยล์ (สูง)'),
            'foiling_unit_id' => Yii::t('app', 'หน่วยฟอยล์'),
            'embosser_width' => Yii::t('app', 'ขนาดปั๊มนูน (กว้าง)'),
            'embosser_height' => Yii::t('app', 'ขนาดปั๊มนูน (ยาว)'),
            'embosser_unit_id' => Yii::t('app', 'หน่วยปั๊มนูน'),
            'first_page' => Yii::t('app', 'หน้าแรก'),
            'last_page' => Yii::t('app', 'หน้าหลัง'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD_TO_CART] = [
            'product_id', 'paper_size_id', 'custom_paper', 'custom_paper_width', 'custom_paper_height',
            'custom_paper_unit', 'custom_paper_size', 'quotation_qty', 'paper_type_id',
            'coating_option_id', 'fold_option_id', 'foiling_option_id', 'foiling_unit_id',
            'embosser_width', 'embosser_height', 'embosser_unit_id','first_page','last_page', 'foiling_width', 'foiling_height'
        ];
        return $scenarios;
    }

    public function validatePaperSize($attribute, $params, $validator)
    {
        if ($this->paper_size_id === 'custom_size') {
            if (empty($this->custom_paper_width)){
                $this->addError('custom_paper_width', 'ความกว้างต้องไม่ว่างเปล่า');
            }
            if (empty($this->custom_paper_height)){
                $this->addError('custom_paper_height', 'ความสูงต้องไม่ว่างเปล่า');
            }
            if (empty($this->custom_paper_unit)){
                $this->addError('custom_paper_unit', 'หน่วยต้องไม่ว่างเปล่า');
            }
        }
    }
}
