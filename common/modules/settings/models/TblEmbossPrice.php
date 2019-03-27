<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_emboss_price".
 *
 * @property int $emboss_price_id
 * @property int $emboss_price_size ขนาด (ตารางนิ้ว)
 * @property string $emboss_price ราคา
 */
class TblEmbossPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_emboss_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emboss_price_size', 'emboss_price'], 'required'],
            [['emboss_price_size'], 'integer'],
            [['emboss_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emboss_price_id' => 'Emboss Price ID',
            'emboss_price_size' => 'Emboss Price Size',
            'emboss_price' => 'Emboss Price',
        ];
    }
}
