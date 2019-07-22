<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_perforate_option".
 *
 * @property int $perforate_option_id รหัส
 * @property int $perforate_option_id รหัสรูปแบบ
 * @property string $perforate_option_name ชื่อมุมเจาะ
 * @property string $perforate_option_description รายละเอียด
 */
class TblPerforateOption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_perforate_option';
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perforate_option_name'], 'required'],
            [['perforate_option_id', 'perforate_id'], 'integer'],
            [['perforate_option_name','perforate_option_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'perforate_option_id' => 'รหัส',
            'perforate_id' => 'รหัสรูปแบบ',
            'perforate_option_name' => 'ชื่อมุมเจาะ',
            'perforate_option_description' => 'รายละเอียด'
        ];
    }
    
     public function getPerforate ()
    {
        return $this->hasOne(TblPerforate::className(), ['perforate_id' => 'perforate_id']);
    }
    
}
