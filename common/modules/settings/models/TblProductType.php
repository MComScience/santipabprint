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
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "tbl_product_type".
 *
 * @property string $product_type_id รหัสประเภทสินค้า
 * @property string $product_type_name ชื่อประเภทสินค้า
 * @property string $product_img_path ที่อยู่ภาพ
 * @property string $product_img_base_url Url รูปภาพ
 * @property int $created_by ผู้บันทึก
 * @property string $created_at ว/ด/ป ที่บันทึก
 * @property int $updated_by ผู้แก้ไข
 * @property string $updated_at ว/ด/ป ที่แก้ไข
 */
class TblProductType extends \yii\db\ActiveRecord
{
    public $icon;
    public $product_group_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product_type';
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
            'icon-img' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'icon',
                'pathAttribute' => 'product_img_path',
                'baseUrlAttribute' => 'product_img_base_url',
            ],
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'product_type_id', // required
                'value' => 'PT'.'.?' ,
                'group' => $this->product_type_id,
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
            [['product_type_name'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'icon', 'product_group_id'], 'safe'],
            [['product_type_id'], 'string', 'max' => 100],
            [['product_type_name', 'product_img_path', 'product_img_base_url'], 'string', 'max' => 255],
            [['product_type_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_type_id' => Yii::t('app', 'รหัสประเภทสินค้า'),
            'product_type_name' => Yii::t('app', 'ชื่อประเภทสินค้า'),
            'product_img_path' => Yii::t('app', 'ที่อยู่ภาพ'),
            'product_img_base_url' => Yii::t('app', 'Url รูปภาพ'),
            'created_by' => Yii::t('app', 'ผู้บันทึก'),
            'created_at' => Yii::t('app', 'ว/ด/ป ที่บันทึก'),
            'updated_by' => Yii::t('app', 'ผู้แก้ไข'),
            'updated_at' => Yii::t('app', 'ว/ด/ป ที่แก้ไข'),
        ];
    }

    //ประเภทสินค้า 1 ประเภท มีได้หลายกลุ่มสินค้า
    public function getProductGroupTypes()
    {
        return $this->hasMany(TblProductGroupType::className(), ['product_type_id' => 'product_type_id']);
    }

    //สินค้า 1 ประเภท มีสินค้าหลายตัว
    public function getProducts()
    {
        return $this->hasMany(TblProduct::className(), ['product_type_id' => 'product_type_id']);
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
        if ($this->product_img_path) {
            $url = Url::base(true).$this->product_img_base_url.str_replace('\\', '/', $this->product_img_path);
            return Html::a(Html::img($url,['class' => 'center-block img-responsive']),$url,[
                'data-fancybox' => $this->product_type_id,
                'class' => 'fancybox',
                'data-caption' => $this->product_type_id.' '.$this->product_type_name
            ]);
        }
        return null;
    }

    public function productGroupList()
    {
        if ($this->getProductGroupTypes()) {
            $rows = (new \yii\db\Query())
                ->select(['tbl_product_group.*'])
                ->from('tbl_product_group_type')
                ->where(['tbl_product_group_type.product_type_id' => $this->product_type_id])
                ->innerJoin('tbl_product_group', 'tbl_product_group.product_group_id = tbl_product_group_type.product_group_id')
                ->all();
            $groupNames = ArrayHelper::getColumn($rows, 'product_group_name');
            $li = [];
            foreach ($groupNames as $groupName) {
                $li[] = Html::tag('li', $groupName);
            }
            return Html::tag('ul',implode("\n", $li));
        }
    }
}
