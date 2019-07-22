<?php

namespace common\modules\app\models;

use Yii;

/**
 * This is the model class for table "tbl_package_type".
 *
 * @property int $package_type_id รหัส
 * @property string $product_category_id รหัส
 * @property string $package_type_name ชื่อประเภท
 */
class TblPackageType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_package_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_type_name'], 'required'],
            [['product_category_id'], 'string', 'max' => 100],
            [['package_type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'package_type_id' => 'รหัส',
            'product_category_id' => 'รหัส',
            'package_type_name' => 'ชื่อประเภท',
        ];
    }
}
