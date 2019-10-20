<?php

namespace common\modules\app\models;

use Yii;
use trntv\filekit\behaviors\UploadBehavior;
/**
 * This is the model class for table "tbl_product_category".
 *
 * @property int $product_category_id รหัส
 * @property string $product_category_name หมวดหมู่
 * @property string $image_path ที่อยู่รูปภาพ
 * @property string $image_base_url ลิงค์ภาพ
 * @property int $product_category_order ลำดับ
 */
class TblProductCategory extends \yii\db\ActiveRecord
{
    public $icon;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product_category';
    }

    public function behaviors()
    {
        return [
            /* [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'product_category_id', // required
                'value' => 'PC-'.'?' ,
                'group' => $this->product_category_id,
                'digit' => 5
            ], */
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
            [['product_category_name'], 'required'],
            [['product_category_order'], 'integer'],
            [['product_category_name', 'image_path', 'image_base_url'], 'string', 'max' => 255],
            [['icon'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_category_id' => 'รหัส',
            'product_category_name' => 'หมวดหมู่',
            'image_path' => 'ที่อยู่รูปภาพ',
            'image_base_url' => 'ลิงค์ภาพ',
            'product_category_order' => 'ลำดับ',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TblProductCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TblProductCategoryQuery(get_called_class());
    }

    public function getImageUrl()
    {
        if($this->image_path){
            return Yii::getAlias('@web'.$this->image_base_url.(str_replace('\\', '/', $this->image_path)));
        } else {
            return Yii::getAlias('@web/images/No_Image_Available.png');
        }
    }
}
