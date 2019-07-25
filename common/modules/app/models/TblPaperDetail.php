<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_paper_detail".
 *
 * @property int $paper_detail_id
 * @property string $paper_id โค้ดกระดาษ
 * @property string $paper_size ขนาด
 * @property string $paper_width ความกว้าง
 * @property string $paper_length ความยาว
 * @property string $paper_price ราคา
 * @property string $stk_flag สติ๊กเกอร์
 */
class TblPaperDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paper_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paper_size', 'paper_width', 'paper_length', 'paper_price', 'stk_flag'], 'required'],
            [['paper_width', 'paper_length', 'paper_price'], 'number'],
            [['paper_id'], 'string', 'max' => 100],
            [['paper_size', 'stk_flag'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paper_detail_id' => 'Paper Detail ID',
            'paper_id' => 'โค้ดกระดาษ',
            'paper_size' => 'ขนาด',
            'paper_width' => 'ความกว้าง',
            'paper_length' => 'ความยาว',
            'paper_price' => 'ราคา',
            'stk_flag' => 'สติ๊กเกอร์',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TblPaperDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TblPaperDetailQuery(get_called_class());
    }
}
