<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_perforate".
 *
 * @property int $perforate_id รหัสรูปแบบป้ายtag/ที่คั่นหนังสือ
 * @property string $perforate_name ชื่อรูปแบบ
 */
class TblPerforate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_perforate';
    }
   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perforate_name'], 'required'],
            [['perforate_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'perforate_id' => 'รหัสรูปแบบป้ายtag/ที่คั่นหนังสือ',
            'perforate_name' => 'ชื่อรูปแบบ',
        ];
    }
    
    public function getPerforateOptions()
    {
        return $this->hasMany(TblPerforateOption::className(), ['perforate_id' => 'perforate_id']);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        TblPerforateOption::deleteAll(['perforate_id' => $this->perforate_id]);
    }
}
