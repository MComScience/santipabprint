<?php

namespace common\modules\settings\models;

use common\behaviors\AutonumberBehavior;
use kidz\user\models\Profile;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "tbl_product_group".
 *
 * @property string $product_group_id รหัสกลุ่มสินค้า
 * @property string $product_group_name ชื่อกลุ่ม
 * @property int $created_by ผู้บันทึก
 * @property string $created_at ว/ด/ป ที่บันทึก
 * @property int $updated_by ผู้แก้ไข
 * @property string $updated_at ว/ด/ป ที่แก้ไข
 */
class TblProductGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_product_group';
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
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'product_group_id', // required
                'value' => 'PG'.'.?' ,
                'group' => $this->product_group_id,
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
            [['product_group_name'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_group_id'], 'string', 'max' => 100],
            [['product_group_name'], 'string', 'max' => 255],
            [['product_group_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_group_id' => Yii::t('app', 'รหัสกลุ่มสินค้า'),
            'product_group_name' => Yii::t('app', 'ชื่อกลุ่ม'),
            'created_by' => Yii::t('app', 'ผู้บันทึก'),
            'created_at' => Yii::t('app', 'ว/ด/ป ที่บันทึก'),
            'updated_by' => Yii::t('app', 'ผู้แก้ไข'),
            'updated_at' => Yii::t('app', 'ว/ด/ป ที่แก้ไข'),
        ];
    }

    //ประเภทสินค้า 1 ประเภท มีได้หลายกลุ่มสินค้า
    public function getProductGroupTypes()
    {
        return $this->hasMany(TblProductGroupType::className(), ['product_group_id' => 'product_group_id']);
    }

    public function getUserCreatedBy()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'created_by']);
    }

    public function getUserUpdatedBy()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'updated_by']);
    }
}
