<?php

namespace common\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblPaperSize;
use common\components\CalculetFnc;
use common\modules\app\models\TblPaperCut;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblPaperType;
use common\modules\settings\models\TblCoatingPrice;
use common\modules\settings\models\TblEmbossPrice;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblPrintPrice;
use common\modules\app\models\TblProduct;
use yii\helpers\Json;
use Yii;

class CalculateOffset extends Component {

    public $model;
    public $paperWidth = 0;
    public $paperLenght = 0;
    private $paper;
    public $oneColors = false; // งาน 1 สี
    public $twoColors = false; // งาน 2 สี
    public $fourColors = false; // งาน 4 สี
    public $isSticker = false; //สติ๊กเกอร์
    public $paper_type;
    // หาจำนวนชิ้นงานที่วางได้ใน 1 ใบพิมพ์ 
    public $paper_cut = 0;  //กระดาษตัด 
    public $job_per_sheet = 0; //จำนวนแผ่นพิมพ์
    public $print_area_width = 0; //ขนาดความกว้างกระดาษ
    public $print_area_length = 0; //ขนาดความยาวกระดาษ
    public $paper_size = 0; //ขนาดไซส์กระดาษ
    //จำนวนแผ่นพิมพ์
    public $print_sheet_total = 0; //จำนวนแผ่นพิมพ์ที่หาได้
    public $cal_print_sheet_total = 0; //จำนวนแผ่นพิมพ์ที่ยังไม่เผื่อ(นำไปคำนวน)
    public $messages = '';
    public $flod_detail = [];

    public function init() {
        parent::init();
        if ($this->model) {
            $this->paper_type = TblPaper::findOne($this->model['paper_id']); //ประเภทกระดาษ
            $this->checkPaperSize();
            $this->checkPrintingColor();
            $this->findJobPerSheet();
            $this->findCoating();
            $this->findFoilPrice();
            $this->findEmbossPrice();
            $this->findFlod();
            $this->findDicutPrice();
            $this->findGluePrice();
            $this->findPrintingColorPrice();
            $this->findPrintingPrice();
            $this->findPaperBigsheet();
            $this->findPlacePrice();
            $this->summaryPrice();
        }
    }

    //ตรวจสอบพิมพ์งานกี่สี
    public function checkPrintingColor() {
        if (!empty($this->model['before_print'])) {
            $colorPrinting = TblColorPrinting::findOne($this->model['before_print']);
        }
        if (!empty($this->model['after_print'])) {
            $colorPrinting = TblColorPrinting::findOne($this->model['after_print']);
        }
        switch ($colorPrinting['color_printing_id']) {
            case 'PT-00005': //1 สี สีดำ
                $this->oneColors = true;
                break;
            case 'PT-00006': // 1 สี ไม่ใช่สีดำ
                $this->oneColors = true;
                break;
            case 'PT-00007': //  2 สี
                $this->twoColors = true;
                break;
            case 'PT-00008': // 4 สี
                $this->fourColors = true;
                break;
        }
    }

    public function checkPaperSize() {
        $messages = $this->messages;
        $messages .= '===== หาขนาดกระดาษที่จะนำไปคำนวณ =====';
        $product = TblProduct::findOne($this->model['product_id']);
        if ($this->model['paper_size_id'] == 'custom') { // กำหนดเอง
            $messages .= '-:เป็นขนาดกำหนดเอง\n';
            //สินค้าเป็นประเภทกล่อง อยู่ในกลุ่มสินค้าบรรจุภัณฑ์
            $is_box = false;
            if ($product['package_type_id'] == 21 && $product['product_category_id'] == 'PC-00011') {
                $is_box = true;
            }
            //ขนาดสินค้า รับค่าจากหน้าจอ มีหน่วยเป็นนิ้ว
            if ($this->model['paper_size_unit'] == 3) {
                $messages .= "-:รับขนาดมาเป็นนิ้ว {$this->model['paper_size_width']} x {$this->model['paper_size_height']} นิ้ว\n";

                if ($is_box) {
                    $paperWidth = CalculetFnc::convertInToCm($this->model['paper_size_width']); //กว้าง
                    $paperLenght = CalculetFnc::convertInToCm($this->model['paper_size_height']); // ยาว
                    $paperHight = CalculetFnc::convertInToCm($this->model['paper_height']); // สูง

                    $this->paperWidth = (($paperWidth * 2) + ($paperLenght * 2)) + 0.635; //ความกว้าง = (กว้าง * 2 (2ด้าน))+(ความยาว * 2 (2ด้าน)) + 0.635 เผื่ดติดกาว(แปลงจาก0.25นิ้ว) 
                    $this->paperLenght = $paperHight + ($paperWidth * 2) + 1.27; //ความยาว = ความสูง + (ความกว้าง*2) + 1.27 ส่วนพับ(แปลงจาก 0.5 นิ้ว)
                } else {
                    $this->paperWidth = CalculetFnc::convertInToCm($this->model['paper_size_width']);
                    $this->paperLenght = CalculetFnc::convertInToCm($this->model['paper_size_height']);
                }
                //
                $messages .= "-:แปลงขนาดจากนิ้วเป็นเซนติเมตร ได้ขนาด {$this->paperWidth} x {$this->paperLenght}";
            } else {
                $messages .= "-:รับขนาดมา {$this->model['paper_size_width']} x {$this->model['paper_size_height']} เซนติเมตร\n";
                
                 if ($is_box) {
                    $paperWidth = $this->model['paper_size_width']; //กว้าง
                    $paperLenght = $this->model['paper_size_height']; // ยาว
                    $paperHight = $this->model['paper_height']; // สูง

                    $this->paperWidth = (($paperWidth * 2) + ($paperLenght * 2)) + 0.635;
                    $this->paperLenght = $paperHight + ($paperWidth * 2) + 1.27;
                }else{
                    $this->paperWidth = $this->model['paper_size_width'];
                    $this->paperLenght = $this->model['paper_size_height'];
                }
            }
            if ($this->model['fold_id'] === 'FOLD-00001') { //เช็คว่าถ้ามีการพับครึ่ง
                $messages .= "-:มีการพับครึ่ง\n";
            }
            $messages .= '-:บวก 0.3 เซนติเมตร\n';
            $sizes = CalculetFnc::calculateWidthLength($this->model['fold_id'], $this->model['paper_size_unit'], $this->paperWidth, $this->paperLenght);
            $this->paperWidth = $sizes['width'];
            $this->paperLenght = $sizes['length'];
            //
            $messages .= "-:เช็คเงื่อนไข แปลงค่าหน่วยกระดาษที่รับค่าจากหน้าจอได้ขนาด {$this->paperWidth} x {$this->paperLenght}\n";
        } else {
            $messages .= "-:เป็นขนาดจากฐานข้อมูล\n";

            //หาขนาดกระดาษจากฐานข้อมูล
            $paper = TblPaperSize::findOne($this->model['paper_size_id']);

            $messages .= "-:ขนาดกระดาษ " . Json::encode($paper);
            if ($paper['paper_unit_id'] == 3) { //ขนาดเป็น นิ้ว
                $messages .= "-:ขนาดเป็นนิ้ว {$paper->paper_size_width} x {$paper->paper_size_height} นิ้ว\n";

                $this->paperWidth = CalculetFnc::convertInToCm($paper['paper_size_width']);
                $this->paperLenght = CalculetFnc::convertInToCm($paper['paper_size_height']);

                $messages .= "-:แปลงขนาดจากนิ้วเป็นเซนติเมตร จาก {$paper->paper_size_width} x {$paper->paper_size_height} นิ้ว ได้ขนาด {$this->paperWidth} x {$this->paperLenght} เซนติเมตร";
            } else {
                $messages .= "-:ขนาดไม่ใช่นิ้ว {$paper->paper_size_width} x {$paper->paper_size_height} นิ้ว\n";

                $this->paperWidth = $paper['paper_size_width'];
                $this->paperLenght = $paper['paper_size_height'];
            }


            $sizes = CalculetFnc::calculateWidthLength($this->model['fold_id'], $this->model['paper_size_id'], $this->paperWidth, $this->paperLenght);
            $this->paperWidth = $sizes['width'];
            $this->paperLenght = $sizes['length'];
            if ($this->model['fold_id'] === 'FOLD-00001') { //เช็คว่าถ้ามีการพับครึ่ง
                $messages .= "-:มีการพับครึ่ง นำความกว้างไปคูณ 2\n";
            }
            $messages .= '-:บวก 0.3 เซนติเมตร\n';
            $messages .= "-:เช็คเงื่อนไข แปลงค่าหน่วยกระดาษที่รับค่าจากหน้าจอได้ขนาด {$this->paperWidth} x {$this->paperLenght}\n";
        }
        $this->messages = $messages;
    }

    public $job_per_sheets = [];

    public function findJobPerSheet() {
        $messages = $this->messages;
        $messages .= '===== หาการวางชิ้นงานที่ได้จำนวนเยอะที่สุด =====';

        $model = $this->model;
        $paper = TblPaper::findOne($model['paper_id']);
        $messages .= "-:กระดาษ " . Json::encode($paper);

        $paperType = TblPaperType::findOne($paper['paper_type_id']);
        $messages .= "-:ประเภทกระดาษ " . Json::encode($paperType);
        $per_sheets = [];

        if ($paperType['paper_type_flag'] == 1) { //เป็นสติ๊กเกอร์
            $this->isSticker = true;
            $messages .= "-:เป็นสติ๊กเกอร์\n";
        }
        $calPapers = []; //ขนาดกระดาษที่นำไปคำนวน

        if ($this->isSticker) {//เป็นสติ๊กเกอร์
            $calPapers = TblPaperCut::find()->where(['paper_type' => 'offset', 'paper_sticker' => 1])->all();
            $messages .= "-:ใช้กระดาษประเภทสติ๊กเกอร์\n" . Json::encode($calPapers);
        } else {
            $calPapers = TblPaperCut::find()->where(['paper_type' => 'offset', 'paper_sticker' => 0])->all();
            $messages .= "-:ใช้กระดาษปกติ\n" . Json::encode($calPapers);
        }
        $job_per_sheets = [];
        foreach ($calPapers as $calPaper) {
            //แปลงหน่วยความกว้าง จาก นิ้วเป็นเซนติเมตร
            $paper_print_area_width = CalculetFnc::convertInToCm($calPaper['paper_print_area_width']); //ความกว้าง
            //แปลงหน่วยความยาว จาก นิ้วเป็นเซนติเมตร
            $paper_print_area_length = CalculetFnc::convertInToCm($calPaper['paper_print_area_length']); //ความยาว
            //หาจำนวนชิ้นงานแนวตั้ง
            $vertical_lay_total = CalculetFnc::calculateVerticalLayWidth($paper_print_area_width, $this->paperWidth, $paper_print_area_length, $this->paperLenght);  //แนวตั้ง
            //หาจำนวนชิ้นงานแนวนอน
            $horizon_lay_total = CalculetFnc::calculateHorizonLayWidth($paper_print_area_width, $this->paperWidth, $paper_print_area_length, $this->paperLenght); //แนวนอน
            //ขนาดกระดาษจากฐานข้อมูล = กว้าง x ยาว (นิ้ว)
            $size = $calPaper['paper_print_area_width'] * $calPaper['paper_print_area_length'];
            // หาการวางงานที่ได้จำนวนเยอะที่สุด
            $job_per_sheet = 0;
            if ($vertical_lay_total > $horizon_lay_total) { //ถ้ากระดาษแนวตั้งมากกว่าแนวนอน ให้ใช้ขนาดแนวตั้ง
                $job_per_sheet = (int) $vertical_lay_total;
            } else {
                $job_per_sheet = (int) $horizon_lay_total;  //ถ้ากระดาษแนวตั้งน้อยกว่าแนวนอน ให้ใช้ขนาดแนวนอน
            }
            $job_per_sheets[] = [
                'job_per_sheet' => $job_per_sheet,
                'size' => $size,
                'paper_size_id' => $calPaper['paper_size_id'],
                'paper_cut' => $calPaper['paper_cut'],
                'paper_print_area_width' => $calPaper['paper_print_area_width'],
                'paper_print_area_length' => $calPaper['paper_print_area_length'],
                'paper_print_area_width_cm' => $paper_print_area_width,
                'paper_print_area_length_cm' => $paper_print_area_length,
                'paper_size' => $calPaper['paper_size'],
                'paper_type' => $calPaper['paper_type'],
                'paper_sticker' => $calPaper['paper_sticker'],
            ];
        }
        $this->job_per_sheets = $job_per_sheets;
        ArrayHelper::multisort($per_sheets, ['job_per_sheet', 'job_per_sheet'], [SORT_ASC, SORT_ASC]);
        $per_sheets = ArrayHelper::getColumn($job_per_sheets, 'job_per_sheet');

        // หาจำนวนชิ้นงานที่มีค่ามากสุด
        $max_per_sheet = max($per_sheets);


        //หาค่าที่ซ้ำกัน
        $duplicates = [];
        foreach (array_count_values($per_sheets) as $val => $per_sheet) {
            if ($per_sheet > 1) {
                $duplicates[] = $val;
            }
        }

        //ตรวจสอบหาชิ้นงานที่มีค่ามากสุด ในกลุ่มชิ้นงาน
        if (count($duplicates) > 0 && in_array($max_per_sheet, $duplicates)) {
            $papers = [];
            foreach ($job_per_sheets as $key => $job_per_sheet) {
                if ($job_per_sheet['job_per_sheet'] == $max_per_sheet) {
                    $papers[] = $job_per_sheet;
                }
            }

            //หา size กระดาษ
            $paper_sizes = ArrayHelper::getColumn($papers, 'size');
            // หาค่ากระดาษ size เล็กสุด
            $min_size = min($paper_sizes);
            // หากระดาษที่ต้องการนำไปคำนวน ตามขนาดกระดาษ size เล็กสุด
            $paper = null;
            foreach ($papers as $key => $paper) {
                if ($paper['size'] == $min_size) {
                    $paper = $paper;
                    break;
                }
            }

            if ($paper != null) {
                $this->job_per_sheet = $paper['job_per_sheet'];
                $this->print_area_width = $paper['paper_print_area_width'];
                $this->print_area_length = $paper['paper_print_area_length'];
                $this->paper_cut = $paper['paper_cut'];
                $this->paper_size = $paper['paper_size'];
                $this->paper = $paper;
            }
        } else {
            // หาค่าสูงสุด
            $paper = null;
            foreach ($job_per_sheets as $key => $job_per_sheet) {
                if ($job_per_sheet['job_per_sheet'] == $max_per_sheet) {
                    $paper = $job_per_sheet;
                    break;
                }
            }
            if ($paper != null) {
                $this->job_per_sheet = $paper['job_per_sheet'];
                $this->print_area_width = $paper['paper_print_area_width'];
                $this->print_area_length = $paper['paper_print_area_length'];
                $this->paper_cut = $paper['paper_cut'];
                $this->paper_size = $paper['paper_size'];
                $this->paper = $paper;
            }
        }
        $this->print_sheet_total = $model['cust_quantity'] / $this->job_per_sheet; //จำนวนแผ่นพิมพ์
        $this->cal_print_sheet_total = $this->print_sheet_total; //จำนวนแผ่นพิมพ์ที่เผื่อ

        $this->messages = $messages;
    }

    //หาราคาเคลือบ
    public $laminate_price = 0; //ราคาเคลือบ

    public function findCoating() {

        if ($this->model['coating_id'] != 'N') { //ถ้ามีเคลือบ
            $coating_prices = TblCoatingPrice::find()->all(); //ราคาเคลือบ
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //จำนวนแผ่นพิมพ์ + เผื่อกระดาษ
            $sq = $this->paper_size;
            $this->laminate_price = CalculetFnc::calculateCoatingPrice($coating_prices, $this->model['coating_id'], $sq, $this->cal_print_sheet_total);
            //ถ้าเคลือบสองหน้า
            if ($this->model['coating_option'] == 'two_page') { //เคลือบ 2 หน้า
                $this->laminate_price = $this->laminate_price * 2;
            }
            // ตรวจสอบราคาขั้นต่ำ 300
            if ($this->laminate_price < 300) {
                $this->laminate_price = 300;
            }
        }
    }

    // การปั๊มฟอยล์
    public $foil_price = 0; //ราคาฟอยล์
    public $foil_color_price = 0; // ค่าสีฟอยล์ ต่อ ตรน.
    public $block_foil_price = 0; //ค่าบล๊อกปั๊มฟอยล์
    public $sqFoilSize = 0; //ตารางนิ้วที่ต้องการปั๊ม

    public function findFoilPrice() {
        if (!empty($this->model['foil_size_width']) && !empty($this->model['foil_size_height'])) {

            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //จำนวนแผ่นพิมพ์ + เผื่อกระดาษ
            $sqFoilSize = 0;
            if ($this->model['foil_size_unit'] == 3) {
                $foil_size_width = CalculetFnc::convertInToCm($this->model['foil_size_width']);
                $foil_size_height = CalculetFnc::convertInToCm($this->model['foil_size_height']);
            } else {
                $foil_size_width = CalculetFnc::convertCmToIn($this->model['foil_size_width']);
                $foil_size_height = CalculetFnc::convertCmToIn($this->model['foil_size_height']);
            }
            $sqFoilSize = $foil_size_width * $foil_size_height; // ตรน ที่ลูกค้ากำหนด
            $this->sqFoilSize = $sqFoilSize;
            if ($sqFoilSize >= 30) { //ขนาด 30 ตารางนิ้วขึ้นไป
                $this->block_foil_price = $sqFoilSize * 18; //ตารางนิ้วละ 18 บาท
            } else {
                $block_prices = TblEmbossPrice::find()->all(); //ราคาบล๊อกปั๊มฟอยล์
                $this->block_foil_price = CalculetFnc::calculateBlockFoil($block_prices, $sqFoilSize);
            }
            $foil_color_prices = [
                'FOIL-00003' => 0.2, //สีเงิน
                'FOIL-00004' => 0.5, //สีพิเศษ
                'FOIL-00005' => 0.2, //สีทอง
            ];
            $this->foil_color_price = ArrayHelper::getValue($foil_color_prices, $this->model['foil_color_id'], 0); //ค่าสีต่อตารางเมตร
            //ราคาสีฟอยล์ * ขนาดฟอยล์(นิ้ว) * จำนวนที่ลูกค้าต้องการ
            $this->foil_price = $this->foil_color_price * $sqFoilSize * $this->model['cust_quantity'];

            if ($this->foil_price < 300) { //ราคาขั้นต่ำปั๊มฟอยล์ 300
                $this->foil_price = 300;
            }
            $this->foil_price = $this->block_foil_price + $this->foil_price + 100; //ค่าบล๊อกฟอยล์ + ราคาฟอยล์ + ค่าขนส่งบล๊อก
        }
    }

    //การปั๊มนูน
    public $emboss_price = 0; // ราคาปั๊มนูน
    public $block_emboss_price = 0;  //ค่าบล๊อกปั๊มนูน

    public function findEmbossPrice() {
        if (!empty($this->model['emboss_size_width']) && !empty($this->model['emboss_size_height'])) {

            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //จำนวนแผ่นพิมพ์ + เผื่อกระดาษ

            $sqeEbossSize = 0; // ขนาด ตรน
            $emboss_size_width = CalculetFnc::convertCmToIn($this->model['emboss_size_width']);
            $emboss_size_height = CalculetFnc::convertCmToIn($this->model['emboss_size_height']);
            $sqeEbossSize = $emboss_size_width * $emboss_size_height; // ตรน ที่ลูกค้ากำหนด

            if ($sqeEbossSize >= 30) { //ขนาด 30 ตารางนิ้วขึ้นไป
                $this->block_emboss_price = $sqeEbossSize * 18; //ตารางนิ้วละ 18 บาท
            } else {
                $block_prices = TblEmbossPrice::find()->all(); //ราคาบล๊อกปั๊มนูน
                $this->block_emboss_price = CalculetFnc::calculateBlockEmboss($block_prices, $sqeEbossSize);
            }
            $this->emboss_price = $this->model['cust_quantity'] * 0.3;
            if ($this->emboss_price < 300) { //ราคาขั้นต่ำปั๊มนูน 300
                $this->emboss_price = 300;
            }
            $this->block_emboss_price = $this->block_emboss_price * 2;
            $this->emboss_price = $this->block_emboss_price + $this->emboss_price + 100; //ค่าบล๊อกปั๊มนูน + ราคาปั๊มนูน + ค่าขนส่งบล๊อก
        }
    }

    //ข้อ 9 ไดคัท

    public $dicut_price = 0;  //ราคาไดคัท
    public $block_dicut_price = 0;  //ราคาบล๊อกไดคัท

    public function findDicutPrice() {
        if ($this->model['diecut'] != 'N') {
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //จำนวนแผ่นพิมพ์ + เผื่อกระดาษ

            if ($this->model['diecut'] == 'Default') { //ไดคัทตามรูปแบบ
                $params = [
                    'isSticker' => $this->isSticker, // สติ๊กเกอร์
                    'cal_print_sheet_total' => $this->cal_print_sheet_total, // จำนวนแผ่นพิมพ์
                    'dicut_price' => $this->dicut_price, // ราคาไดคัท
                    'job_per_sheet' => $this->job_per_sheet, // ชิ้นงานที่วางได้
                    'print_sheet_total' => $this->print_sheet_total, // จำนวนแผ่นพิมพ์เผื่อ
                    'block_dicut_price' => $this->block_dicut_price, // ราคาบล๊อกไดคัท
                ];
                $result = CalculetFnc::calculateDicutDefaultOffset($params);
                $this->block_dicut_price = $result['block_dicut_price'];  // ราคาบล๊อกไดคัท
                $this->dicut_price = $result['dicut_price'];  // ราคาไดคัท
                $this->print_sheet_total = $result['print_sheet_total'];  // จำนวนแผ่นพิมพ์ที่เผื่อ
            }
        }
    }

    //ข้อ 10 มีการปะกาว
    public $glue_price = 0;

    public function findGluePrice() {
        if ($this->model['glue'] == 1) {
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //จำนวนแผ่นพิมพ์ + เผื่อกระดาษ

            $this->glue_price = $this->cal_print_sheet_total * 0.3;
            if ($this->glue_price < 300) {//ราคาขั้นต่ำการปะกาว
                $this->glue_price = 300;
            }
        }
    }

    //ข้อ 11 มีการพับ

    public $fold_price = 0; //ราคาพับ
    public $fold_block_price = 300;  //ราคาบล๊อก

    public function findFlod() {
        $details = $this->flod_detail;
        if ($this->model['fold_id'] !== 'N') {
            if ($this->paper_type['paper_gram'] >= 200) {
                if ($this->cal_print_sheet_total <= 50) {
                    $this->fold_price = $this->cal_print_sheet_total * 20;
                } else {
                    $this->print_sheet_total = $this->print_sheet_total + 5;  //บวกเผื่อกระดาษ
                    $this->fold_price = $this->cal_print_sheet_total * 0.3;
                    if ($this->fold_price < 200) { //ราคาขั้นต่ำ 200
                        $this->fold_price = 200;
                    }
                    $this->fold_price = $this->fold_block_price + $this->fold_price;
                }
            } else { //กระดาษบาง
                $fold = TblFold::findOne($this->model['fold_id']);
                if ($this->model['cust_quantity'] <= 500) {
                    $this->fold_price = $this->model['cust_quantity'] * 0.50 * $fold['fold_count']; //จำนวนลูกค้าต้องการ *0.50*จำนวนมุม
                } else {
                    $fold_count_price = 0;
                    switch ($fold['fold_count']) {  //หาราคาค่าพับ ตามจำนวนพับ
                        case 1: //พับ 1
                            $fold_count_price = 70; // 1000 ชิ้น เท่ากับ 70
                            break;
                        case 2: //พับ 2
                            $fold_count_price = 80; // 1000 ชิ้น เท่ากับ 80
                            break;
                        case 3: //พับ 3
                            $fold_count_price = 90; // 1000 ชิ้น เท่ากับ 90
                            break;
                        case 4: //พับ 4
                            $fold_count_price = 100; // 1000 ชิ้น เท่ากับ 100
                            break;
                    }
                    if ($this->model['cust_quantity'] > 500 && $this->model['cust_quantity'] < 1000) { //มากกว่า 500 และน้อยกว่า 1000 ชิ้น คิดตามราคาค่าพับพันละ
                        $this->fold_price = $fold_count_price;
                    } else {
                        $this->fold_price = ($this->model['cust_quantity'] / 1000) * $fold_count_price;  //มากกว่า 1000 เอาจำนวนที่ลูกค้าต้องการ / 1000 * ราคาค่าพับพันละ
                    }
                    if ($this->fold_price < 300) { //ราคาขั้นต่ำการพับ 300
                        $this->fold_price = 300;
                    }
                }
            }
            $details = [
                'fold_block_price' => $this->fold_block_price,
                'fold_price' => $this->fold_price
            ];
        }
        $this->flod_detail = $details;
    }

    //คำนวณค่าพิมพ์  ตรวจสอบจากหน้าจอว่าลูกค้าเลือกพิมพ์สองหน้า หรือหน้าเดียว
    public $print_one_page = false; //พิมพ์หน้าเดียว
    public $print_two_page = false; //พิมพ์สองหน้า
    public $printing_color_price = 0;

    public function findPrintingColorPrice() {
        if (!empty($this->model['before_print'])) { //พิมพ์ 2 หน้า
            $this->print_two_page = true;
        }
        if (!empty($this->model['after_print'])) { //พิมพ์ 1 หน้า
            $this->print_one_page = true;
        }
        if ($this->print_one_page) {  //พิมพ์ 1 หน้า
            if ($this->model['after_print'] == 'PT-00005') {  //สีดำ
                $this->printing_color_price = $this->cal_print_sheet_total * 5;
            } else {
                $this->printing_color_price = $this->cal_print_sheet_total * 20;
            }
        } else if ($this->print_two_page) {
            if ($this->model['before_print'] == 'PT-00005') {  //สีดำ
                $this->printing_color_price = ($this->cal_print_sheet_total * 5) * 2;
            } else {
                $this->printing_color_price = ($this->cal_print_sheet_total * 20) * 2;
            }
        }
    }

    // ข้อ 12 นำจำนวนแผ่นพิมพ์ทั้งหมดที่ได้   มาหาราคากระดาษแผ่นใหญ่
    public $paper_bigsheet = 0;  //กระดาษแผ่นใหญ่
    public $final_paper_price = 0;  // ราคากระดาษ

    public function findPaperBigsheet() {
        $this->paper_bigsheet = $this->print_sheet_total / $this->paper_cut; //จำนวนแผ่นพิมพ์ที่บวกเผื่อ / (ขนาดกระดาษที่ตัด) 
        $this->final_paper_price = $this->paper_bigsheet * $this->paper_type['paper_price']; //หาราคากระดาษ จำนวนกระดาษแผ่นใหญ่ * ราคากระดาษจากฐานข้อมูล
    }

    //หาค่าพิมพ์งานตามจำนวนรอบ
    public $printing_price = 0;

    public function findPrintingPrice() {
        $print_prices = TblPrintPrice::find()->all(); //ราคาค่าพิมพ์(ค่าวิ่งงาน)
        foreach ($print_prices as $key => $print_price) {
            if ($this->cal_print_sheet_total <= $print_price['print_sheet_qty'] && $this->paper_cut == $print_price['print_paper_cut']) {
                $this->printing_price = $print_price['price'];
                break;
            } else if ($this->cal_print_sheet_total > 10000) {
                if ($this->paper_cut == 2) {
                    $this->printing_price = ($this->cal_print_sheet_total / 1000) * 850;
                }
                if ($this->paper_cut == 3) {
                    $this->printing_price = ($this->cal_print_sheet_total / 1000) * 660;
                }
                if ($this->paper_cut == 4) {
                    $this->printing_price = ($this->cal_print_sheet_total / 1000) * 470;
                }
            }
        }
    }

    //ราคาเพลท
    public $place_price = 0;

    public function findPlacePrice() {
        $this->place_price = CalculetFnc::calculatePricePlace($this->paperWidth, $this->paperLenght, $this->fourColors, $this->oneColors);
    }

    //เอาราคาทั้งหมดมาบวกกัน
    public $final_price_offset = 0;

    public function summaryPrice() { //คำนวนราคาทั้งหมด 
        $this->final_price_offset = $this->place_price +
                $this->final_paper_price +
                $this->printing_price +
                $this->laminate_price +
                $this->dicut_price +
                $this->fold_price +
                $this->emboss_price +
                $this->glue_price +
                $this->foil_price;

        $final_price_offset_percent = ($this->final_price_offset / 100 ) * 20;  //ค่าบริการจัดการ 20%
        $this->final_price_offset = $this->final_price_offset + $final_price_offset_percent;
        //คำนวนราคาทั้งหมด (ค่าเพลท + ราคาเคลือบ + ราคาฟอยล์ + ราคาปั๊มนูน + ราคาไดคัท + ราคาปะกาว + ราคาพับ + ราคากระดาษ )
    }

    public function getModel() {
        return $this->model;
    }

    public function getAttributeValue() {
        return [
            'เป็นสติ๊กเกอร์' => $this->isSticker,
            'จำนวนชิ้นงาน' => $this->job_per_sheet,
            'ความกว้าง' => $this->print_area_width,
            'ความยาว' => $this->print_area_length,
            'จำนวนแผ่นพิมพ์ที่บวกเผื่อกระดาษ' => $this->print_sheet_total,
            'จำนวนแผ่นพิมพ์ที่ยังไม่บวกเผื่อกระดาษ' => $this->cal_print_sheet_total,
            'ตัด' => $this->paper_cut,
            'ไซส์' => $this->paper_size,
            'พิมพ์ 1 สี' => $this->oneColors,
            'พิมพ์ 2 สี' => $this->twoColors,
            'พิมพ์ 4 สี' => $this->fourColors,
            'inputs' => $this->model,
            'กระดาษที่ใช้' => $this->paper,
            'จำนวนชิ้นงานที่วางได้จาดขนาดกระดาษทั้งหมด' => $this->job_per_sheets,
            'messages' => $this->messages,
            'ราคาเคลือบ' => $this->laminate_price,
            'ฟอยล์' => [
                'ค่าบล๊อกปั๊มฟอยล์' => $this->block_foil_price,
                'ค่าสีฟอยล์' => $this->foil_color_price,
                'ราคาปั๊มฟอยล์' => $this->foil_price,
                'ตารางนิ้วที่ต้องการปั๊ม' => $this->sqFoilSize,
            ],
            'ปั้มนูน' => [
                'ค่าบล๊อกปั๊มนูน' => $this->block_emboss_price,
                'ราคาปั๊มนูน' => $this->emboss_price,
            ],
            'การพับ' => $this->flod_detail,
            'ประเภทการดาษ' => $this->paper_type,
            'ไดคัท' => [
                'ค่าบล๊อกไดคัท' => $this->block_dicut_price,
                'ราคาไดคัท' => $this->dicut_price,
            ],
            'ราคาปะกาว' => $this->glue_price,
            'พิมพ์หน้าเดียว' => $this->print_one_page,
            'พิมพ์สองหน้า' => $this->print_two_page,
            'ราคาพิมพ์สี' => $this->printing_color_price,
            'ราคาค่าพิมพ์งาน(วิ่ง)' => $this->printing_price,
            'ราคากระดาษ' => $this->final_paper_price,
            'ราคากระดาษแผ่นใหญ่' => $this->paper_bigsheet,
            'ราคารวมทั้งหมดฝั่งดิจิตอล' => $this->final_price_offset,
            'final_price_offset' => $this->final_price_offset,
            'price_per_item_offset' => $this->final_price_offset / $this->model['cust_quantity']
        ];
    }

}
