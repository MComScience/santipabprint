<?php

namespace common\modules\app\models;

use adminlte\helpers\Html;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use common\models\FileAttachment;
use common\behaviors\FileUploadBehavior;

/**
 * This is the model class for table "tbl_product".
 *
 * @property string $product_id รหัสสินค้า
 * @property string $product_category_id รหัสหมวดหมู่
 * @property string $product_name ชื่อสินค้า
 * @property string $product_options ตัวเลือก
 * @property string $product_image_path ที่อยู่รูปภาพ
 * @property string $product_image_base_url ลิงค์ภาพ
 * @property int $created_by ผู้บันทึก
 * @property string $created_at วันที่บันทึก
 * @property int $updated_by ผู้แก้ไข
 * @property string $updated_at วันที่แก้ไข
 */
class TblProduct extends \yii\db\ActiveRecord
{
    public $icon;
    public $files;

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
                'pathAttribute' => 'product_image_path',
                'baseUrlAttribute' => 'product_image_base_url',
            ],
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'product_id', // required
                'value' => 'P-' . Yii::$app->formatter->asDate('now', 'php:Ymd') . '?',
                'group' => $this->product_id,
                'digit' => 5
            ],
            'files' => [
                'class' => FileUploadBehavior::className(),
                'filesStorage' => 'fileStorage', // my custom fileStorage from configuration(for properly remove the file from disk)
                'multiple' => true,
                'attribute' => 'files',
                'uploadRelation' => 'fileAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
                'orderAttribute' => 'order',
                'ref_id' => 'product_id',
                'ref_table_name' => 'tbl_product',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_category_id', 'product_name'], 'required'],
            [['product_category_id', 'package_type_id', 'created_by', 'updated_by'], 'integer'],
            [['product_description', 'product_options'], 'string'],
            [['created_at', 'updated_at', 'icon', 'files'], 'safe'],
            [['product_id'], 'string', 'max' => 100],
            [['product_name', 'product_image_path', 'product_image_base_url'], 'string', 'max' => 255],
            [['product_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'รหัสสินค้า',
            'product_category_id' => 'รหัสหมวดหมู่',
            'product_name' => 'ชื่อสินค้า',
            'package_type_id' => 'ประเภทสินค้า',
            'product_description' => 'รายละเอียด',
            'product_options' => 'ตัวเลือก',
            'product_image_path' => 'ที่อยู่รูปภาพ',
            'product_image_base_url' => 'ลิงค์ภาพ',
            'created_by' => 'ผู้บันทึก',
            'created_at' => 'วันที่บันทึก',
            'updated_by' => 'ผู้แก้ไข',
            'updated_at' => 'วันที่แก้ไข',
        ];
    }
   //ประเภทสินค้า
     public function getPackageType()
    {
        return $this->hasOne(TblPackageType::className(), ['package_type_id' => 'package_type_id']);
    }

    //กลุ่มสินค้า
    public function getProductCategory()
    {
        return $this->hasOne(TblProductCategory::className(), ['product_category_id' => 'product_category_id']);
    }

    public function getProductOption()
    {
        return $this->hasOne(TblProductOption::className(), ['product_id' => 'product_id']);
    }

    public function getOptions()
    {
        $options = [];
        if (!$this->isNewRecord && !empty($this->product_options)){
            $options = Json::decode($this->product_options);
        }
        return $options;
    }

    public function getOptionsValue($key)
    {
        $options = $this->getOptions();
        return ArrayHelper::getValue($options, $key, null);
    }

    public static function isChecked($productOption, $value, $field)
    {
        $checked = false;
        if (!empty($productOption) && isset($productOption[$field]) && !empty($productOption[$field])){
            $options = Json::decode($productOption[$field]);
            if (ArrayHelper::isIn($value, $options)){
                $checked = !$checked;
            }
        }
        return $checked;
    }

    public function getOptionValue($index, $field, $default = '')
    {
        if (!$this->isNewRecord){
            $option = $this->getOptionsValue($index);
            if ($option && isset($option[$field])){
                return $option[$field];
            }
        }
        return $default;
    }

    public function getImageUrl()
    {
        $urlBuilder = Yii::$app->glide->urlBuilder;
        if (!empty($this->product_image_path)){
            // $path = $urlBuilder->getUrl($this->product_image_base_url.str_replace('\\', '/', $this->product_image_path), []);
            return $this->product_image_base_url.str_replace('\\', '/', $this->product_image_path);
            //Url::to(['/glide', 'path' => $this->product_image_base_url.str_replace('\\', '/', $this->product_image_path)]);
        }
        return Yii::getAlias('@web/images/No_Image_Available.png');
        //return Url::to(['/glide', 'path' => 'images/No_Image_Available.png']);
        // return $urlBuilder->getUrl('images/No_Image_Available.png', []);
    }

    public function getPreviewIcon()
    {
        if ($this->product_image_path) {
            $url = $this->getImageUrl();
            return Html::a(Html::img($url,['class' => 'center-block img-responsive']),$url,[
                'data-fancybox' => $this->product_id,
                'class' => 'fancybox',
                'data-caption' => $this->product_id.' '.$this->product_name
            ]);
        }
        return null;
    }

    public function getToggleClass($key)
    {
        $options = [
            'diecut' => 'tab-diecut',
            'before_print' => 'tab-print-one-page',
            'after_print' => 'tab-print-two-page',
            'coating' => 'tab-coating',
            'fold' => 'tab-fold',
            'foil' => 'tab-foil-color',
            'book_binding' => 'tab-book-binding',
            'print_two_page' => '',
            'print_one_page' => ''
        ];
        return ArrayHelper::getValue($options, $key, '');
    }

    public function getfileAttachments() {
        return $this->hasMany(FileAttachment::className(), ['ref_id' => 'product_id'])
                        ->andOnCondition(['ref_table_name' => 'tbl_product']);
    }
}
