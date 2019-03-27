<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_coating_price".
 *
 * @property int $coating_price_id
 * @property string $coating_price_name งานเคลือบ
 * @property string $coating_uv_price ราคาเคลือบ UV
 * @property string $coating_varnish_price ราคาเคลือบเงา
 * @property string $coating_matte_price ราคาเคลือบด้าน
 * @property int $coating_sq_in ตารางนิ้ว
 */
class TblCoatingPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_coating_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coating_price_name', 'coating_uv_price', 'coating_varnish_price', 'coating_matte_price', 'coating_sq_in'], 'required'],
            [['coating_uv_price', 'coating_varnish_price', 'coating_matte_price'], 'number'],
            [['coating_sq_in'], 'integer'],
            [['coating_price_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'coating_price_id' => 'Coating Price ID',
            'coating_price_name' => 'Coating Price Name',
            'coating_uv_price' => 'Coating Uv Price',
            'coating_varnish_price' => 'Coating Varnish Price',
            'coating_matte_price' => 'Coating Matte Price',
            'coating_sq_in' => 'Coating Sq In',
        ];
    }
}
