<?php
namespace common\components;

use common\modules\app\models\TblBookBinding;
use common\modules\app\models\TblCoating;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblDiecut;
use common\modules\app\models\TblFoilColor;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblPerforateOption;
use common\modules\app\models\TblUnit;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 16/10/2562
 * Time: 11:07
 */

class InPutOptions
{
    public static function getOption($attribute)
    {
        $list = [];
        // ขนาด
        if ($attribute == 'paper_size_id') {
            $paperSizes = TblPaperSize::find()->orderBy('paper_size_id ASC')->all();
            $list[] = [
                'id' => 'custom',
                'name' => 'กำหนดเอง',
            ];
            foreach ($paperSizes as $paper) {
                $list[] = [
                    'id' => $paper['paper_size_id'],
                    'name' => $paper['paper_size_name'],
                ];
            }
        }
        // กระดาษ
        if ($attribute == 'paper_id') {
            $papers = TblPaper::find()->orderBy('paper_type_id asc,paper_gram asc')->all();
            foreach ($papers as $paper) {
                $list[] = [
                    'id' => $paper['paper_id'],
                    'name' => $paper['paper_name'],
                ];
            }
        }
        // สีที่พิมพ์
        if ($attribute == 'print_color') {
            $options = TblColorPrinting::find()->all();
            foreach ($options as $option) {
                $list[] = [
                    'id' => $option['color_printing_id'],
                    'name' => $option['color_printing_name'],
                ];
            }
        }
        // เคลือบ
        if ($attribute == 'coating_id') {
            $options = TblCoating::find()->all();
            $list[] = [
                'id' => 'N',
                'name' => 'ไม่เคลือบ',
            ];
            foreach ($options as $option) {
                $list[] = [
                    'id' => $option['coating_id'],
                    'name' => $option['coating_name'],
                ];
            }
        }
        // ไดคัท
        if ($attribute == 'diecut_id') {
            $options = TblDiecut::find()->all();
            foreach ($options as $option) {
                $list[] = [
                    'id' => $option['diecut_id'],
                    'name' => $option['diecut_name'],
                ];
            }
        }
        // พับ
        if ($attribute == 'fold_id') {
            $options = TblFold::find()->orderBy('fold_id  asc')->all();
            $list[] = [
                'id' => 'N',
                'name' => 'ไม่พับ',
            ];
            foreach ($options as $option) {
                $list[] = [
                    'id' => $option['fold_id'],
                    'name' => $option['fold_name'],
                ];
            }
        }
        // สีฟอยล์
        if ($attribute == 'foil_color_id') {
            $options = TblFoilColor::find()->all();
            foreach ($options as $option) {
                $list[] = [
                    'id' => $option['foil_color_id'],
                    'name' => $option['foil_color_name'],
                ];
            }
        }
        // วิธีเข้าเล่ม
        if ($attribute == 'book_binding_id') {
            $options = TblBookBinding::find()->all();
            /* $list[] = [
            'id' => 'N',
            'name' => 'ไม่เข้าเล่ม'
            ]; */
            foreach ($options as $option) {
                $list[] = [
                    'id' => $option['book_binding_id'],
                    'name' => $option['book_binding_name'],
                ];
            }
        }
        // มุมที่เจาะ
        if ($attribute == 'perforate_option_id') {
            $options = TblPerforateOption::find()->all();
            foreach ($options as $option) {
                $list[] = [
                    'id' => $option['perforate_option_id'],
                    'name' => $option['perforate_option_name'],
                ];
            }
        }
        // หน่วย
        if (ArrayHelper::isIn($attribute, ['paper_size_unit', 'emboss_size_unit', 'foil_size_unit', 'window_box_unit'])) {
            $options = TblUnit::find()->where(['unit_id' => [2, 3]])->all();
            foreach ($options as $option) {
                $list[] = [
                    'id' => $option['unit_id'],
                    'name' => $option['unit_name'],
                ];
            }
        }
        // พิมพ์
        if ($attribute == 'print_option') {
            $list = [
                [
                    'id' => 'one_page',
                    'name' => 'พิมพ์หน้าเดียว',
                ],
                [
                    'id' => 'two_page',
                    'name' => 'พิมพ์สองหน้า',
                ],
            ];
        }
        // ร้อยเชือกหูถุง
        if ($attribute == 'rope') {
            $list = [
                [
                    'id' => '0',
                    'name' => 'ไม่ร้อยเชือกหูถุง',
                ],
                [
                    'id' => '1',
                    'name' => 'ร้อยเชือกหูถุง',
                ],
            ];
        }
        // ปั๊มนูน
        if ($attribute == 'emboss_status') {
            $list = [
                [
                    'id' => 'N',
                    'name' => 'ไม่ปั๊มนูน',
                ],
                [
                    'id' => 'Y',
                    'name' => 'ปั๊มนูน',
                ],
            ];
        }
        // ปั๊ม ไม่ปั๊ม
        if ($attribute == 'foil_status') {
            $list = [
                [
                    'id' => 'N',
                    'name' => 'ไม่ปั๊มฟอยล์',
                ],
                [
                    'id' => 'Y',
                    'name' => 'ปั๊มฟอยล์',
                ],
            ];
        }
        // ปะกาว
        if ($attribute == 'glue') {
            $list = [
                [
                    'id' => '0',
                    'name' => 'ไม่ปะ',
                ],
                [
                    'id' => '1',
                    'name' => 'ปะ',
                ],
            ];
        }
        // ปั๊มนูน หน้าหลัง หน้าเดียว
        if ($attribute == 'emboss_print') {
            $list = [
                [
                    'id' => 'two_page',
                    'name' => 'ทั้งหน้า/หลัง',
                ],
                [
                    'id' => 'one_page',
                    'name' => 'หน้าเดียว',
                ],
            ];
        }
        // ปั๊มฟอยล์ หน้าหลัง หน้าเดียว
        if ($attribute == 'foil_print') {
            $list = [
                [
                    'id' => 'two_page',
                    'name' => 'ทั้งหน้า/หลัง',
                ],
                [
                    'id' => 'one_page',
                    'name' => 'หน้าเดียว',
                ],
            ];
        }
        // ไดคัท
        if ($attribute == 'diecut_status') {
            $list = [
                [
                    'id' => 'not-dicut',
                    'name' => 'ไม่ไดคัท',
                ],
                [
                    'id' => 'dicut',
                    'name' => 'ไดคัท',
                ],
                [
                    'id' => 'perforate',
                    'name' => 'ตัดเป็นตัว/เจาะ',
                ],
            ];
        }
        // รูปแบบไดคัท
        if ($attribute == 'diecut') {
            $list = [
                [
                    'id' => 'Default',
                    'name' => 'ไดคัทตามรูปแบบ',
                ],
                [
                    'id' => 'Curve',
                    'name' => 'ไดคัทมุมมน',
                ],
            ];
        }
        // ด้านที่เคลือบ
        if ($attribute == 'coating_option') {
            $list = [
                [
                    'id' => 'one_page',
                    'name' => 'ด้านเดียว',
                ],
                [
                    'id' => 'two_page',
                    'name' => 'สองด้าน',
                ],
            ];
        }
        // ตัด เจาะ
        if ($attribute == 'perforate') {
            $list = [
                [
                    'id' => 0,
                    'name' => 'ตัดเป็นตัวอย่างเดียว',
                ],
                [
                    'id' => 1,
                    'name' => 'ตัดเป็นตัว + เจาะรูกลม',
                ],
            ];
        }
        // แนวตั้ง แนวนอน
        if ($attribute == 'land_orient') {
            $list = [
                [
                    'id' => 1,
                    'name' => 'แนวตั้ง',
                ],
                [
                    'id' => 2,
                    'name' => 'แนวนอน',
                ],
            ];
        }
        // ปรุฉีก
        if ($attribute == 'perforated_ripped') {
            $list = [
                [
                    'id' => 0,
                    'name' => 'ไม่ปรุฉีก',
                ],
                [
                    'id' => 1,
                    'name' => 'ปรุฉีก',
                ],
            ];
        }
        // running number
        if ($attribute == 'running_number') {
            $list = [
                [
                    'id' => 0,
                    'name' => 'ไม่ running number',
                ],
                [
                    'id' => 1,
                    'name' => 'มี running number',
                ],
            ];
        }
        // ติดหน้าต่าง
        if ($attribute == 'window_box') {
            $list = [
                [
                    'id' => 0,
                    'name' => 'ไม่ติดหน้าต่าง',
                ],
                [
                    'id' => 1,
                    'name' => 'ติดหน้าต่าง',
                ],
            ];
        }
        // เข้าเล่ม
        if ($attribute == 'book_binding_status') {
            $list = [
                [
                    'id' => 0,
                    'name' => 'ไม่เข้าเล่ม',
                ],
                [
                    'id' => 1,
                    'name' => 'เข้าเล่ม',
                ],
            ];
        }
        return $list;
    }

    public static function skipAttributes()
    {
        return [
            "quotation_detail_id",
            "quotation_id",
            "product_id",
            "paper_size_width",
            "paper_size_height",
            "paper_size_lenght",
            "paper_size_unit",
            "foil_size_width",
            "foil_size_height",
            "foil_size_unit",
            "foil_color_id",
            "emboss_size_width",
            "emboss_size_height",
            "emboss_size_unit",
            // "book_binding_status",
            "window_box_width",
            "window_box_lenght",
            "window_box_unit",
            "emboss_print",
            "foil_print",
            "coating_option"
        ];
    }

    public static function getAttributeValue($value = "", $options)
    {
        $result = "";
        // if(empty($value)) return "";
        foreach ($options as $key => $option) {
            if($option['id'] == $value) {
                $result = $option['name'];
                break;
            }
        } 
        return $result;
    }
}
