<?php
namespace common\modules\app\models;

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 15/10/2562
 * Time: 13:58
 */
use Yii;
use yii\base\Model;

class DynamicSettingModel extends Model
{
    public $field_name;
    public $field_label;
    public $field_option;
    public $field_option_values;
    public $field_default_value;
    public $filed_active;
    public $field_order;

    public function attributeLabels()
    {
        return [
            'field_name' => 'ตัวเลือก',
            'field_label' => 'ชื่อตัวเลือก',
            'field_option' => 'หมวดตัวเลือก',
            'field_option_values' => 'ข้อมูลตัวเลือก',
            'field_default_value' => 'ตัวเลือก Default',
            'filed_active' => 'isActive',
            'field_order' => 'ลำดับ'
        ];
    }
}