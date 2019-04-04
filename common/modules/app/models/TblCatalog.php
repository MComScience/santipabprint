<?php

namespace common\modules\app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use trntv\filekit\behaviors\UploadBehavior;
use yii\db\Expression;
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
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_catalog';
    }

    public function behaviors()
    {
        return [
            'file' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'image',
                'pathAttribute' => 'image_path',
                'baseUrlAttribute' => 'image_base_url',
            ],
        ];
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
            [['image'], 'safe'],
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

    public function getImageUrl()
    {
        if($this->image_path){
            return Yii::getAlias('@web'.$this->image_base_url.$this->image_path);
        } else {
            return Yii::getAlias('@web/images/No_Image_Available.png');
        }
    }
}