<?php

namespace common\modules\settings\models;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;

/**
 * This is the model class for table "tbl_print_options".
 *
 * @property string $print_option_id
 * @property string $print_option_name ชื่อแบบการพิมพ์
 * @property string $print_option_description รายละเอียด
 * @property string $print_img_path ที่อยู่ภาพ
 * @property string $print_img_base_url url รูปภาพ
 * @property string $product_id รหัสสินค้า
 */
class TblPrintOptions extends \yii\db\ActiveRecord
{
    public $img;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_print_options';
    }

    public function behaviors()
    {
        return [
            'file' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'img',
                'pathAttribute' => 'print_img_path',
                'baseUrlAttribute' => 'print_img_base_url',
            ],
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'print_option_id', // required
                'value' => 'P'.'.?' ,
                'group' => $this->print_option_id,
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
            [['print_option_name', 'product_id'], 'required'],
            [['print_option_id', 'product_id'], 'string', 'max' => 100],
            [['print_option_name', 'print_option_description', 'print_img_path', 'print_img_base_url'], 'string', 'max' => 255],
            [['print_option_id'], 'unique'],
            [['img'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'print_option_id' => Yii::t('app', 'Print Option ID'),
            'print_option_name' => Yii::t('app', 'ชื่อแบบการพิมพ์'),
            'print_option_description' => Yii::t('app', 'รายละเอียด'),
            'print_img_path' => Yii::t('app', 'ที่อยู่ภาพ'),
            'print_img_base_url' => Yii::t('app', 'url รูปภาพ'),
            'product_id' => Yii::t('app', 'รหัสสินค้า'),
        ];
    }

    //สินค้า
    public function getProduct()
    {
        return $this->hasOne(TblProduct::className(), ['product_id' => 'product_id']);
    }
}
