<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/1/2562
 * Time: 21:35
 */
namespace common\modules\app\models;

use yii\base\Model;

class Options extends Model
{
    public $paper_size;
    public $diecut;
    public $before_print;
    public $after_print;
    public $coating;
    public $fold;
    public $foil;
    public $book_binding;
    public $embossing;
    public $page_qty;
    public $land_orient;
    public $print_two_page;
    public $print_one_page;
    public $label;
    public $required;
    public $value;

    public function attributeLabels()
    {
        return [
            'paper_size' => 'ขนาด',
            'diecut' => 'ไดคัท',
            'before_print' => 'ด้านหน้าพิมพ์',
            'after_print' => 'ด้านหลังพิมพ์',
            'coating' => 'เคลือบ',
            'fold' => 'วิธีพับ',
            'foil' => 'สีฟอยล์',
            'book_binding' => 'เข้าเล่ม',
            'embossing' => 'ปั๊มนูน',
            'page_qty' => 'จำนวนหน้า/แผ่น',
            'land_orient' => 'แนวตั้ง/แนวนอน',
            'print_two_page' => 'พิมพ์หน้าหลัง',
            'print_one_page' => 'พิมพ์หน้าเดียว',
            'required' => 'บังคับ'
        ];
    }
}