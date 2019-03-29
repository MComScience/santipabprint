<?php

namespace common\modules\app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use trntv\filekit\behaviors\UploadBehavior;
use yii\db\Expression;
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
    public $icon;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_catalog_type';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'file' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'icon',
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
            [['catalog_type_name'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'icon'], 'safe'],
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


    public function getImageUrl()
    {
        if($this->image_path){
            return Yii::getAlias('@web'.$this->image_base_url.$this->image_path);
        } else {
            return Yii::getAlias('@web/images/No_Image_Available.png');
        }
    }
}
