<?php

namespace common\components;

use Yii;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CalculetFnc {

    //แปลงหน่วย นิ้ว เป็น เซนติเมตร
    public static function convertInToCm($size) {
        $result = $size * 2.54;
        return Yii::$app->formatter->format($result, ['decimal', 2]);
    }

    public static function convertCmToIn($size) { ////เซนติเมตรเป็นนิ้ว
        $result = $size * 0.4; 
        return Yii::$app->formatter->format($result, ['decimal', 2]);
    }

    //เช็คเงื่อนไข แปลงค่าหน่วยกระดาษที่รับค่าจากหน้าจอ
    public static function calculateWidthLength($fold, $paper_size_unit, $width, $length) {
        /*
          $fold = พับ
          $paper_size_unit = หน่วยกระดาษ
          $width = ขนาดความกว้าง ที่รับค่าจากหน้าจอ
          $length = ขนาดความยาว ที่รับค่าจากหน้าจอ
         */
        if ($fold === 'FOLD-00001') { //เช็คว่าถ้ามีการพับครึ่ง
            $width = $width * 2;
        }
        $width = $width + 0.6;
        $length = $length + 0.6;
        return [
            'width' => Yii::$app->formatter->format($width, ['decimal', 2]),
            'length' => Yii::$app->formatter->format($length, ['decimal', 2]),
        ];
    }

    public static function calculateVerticalLayWidth($print_area_width, $size_width_cal, $print_area_length, $size_length_cal) {
        $vertical_lay_width = $print_area_width / $size_width_cal;
        $vertical_lay_length = $print_area_length / $size_length_cal;
        return (int) $vertical_lay_width * (int) $vertical_lay_length;
    }

    public static function calculateHorizonLayWidth($print_area_width, $size_width_cal, $print_area_length, $size_length_cal) {
        $horizon_lay_width = $print_area_width / $size_length_cal;
        $horizon_lay_length = $print_area_length / $size_width_cal;
        return (int) $horizon_lay_width * (int) $horizon_lay_length;
    }

    public static function calculateCoatingPrice($coating_prices, $coaing_id, $sq, $cal_print_sheet_total) { //คำนวนราคาเคลือบ
        $laminate_price = 0;
        foreach ($coating_prices as $key => $coating_price) {
            if ($sq <= $coating_price['coating_sq_in']) { //ขนาดกระดาษที่หาได้ไม่เกินขนาดในฐานข้อมูล
                switch ($coaing_id) {
                    case "C-00001"://เคลือบ pvc ด้าน
                        $laminate_price = $coating_price['coating_matte_price'] * $cal_print_sheet_total;
                        break;
                    case "C-00002": //เคลือบ pvc เงา
                        $laminate_price = $coating_price['coating_varnish_price'] * $cal_print_sheet_total;
                        break;
                    case "C-00003": //เคลือบ  UV
                        $laminate_price = $coating_price['coating_uv_price'] * $cal_print_sheet_total;
                        break;
                    default:
                        $laminate_price = 0;
                }
                break;
            }
        }
        return $laminate_price;
    }

    public static function calculateBlockFoil($block_prices, $sqFoilSize) {
        $block_foil_price = 0;
        foreach ($block_prices as $key => $block_price) {
            if ($sqFoilSize <= $block_price['emboss_price_size']) {
                $block_foil_price = $block_price['emboss_price'];
                break;
            }
        }
        return $block_foil_price;
    }

    public static function calculateBlockEmboss($emboss_prices, $sqeEbossSize) {
        $block_emboss_price = 0;
        foreach ($emboss_prices as $key => $emboss_price) {
            if ($sqeEbossSize <= $emboss_price['emboss_price_size']) {
                $block_emboss_price = $emboss_price['emboss_price'];
                break;
            }
        }
        return $block_emboss_price;
    }

    public static function calculateDicutCurveDigital($params) {
        if ($params['cust_quantity'] <= 1000) {  //ถ้าจำนวนแผ่นพิมพ์น้อยกว่า 1000 ชิ้น 
            $curve = $params['curve'];
            // foreach ($params['diecut_curves'] as $key => $diecut_curve) {
            //     if($diecut_curve['diecut_group_id'] == $params['dicut_id']){
            //         $curve = $diecut_curve;
            //     }
            // }
            $curve_count = $curve['diecut_group_value'];
            $params['dicut_price'] = $params['cust_quantity'] * 0.25 * $curve_count;
        }
        return [
            'block_dicut_price' => $params['block_dicut_price'],
            'dicut_price' => $params['dicut_price']
        ];
    }

    public static function calculateDicutDefaultDigital($params) {
        if ($params['isSticker'] && $params['cal_print_sheet_total'] < 100) {//ตรวจก่อนว่าเป็นสติกเกอร์ที่มีจำนวนน้อยกว่า 100 แผ่นหรือไม่
            if ($params['job_per_sheet'] < 30) {
                $params['dicut_price'] = $params['cal_print_sheet_total'] * 10; //จำนวนงานน้อยกว่า 30 ไดคัทแผ่นละ 10 บาท
            } else {
                $params['dicut_price'] = $params['cal_print_sheet_total'] * 20; //จำนวนงานมากกว่า 30 คิดแผ่นละ 20 บาท
            }
        } else if ($params['isSticker'] || $params['cal_print_sheet_total'] > 100) {//เป็นสติกเกอร์ที่มีจำนวนมากกว่า 100 แผ่น
            $params['print_sheet_total'] = $params['print_sheet_total'] + 5; //ต้องมีการเผื่อกระดาษ 5 แผ่น
            $params['block_dicut_price'] = 800; //ค่าบล๊อก
            $params['dicut_price'] = ($params['cal_print_sheet_total'] * 3) * 0.3;

            if ($params['dicut_price'] < 300) { //ราคาขั้นต่ำ
                $params['dicut_price'] = 300;
            }
            $params['dicut_price'] = $params['block_dicut_price'] + $params['dicut_price']; //ราคาบล๊อก + ราคาไดคัท
        } else if (!$params['isSticker'] && $params['cal_print_sheet_total'] < 100) {//ไม่ใช่สติกเกอร์และมีกระดาษน้อยกว่า 100 แผ่น
            $params['print_sheet_total'] = $params['print_sheet_total'] + 5; //ต้องมีการเผื่อกระดาษ 5 แผ่น
            $params['block_dicut_price'] = 800; //ค่าบล๊อก
            $params['dicut_price'] = $params['cal_print_sheet_total'] * 0.3;

            if ($params['dicut_price'] < 300) { //ราคาขั้นต่ำ
                $params['dicut_price'] = 300;
            }
            $params['dicut_price'] = $params['block_dicut_price'] + $params['dicut_price']; //ราคาบล๊อก + ราคาไดคัท
        }
        return $params;
    }

    //===========================5/7/2562================================//

    public static function calculatePrintSheetTotal($print_sheet_total, $total_1, $total_2) {
        if ($print_sheet_total < 2000) {
            $print_sheet_total = $print_sheet_total + $total_1; // บวกเผื่อกระดาษ (เริ่มต้นที่ 20 ใบ)
        } else {
            //บวกเพิ่ม 20 ใบ ทุก ๆ 1000 แผ่นพิมพ์
            $for_paper = ($print_sheet_total / 1000) - 1;
            $print_sheet_total = ($total_2 * (int) $for_paper);
        }
        return $print_sheet_total;
    }

    public static function calculateDicutDefaultOffset($params) {
        if ($params['isSticker'] && $params['cal_print_sheet_total'] < 100) {//ตรวจก่อนว่าเป็นสติกเกอร์ที่มีจำนวนน้อยกว่า 100 แผ่นหรือไม่
            if ($params['job_per_sheet'] < 30) {
                $params['dicut_price'] = $params['cal_print_sheet_total'] * 10; //จำนวนงานน้อยกว่า 30 ไดคัทแผ่นละ 10 บาท
            } else {
                $params['dicut_price'] = $params['cal_print_sheet_total'] * 20; //จำนวนงานมากกว่า 30 คิดแผ่นละ 20 บาท
            }
        } else if ($params['isSticker'] && $params['cal_print_sheet_total'] > 100) {//เป็นสติกเกอร์ที่มีจำนวนมากกว่า 100 แผ่น
            $params['print_sheet_total'] = $params['print_sheet_total'] + 5; //ต้องมีการเผื่อกระดาษ 5 แผ่น
            $params['block_dicut_price'] = 7.5; //ค่าบล๊อกต่อตารางนิ้ว
            $params['dicut_price'] = ($params['cal_print_sheet_total'] * 3) * 0.3;
            if ($params['dicut_price'] < 300) { //ราคาขั้นต่ำ
                $params['dicut_price'] = 300;
            }
            $params['dicut_price'] = $params['block_dicut_price'] + $params['dicut_price']; //ราคาบล๊อก + ราคาไดคัท
        } else if (!$params['isSticker'] && $params['cal_print_sheet_total'] < 100) {//ไม่ใช่สติกเกอร์และมีกระดาษน้อยกว่า 100 แผ่น
            $params['print_sheet_total'] = $params['print_sheet_total'] + 5; //ต้องมีการเผื่อกระดาษ 5 แผ่น
            $params['block_dicut_price'] = 7.5; //ค่าบล๊อกต่อตารางนิ้ว
            $params['dicut_price'] = $params['cal_print_sheet_total'] * 0.3;
            if ($params['dicut_price'] < 300) { //ราคาขั้นต่ำ
                $params['dicut_price'] = 300;
            }
            $params['dicut_price'] = $params['block_dicut_price'] + $params['dicut_price']; //ราคาบล๊อก + ราคาไดคัท
        }
        return $params;
    }

    public static function calculatePricePlace($w, $l, $isFourColor, $oneColors) {
        $price = 0;
        if ($isFourColor) { // งาน 4 สี
            // ขนาดไม่เกิน 21*29 นิ้ว
            if ($w <= 21 && $l <= 29) {
                // ขนาดไม่เกิน 18*25
                if ($w <= 18 && $l <= 25) {
                    $price = 2000;
                } else {
                    $price = 3000;
                }
            } else {
                $price = 4000;
            }
        } else {// งาน 2 สี หรือ 1 สี 
            // ขนาดไม่เกิน 18*25 นิ้ว
            if ($w <= 18 && $l <= 25) { // ถ้าเป็นงาน 1 สี
                if ($oneColors) {
                    $price = 500;
                } else {
                    $price = 1000;
                }
            } else {
                // ขนาดไม่เกิน 21*29 นิ้ว
                if ($w <= 21 && $l <= 29) {
                    if ($oneColors) {
                        $price = 750;
                    } else {
                        $price = 1500;
                    }
                } else {
                    if ($oneColors) {
                        $price = 1000;
                    } else {
                        $price = 2000;
                    }
                }
            }
        }
        return $price;
    }

}
