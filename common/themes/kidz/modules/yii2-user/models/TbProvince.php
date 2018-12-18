<?php

namespace kidz\user\models;

use Yii;

/**
 * This is the model class for table "tb_province".
 *
 * @property int $province_id ไอดี
 * @property string $province_code รหัสจังหวัด
 * @property string $province_name ชื่อจังหวัด
 * @property int $geo_id GEO ID
 */
class TbProvince extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_code', 'province_name'], 'required'],
            [['geo_id'], 'integer'],
            [['province_code'], 'string', 'max' => 2],
            [['province_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'province_id' => 'ไอดี',
            'province_code' => 'รหัสจังหวัด',
            'province_name' => 'ชื่อจังหวัด',
            'geo_id' => 'GEO ID',
        ];
    }
}
