<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_fold".
 *
 * @property string $fold_id รหัส
 * @property string $fold_name วิธีพับ
 * @property string $fold_description รายละเอียด
 */
class TblFold extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_fold';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'fold_id', // required
                'value' => 'FOLD-'.'?' ,
                'group' => $this->fold_id,
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
            [['fold_name','fold_count'], 'required'],
            [['fold_id'], 'string', 'max' => 100],
            [['fold_name', 'fold_description'], 'string', 'max' => 255],
            [['fold_count'], 'integer'],
            [['fold_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fold_id' => Yii::t('app', 'รหัส'),
            'fold_name' => Yii::t('app', 'วิธีพับ'),
            'fold_count' => Yii::t('app', 'Fold Count'),
            'fold_description' => Yii::t('app', 'รายละเอียด'),
        ];
    }
}
