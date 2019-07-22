<?php

namespace common\modules\app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tbl_quotation".
 *
 * @property string $quotation_id เลขที่ใบเสนอราคา
 * @property string $quotation_customer_name ชื่อลูกค้า
 * @property string $quotation_customer_address ที่อยู่
 * @property string $quotation_customer_tel เบอร์โทร
 * @property string $created_at วันที่บันทึก
 * @property string $updated_at วันที่แก้ไข
 */
class TblQuotation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_quotation';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'quotation_id', // required
                'value' => 'QO-' . Yii::$app->formatter->asDate('now', 'php:Ymd') . '?',
                'group' => $this->quotation_id,
                'digit' => 5
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quotation_customer_name', 'quotation_customer_address', 'quotation_customer_tel'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['quotation_id'], 'string', 'max' => 100],
            [['quotation_customer_name', 'quotation_customer_address'], 'string', 'max' => 255],
            [['quotation_customer_tel'], 'string', 'max' => 10],
            [['quotation_customer_fax'], 'string', 'max' => 20],
            [['quotation_customer_email'], 'string', 'max' => 50],
            ['quotation_customer_email', 'email'],
            [['quotation_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quotation_id' => Yii::t('app', 'เลขที่ใบเสนอราคา'),
            'quotation_customer_name' => Yii::t('app', 'ชื่อลูกค้า'),
            'quotation_customer_address' => Yii::t('app', 'ที่อยู่'),
            'quotation_customer_email' => Yii::t('app', 'อีเมล์'),
            'quotation_customer_tel' => Yii::t('app', 'เบอร์โทร'),
            'created_at' => Yii::t('app', 'วันที่บันทึก'),
            'updated_at' => Yii::t('app', 'วันที่แก้ไข'),
            'quotation_customer_fax' => Yii::t('app', 'แฟกซ์')
        ];
    }
}
