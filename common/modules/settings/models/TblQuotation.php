<?php

namespace common\modules\settings\models;

use Yii;

/**
 * This is the model class for table "tbl_quotation".
 *
 * @property string $quotation_id เลขที่ใบเสนอราคา
 * @property int $user_id รหัสลูกค้า
 * @property int $quotation_status_id สถานะ
 * @property string $created_at วันที่บันทึก
 * @property string $updated_at วันที่แก้ไข
 * @property int $created_by ผู้บันทึก
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quotation_id', 'quotation_status_id'], 'required'],
            [['user_id', 'quotation_status_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['quotation_id'], 'string', 'max' => 100],
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
            'user_id' => Yii::t('app', 'รหัสลูกค้า'),
            'quotation_status_id' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'วันที่บันทึก'),
            'updated_at' => Yii::t('app', 'วันที่แก้ไข'),
            'created_by' => Yii::t('app', 'ผู้บันทึก'),
        ];
    }
}
