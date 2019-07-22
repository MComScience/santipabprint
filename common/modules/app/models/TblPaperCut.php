<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_paper_cut".
 *
 * @property int $paper_size_id รหัส
 * @property int $paper_cut ขนาดกรดาษตัด
 * @property string $paper_print_area_width ความกว้าง
 * @property string $paper_print_area_length ความยาว
 * @property string $paper_size ไชส์กระดาษ
 * @property string $paper_type ประเภท
 * @property int $paper_sticker สติ๊กเกอร์
 */
class TblPaperCut extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_paper_cut';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paper_cut', 'paper_print_area_width', 'paper_print_area_length', 'paper_size', 'paper_sticker'], 'required'],
            [['paper_cut', 'paper_sticker'], 'integer'],
            [['paper_print_area_width', 'paper_print_area_length'], 'number'],
            [['paper_size'], 'string'],
            [['paper_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paper_size_id' => 'รหัส',
            'paper_cut' => 'ขนาดกระดาษตัด',
            'paper_print_area_width' => 'ความกว้าง',
            'paper_print_area_length' => 'ความยาว',
            'paper_size' => 'ไชส์กระดาษ',
            'paper_type' => 'ประเภท',
            'paper_sticker' => 'สติ๊กเกอร์',
        ];
    }
}
