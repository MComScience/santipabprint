<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_catalog".
 *
 * @property int $catalog_id
 * @property string $catalog_name ชื่อสินค้า
 * @property string $catalog_detail รายละเอียด
 * @property int $catalog_type_id หมวดหมู่
 * @property string $image_path ที่อยู่รูปภาพ
 * @property string $image_base_url ลิงค์ภาพ
 */
class TblCatalog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_catalog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_name', 'catalog_detail', 'catalog_type_id'], 'required'],
            [['catalog_detail'], 'string'],
            [['catalog_type_id'], 'integer'],
            [['catalog_name', 'image_path', 'image_base_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_id' => Yii::t('app', 'Catalog ID'),
            'catalog_name' => Yii::t('app', 'ชื่อสินค้า'),
            'catalog_detail' => Yii::t('app', 'รายละเอียด'),
            'catalog_type_id' => Yii::t('app', 'หมวดหมู่'),
            'image_path' => Yii::t('app', 'ที่อยู่รูปภาพ'),
            'image_base_url' => Yii::t('app', 'ลิงค์ภาพ'),
        ];
    }
}
