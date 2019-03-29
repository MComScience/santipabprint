<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_catalog_type".
 *
 * @property int $catalog_type_id
 * @property string $catalog_type_name ชื่อหมวดหมู่
 * @property string $image_path ที่อยู่รูปภาพ
 * @property string $image_base_url ลิงค์ภาพ
 * @property int $created_by ผู้บันทึก
 * @property string $created_at วันที่บันทึก
 * @property int $updated_by ผู้แก้ไข
 * @property string $updated_at วันที่แก้ไข
 */
class TblCatalogType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_catalog_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_type_name'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['catalog_type_name', 'image_path', 'image_base_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_type_id' => Yii::t('app', 'Catalog Type ID'),
            'catalog_type_name' => Yii::t('app', 'ชื่อหมวดหมู่'),
            'image_path' => Yii::t('app', 'ที่อยู่รูปภาพ'),
            'image_base_url' => Yii::t('app', 'ลิงค์ภาพ'),
            'created_by' => Yii::t('app', 'ผู้บันทึก'),
            'created_at' => Yii::t('app', 'วันที่บันทึก'),
            'updated_by' => Yii::t('app', 'ผู้แก้ไข'),
            'updated_at' => Yii::t('app', 'วันที่แก้ไข'),
        ];
    }
}
