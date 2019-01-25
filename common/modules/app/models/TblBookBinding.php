<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_book_binding".
 *
 * @property string $book_binding_id รหัส
 * @property string $book_binding_name วิธีเข้าเล่ม
 * @property string $book_binding_description รายละเอียด
 */
class TblBookBinding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_book_binding';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'book_binding_id', // required
                'value' => 'BD-'.'?' ,
                'group' => $this->book_binding_id,
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
            [['book_binding_name'], 'required'],
            [['book_binding_id'], 'string', 'max' => 100],
            [['book_binding_name', 'book_binding_description'], 'string', 'max' => 255],
            [['book_binding_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_binding_id' => Yii::t('app', 'รหัส'),
            'book_binding_name' => Yii::t('app', 'วิธีเข้าเล่ม'),
            'book_binding_description' => Yii::t('app', 'รายละเอียด'),
        ];
    }
}
