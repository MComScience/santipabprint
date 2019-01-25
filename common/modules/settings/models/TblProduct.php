<?php

namespace common\modules\settings\models;

use adminlte\helpers\Html;
use kidz\user\models\Profile;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "tbl_product".
 *
 * @property string $product_id รหัสสินค้า
 * @property string $product_type_id รหัสประเภทสินค้า
 * @property string $product_name ชื่อสินค้า
 * @property string $product_description รายละเอียด
 * @property string $product_icon_path ที่อยู่ภาพ
 * @property string $product_icon_base_url Url ภาพ
 * @property int $product_status สถานะสินค้า
 * @property int $created_by ผู้บันทึก
 * @property string $created_at ว/ด/ป ที่บันทึก
 * @property int $updated_by ผู้แก้ไข
 * @property string $updated_at ว/ด/ป ที่แก้ไข
 */
class TblProduct extends \yii\db\ActiveRecord
{
    public $icon;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product';
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
                'pathAttribute' => 'product_icon_path',
                'baseUrlAttribute' => 'product_icon_base_url',
            ],
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'product_id', // required
                'value' => 'SP.'.Yii::$app->formatter->asDate('now','php:Ymd').'.?' ,
                'group' => $this->product_id,
                'digit' => 5
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_type_id', 'product_name'], 'required'],
            [['product_description'], 'string'],
            [['product_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'icon'], 'safe'],
            [['product_id', 'product_type_id'], 'string', 'max' => 100],
            [['product_name', 'product_icon_path', 'product_icon_base_url'], 'string', 'max' => 255],
            [['product_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
            'product_type_id' => Yii::t('app', 'รหัสประเภทสินค้า'),
            'product_name' => Yii::t('app', 'ชื่อสินค้า'),
            'product_description' => Yii::t('app', 'รายละเอียด'),
            'product_icon_path' => Yii::t('app', 'ที่อยู่ภาพ'),
            'product_icon_base_url' => Yii::t('app', 'Url ภาพ'),
            'product_status' => Yii::t('app', 'สถานะสินค้า'),
            'created_by' => Yii::t('app', 'ผู้บันทึก'),
            'created_at' => Yii::t('app', 'ว/ด/ป ที่บันทึก'),
            'updated_by' => Yii::t('app', 'ผู้แก้ไข'),
            'updated_at' => Yii::t('app', 'ว/ด/ป ที่แก้ไข'),
        ];
    }

    //ประเภทสินค้า
    public function getProductType()
    {
        return $this->hasOne(TblProductType::className(), ['product_type_id' => 'product_type_id']);
    }

    //ขนาด
    public function getPaperSizes()
    {
        return $this->hasMany(TblPaperSize::className(), ['product_id' => 'product_id']);
    }

    //แบบการพิมพ์
    public function getPrintOptions()
    {
        return $this->hasMany(TblPrintOptions::className(), ['product_id' => 'product_id']);
    }

    //ประเภทกระดาษ
    public function getPaperTypes()
    {
        return $this->hasMany(TblPaperType::className(), ['product_id' => 'product_id']);
    }

    //การเคลือบ
    public function getCoatingOptions()
    {
        return $this->hasMany(TblCoatingOptions::className(), ['product_id' => 'product_id']);
    }

    //ไดคัท
    public function getDicutOptions()
    {
        return $this->hasMany(TblDicutOptions::className(), ['product_id' => 'product_id']);
    }

    //การพับ
    public function getFoldOptions()
    {
        return $this->hasMany(TblFoldOptions::className(), ['product_id' => 'product_id']);
    }

    //ฟอยล์
    public function getFoilingOptions()
    {
        return $this->hasMany(TblFoilingOptions::className(), ['product_id' => 'product_id']);
    }

    //ตั้งค่า
    public function getProductSetting()
    {
        return $this->hasOne(TblProductSetting::className(), ['product_id' => 'product_id']);
    }

    public function getUserCreatedBy()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'created_by']);
    }

    public function getUserUpdatedBy()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'updated_by']);
    }

    public function getIconPreview()
    {
        if ($this->product_icon_path) {
            $url = Url::base(true).$this->product_icon_base_url.str_replace('\\', '/', $this->product_icon_path);
            return Html::a(Html::img($url,['class' => 'center-block img-responsive']),$url,[
                'data-fancybox' => $this->product_id,
                'class' => 'fancybox',
                'data-caption' => $this->product_id.' '.$this->product_name
            ]);
        }
        return null;
    }
}
