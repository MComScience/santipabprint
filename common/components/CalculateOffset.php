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
use common\modules\app\models\TblPaperDetail;
use yii\helpers\Json;
use Yii;
use common\modules\app\traits\ModelTrait;

class CalculateOffset extends Component {

    use ModelTrait;

    public $model;

    public function init() {
        parent::init();
        if ($this->model) {
            $this->findModeles();
            $this->setOptions();
            $this->findJobPerSheet();
            //$this->findCoating();
//            $this->findFoilPrice();
//            $this->findEmbossPrice();
            $this->findDicutPrice();
            $this->findDicutPrice();
            $this->findGluePrice();
            $this->findFlod();
            $this->findRopePrice();
            $this->findGlueBagPrice();
            $this->findBookBindingPrice();
            $this->findRunningNumberPrice();
            $this->findPerforatedRippedPrice();
            $this->findWindowBoxPrice();
            $this->findCorrugatedBoxPrice(); //ปะกบกล่องลูกฟูก
            $this->findGluingBoxPrice();
            $this->findPaperBigsheet();
            $this->findPrintingPriceTotal();
            $this->summaryPrice();
        }
    }

    public $modelProduct = null; //สินค้า
    public $modelPaperSize = null; //ขนาด
    public $modelPaper = null; //ประเภทกระดาษ
    public $modelColorPrint = null; //สีที่พิมพ์
    public $modelCoating = null; //เคลือบ
    public $modelDiCut = null; //ไดคัท
    public $modelFoilUnit = null; //หน่วยฟอยล์
    public $modelFoilColor = null; //สีฟอยล์
    public $modelEmbossUnit = null; //หน่วยปั๊มนูน
    public $modelPerforateOptiont = null; //มุมที่เจาะ
    public $modelFold = null; //วิธีพับ

    public function findModeles() {
        $model = $this->model;
        $this->modelProduct = $this->findModelProduct($model['product_id']);
        if ($model['paper_size_id'] != 'custom' && !empty($model['paper_size_id'])) {
            $this->modelPaperSize = $this->findModelPaperSize($model['paper_size_id']);
        }
        $this->modelPaper = $this->findModelPaper($model['paper_id']);
        if (!empty($model['print_color'])) {
            $this->modelColorPrint = $this->findModelColorPrinting($model['print_color']);
        }
        if ($model['coating_id'] != 'N' && !empty($model['coating_id'])) {
            $this->modelCoating = $this->findModelCoating($model['coating_id']);
        }

        if (ArrayHelper::isIn($this->modelProduct['package_type_id'], [54, 66]) && ArrayHelper::isIn($this->modelProduct['product_category_id'], [17])) {
            $this->model['diecut'] = 'Default';
        }
        if ($model['diecut'] != 'N' && $model['diecut'] != 'Default' && !empty($model['diecut_id'])) {
            $this->modelDiCut = $this->findModelDiecut($model['diecut_id']);
        }
        if ($model['foil_status'] == 'Y' && !empty($model['foil_size_unit'])) {
            $this->modelFoilUnit = $this->findModelUnit($model['foil_size_unit']);
            $this->modelFoilColor = $this->findModelFoilColor($model['foil_color_id']);
        }
        if ($model['emboss_status'] == 'Y' && !empty($model['emboss_size_unit'])) {
            $this->modelEmbossUnit = $this->findModelUnit($model['emboss_size_unit']);
        }
        if (!empty($model['perforate_option_id'])) {
            $this->modelPerforateOptiont = $this->findModelPerforateOption($model['perforate_option_id']);
        }
        if (!empty($model['fold_id']) && $model['fold_id'] != 'N') {
            $this->modelFold = $this->findFlod($model['fold_id']);
        }
    }

    public function setOptions() {
        $model = $this->model;
        //
        $this->checkPrintOptions();
        $this->checkCoatingOptions();
        $this->checkDicutOptions();
        $this->checkFoilOptions();
        $this->checkEmbossOptions();
        $this->checkPerforateOptions();
        $this->checkFoldOptions();
        $this->checkGlueOptions();
        $this->checkProductOptions();
        $this->checkPaperSize();
    }

    ######################## ตรวจสอบพิมพ์ ########################

    public $printOnePage = false; //พิมพ์สองหน้า/หน้าเดียว
    public $printTwoPage = false; //พิมพ์สองหน้า/หน้าเดียว
    public $oneColors = false; // งาน 1 สี
    public $twoColors = false; // งาน 2 สี
    public $fourColors = false; // งาน 4 สี

    public function checkPrintOptions() {
        $model = $this->model;
        //หน้าเดียว
        if ($model['print_option'] == 'one_page') {
            $this->printOnePage = true;
        }
        // พิมพ์สองหน้า
        if ($model['print_option'] == 'two_page') {
            $this->printTwoPage = true;
        }

        $colorPrinting = $this->modelColorPrint;
        if ($colorPrinting) {
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
    }

    ######################## เคลือบ ########################

    public $isCoating = false; // เคลือบ, ไม่เคลือบ
    public $coatingOnePage = false; // ด้านเดียว
    public $coatingTwoPage = false; // สองด้าน

    public function checkCoatingOptions() {
        $model = $this->model;
        //เคลือบ/ไม่เคลือบ
        if ($this->modelCoating) {
            $this->isCoating = true;
        }
        // ด้านเดียว
        if ($model['coating_option'] == 'one_page') {
            $this->coatingOnePage = true;
        }
        // สองด้าน
        if ($model['coating_option'] == 'two_page') {
            $this->coatingTwoPage = true;
        }
    }

    ########################  ไดคัท ########################

    public $isDicut = false; //  ไดคัท, ไม่ไดคัท
    public $isDicutDefault = false; // ไดคัทตามรูปแบบ

    public function checkDicutOptions() {
        $model = $this->model;
        // ไม่เลือกไม่ไดคัท, ไม่ตามรูปแบบ, เป็นมุมมน
        if ($model['diecut'] != 'N' && $model['diecut'] != 'Default' && !empty($model['diecut_id'])) {
            $this->isDicut = true;
        } else if ($model['diecut'] == 'Default') {
            $this->isDicut = true;
            $this->isDicutDefault = true;
        }
    }

    ########################   ปั๊มฟอยล์ ########################

    public $isFoil = false; // ปั๊ม/ไม่ปั๊ม
    public $foilOnePage = false; // ปั๊มฟอยล์ หน้าเดียว
    public $foilTwoPage = false; // ปั๊มฟอยล์ หน้า-หลัง

    public function checkFoilOptions() {
        $model = $this->model;
        // 
        if ($model['foil_status'] == 'Y') {
            $this->isFoil = true;
        }
        if ($model['foli_print'] == 'one_page') {
            $this->foilOnePage = true;
        }
        if ($model['foli_print'] == 'two_page') {
            $this->foilTwoPage = true;
        }
    }

    ########################   ปั๊มนูน ########################

    public $isEmboss = false; // ปั๊ม/ไม่ปั๊ม
    public $embossOnePage = false; // ปั๊มนูน หน้าเดียว
    public $embossTwoPage = false; // ปั๊มนูน หน้า-หลัง

    public function checkEmbossOptions() {
        $model = $this->model;
        // 
        if ($model['emboss_status'] == 'Y') {
            $this->isEmboss = true;
        }
        if ($model['emboss_print'] == 'one_page') {
            $this->embossOnePage = true;
        }
        if ($model['emboss_print'] == 'two_page') {
            $this->embossTwoPage = true;
        }
    }

    ######################## ตัดเป็นตัว/เจาะ ########################

    public $perforate = null;

    public function checkPerforateOptions() {
        $model = $this->model;
        // 
        if ($model['perforate'] == '0') {
            $this->perforate = 'ตัดเป็นตัวอย่างเดียว';
        }
        if ($model['perforate'] == '1') {
            $this->perforate = 'ตัดเป็นตัว + เจาะรูกลม';
        }
    }

    ######################## พับ ########################

    public $isFold = false; // พับ/ไม่พับ

    public function checkFoldOptions() {
        $model = $this->model;
        // 
        if ($model['fold_id'] == 'N') {
            $this->isFold = false;
        }
    }

    ######################## ปะกาว ########################

    public $isGlue = false; // ปะกาว/ไม่ปะกาว

    public function checkGlueOptions() {
        $model = $this->model;
        // 
        if ($model['glue'] == 'glue') {
            $this->isGlue = true;
        }
    }

    ######################## ตรวจสอบประเภทสินค้า ########################

    public $isBox = false; //กล่องกระดาษ
    public $isBag = false; // ถุงกระดาษ
    public $isvoucher = false;  //บัตรกำนัล/คูปอง/Voucher

    public function checkProductOptions() {
        $model = $this->model;
        $product = $this->modelProduct;

        if (ArrayHelper::isIn($product['package_type_id'], [54, 66]) && ArrayHelper::isIn($product['product_category_id'], [17])) {
            $this->isBox = true; //กล่องบรรจุภัณฑ์
        } else if ($product['package_type_id'] == 36 && $product['product_category_id'] == 6) {
            $this->isBag = true; // ถุงกระดาษ
        } else if ($product['package_type_id'] == 44 && $product['product_category_id'] == 12) {
            $this->isvoucher = true; //บัตรกำนัล/คูปอง/Voucher
        }
    }

    ######################## กำหนดขนาดกระดาษ ########################

    public $paperWidth = 0; // ความกว้าง (cm)
    public $paperLenght = 0; // ความยาว (cm)
    public $paperSize = null; // ขนาดกระดาษ

    public function checkPaperSize() {
        $product = $this->modelProduct;
        $model = $this->model;

        $paper_size_width = $model['paper_size_width']; // ความกว้างจากหน้าจอ
        $paper_size_lenght = $model['paper_size_lenght']; // ความยาวจากหน้าจอ
        $paper_size_height = $model['paper_size_height']; // ความสูงจากหน้าจอ

        if ($model['paper_size_id'] == 'custom') { // กำหนดเอง
            //ขนาดสินค้า รับค่าจากหน้าจอ มีหน่วยเป็นนิ้ว
            if ($model['paper_size_unit'] == 3) { // มีหน่วยเป็นนิ้ว
                // สินค้าเป็นประเภทกล่อง
                if ($this->isBox) {
                    // แปลงนิ้วเป็นเซนติเมตร
                    $paperWidth = CalculetFnc::convertInToCm($paper_size_width); //กว้าง
                    $paperLenght = CalculetFnc::convertInToCm($paper_size_lenght); // ยาว
                    $paperHight = CalculetFnc::convertInToCm($paper_size_height); // สูง

                    $this->paperWidth = (($paperWidth * 2) + ($paperLenght * 2)) + 0.635; //ความกว้าง = (กว้าง * 2 (2ด้าน))+(ความยาว * 2 (2ด้าน)) + 0.635 เผื่ดติดกาว(แปลงจาก0.25นิ้ว) 
                    $this->paperLenght = $paperHight + ($paperWidth * 2) + 1.27; //ความยาว = ความสูง + (ความกว้าง*2) + 1.27 ส่วนพับ(แปลงจาก 0.5 นิ้ว)
                } else if ($this->isBag) {//ถุงกระดาษ
                    $paperWidth = CalculetFnc::convertInToCm($this->model['paper_size_width']); //กว้าง
                    $paperLenght = CalculetFnc::convertInToCm($this->model['paper_size_lenght']); // ยาว
                    $paperHight = CalculetFnc::convertInToCm($this->model['paper_size_height']); // สูง

                    $this->paperWidth = (($paperWidth * 2) + ($paperLenght * 2)) + 1.27; //ความกว้าง = (กว้าง * 2 (2ด้าน))+(ความยาว * 2 (2ด้าน)) +  เผื่ดติดกาว(แปลงจาก 0.5 นิ้ว)
                    $this->paperLenght = $paperHight + $paperWidth + 3.81; //ความยาว = ความสูง + ความกว้าง + ส่วนพับ(แปลงจาก 1.5 นิ้ว)   
                } else {
                    // แปลงนิ้วเป็นเซนติเมตร
                    $this->paperWidth = CalculetFnc::convertInToCm($paper_size_width);
                    $this->paperLenght = CalculetFnc::convertInToCm($paper_size_lenght);
                }
            } else { // หน่วยเป็นเซน
                if ($this->isBox) {// สินค้าเป็นประเภทกล่อง
                    $this->paperWidth = (($paper_size_width * 2) + ($paper_size_lenght * 2)) + 0.635;
                    $this->paperLenght = $paper_size_height + ($paper_size_width * 2) + 1.27;
                } else if ($this->isBag) { //ถุงกระดาษ
                    $this->paperWidth = (($paper_size_width * 2) + ($paper_size_lenght * 2)) + 1.27;
                    $this->paperLenght = $paper_size_height + $paper_size_width + 3.81;
                } else {
                    $this->paperWidth = $paper_size_width; // (cm)
                    $this->paperLenght = $paper_size_lenght; // (cm)
                }
            }
            // คำนวณขนาดตามเงื่อนไข (พับ, หน่วยกระดาษ, ความกว้าง, ความยาว)
            $sizes = CalculetFnc::calculateWidthLength($model['fold_id'], $model['paper_size_unit'], $this->paperWidth, $this->paperLenght);
            $this->paperWidth = $sizes['width'];
            $this->paperLenght = $sizes['length'];
        } else { // กระดาษจากฐานข้อมูล
            //หาขนาดกระดาษจากฐานข้อมูล
            $paper = $this->modelPaperSize;
            if ($paper['paper_unit_id'] == 3) { //ขนาดเป็น นิ้ว
                // แปลงนิ้วเป็นเซนติเมตร
                $this->paperWidth = CalculetFnc::convertInToCm($paper['paper_size_width']);
                $this->paperLenght = CalculetFnc::convertInToCm($paper['paper_size_height']);
            } else {
                $this->paperWidth = $paper['paper_size_width']; // (cm)
                $this->paperLenght = $paper['paper_size_height']; // (cm)
            }
            $this->paperSize = $paper;

            // คำนวณขนาดตามเงื่อนไข (พับ, หน่วยกระดาษ, ความกว้าง, ความยาว)
            $sizes = CalculetFnc::calculateWidthLength($model['fold_id'], $model['paper_size_id'], $this->paperWidth, $this->paperLenght);
            $this->paperWidth = $sizes['width'];
            $this->paperLenght = $sizes['length'];
        }
    }

    ######################## หาจำนวนชิ้นงานที่วางได้ ########################

    public $paperDetails = null;
    public $paper_sizes = [];
    public $print_sheet_total = 0;
    public $start_print_sheet_total = 0;
    public $job_per_sheets = [];
    public $job_per_sheets_mod = []; //การวาง lay ที่เป็นเลขคู่
    public $cal_paper_sizes = [];
    public $paper = null;

    public function findJobPerSheet() {
        $model = $this->model;
        $paper = $this->modelPaper;
        $print_prices = TblPrintPrice::find()->all(); //ราคาค่าพิมพ์(ค่าวิ่งงาน)
        // หา size กระดาษทั้งหมด จากกระดาษที่เลือก
        $paperDetails = TblPaperDetail::find()->where(['paper_id' => $paper['paper_id']])->groupBy('paper_size')->all();
        if ($paperDetails) {
            $this->paperDetails = $paperDetails;
            $this->paper_sizes = ArrayHelper::getColumn($paperDetails, 'paper_size'); // S1, S2, S-T, L

            if ($this->oneColors) {//งาน 1 สี บวกเริ่มต้นที่ 80 ใบ และบวกเพิ่ม 50 ใบ ทุก ๆ 1000 แผ่นพิมพ์
                $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 80, 50);
            }
            if ($this->twoColors) {//งาน 2 สี บวกเริ่มต้นที่ 100 และบวกเพิ่ม 50 ใบ ทุก ๆ 1000 แผ่นพิมพ์
                $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 100, 50);
            }
            if ($this->fourColors) {//งาน 4 สี บวกเริ่มต้นที่ 150 และบวกเพิ่ม 50 ใบ ทุก ๆ 1000 แผ่นพิมพ์
                $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 150, 50);
            }
            $cal_paper_sizes = [];
            foreach ($paperDetails as $key => $paperDetail) {
                $isSticker = $paperDetail['stk_flag'] == 'Y'; //เป็นสติ๊กเกอร์
                $paperCuts = $this->findPaperCut($isSticker, $paperDetail['paper_size']); //ขนาดกระดาษที่นำไปคำนวน
                // คำนวณการวาง lay 
                $cal_job_per_sheets = $this->calculateLay($paperCuts, $paperDetail, $print_prices);
                $this->job_per_sheets[$paperDetail['paper_size']] = $cal_job_per_sheets;

                $new_cal_job_per_sheets = [];
                if ($this->printTwoPage) { //พิมพ์ 2 หน้า 
                    foreach ($cal_job_per_sheets as $cal_job_per_sheet) {
                        if ($cal_job_per_sheet['is_mod']) { //งานพิมพ์ 2 หน้า หาชิ้นงานการวางที่เป็นเลขคู่
                            $new_cal_job_per_sheets[] = $cal_job_per_sheet;
                        }
                    }
                    if ($new_cal_job_per_sheets) { // ถ้ามีเลขคู่
                        $cal_job_per_sheets = $new_cal_job_per_sheets;
                        $this->job_per_sheets_mod[$paperDetail['paper_size']] = $new_cal_job_per_sheets;
                    } else {
                        continue;
                    }
                }
                // หาค่าพิมพ์งานขั้นต้นที่มีค่าต่ำสุด
                ArrayHelper::multisort($cal_job_per_sheets, ['print_price_start', 'print_price_start'], [SORT_ASC, SORT_ASC]);
                $cal_per_sheets = ArrayHelper::getColumn($cal_job_per_sheets, 'print_price_start');
                $min_price_start = $this->findMinPriceStart($cal_per_sheets);
                // ค่าพิมพ์งานขั้นต้น
                $cal_paper_sizes = ArrayHelper::merge($cal_paper_sizes, $this->getCalculatePriceStart($cal_job_per_sheets, $min_price_start));
//                ArrayHelper::multisort($cal_job_per_sheets, ['job_per_sheet', 'job_per_sheet'], [SORT_ASC, SORT_ASC]);
//                $cal_per_sheets = ArrayHelper::getColumn($cal_job_per_sheets, 'job_per_sheet');
//                $max_per_sheet = $this->findMaxJopPersheet($cal_per_sheets);
//                $cal_paper_sizes = ArrayHelper::merge($cal_paper_sizes, $this->getCalculatePaperSize($cal_job_per_sheets, $cal_per_sheets, $max_per_sheet, $paperDetail));
            }

            //วางงานเป็นเลขคู่ไม่ได้ (ค่าพิมพ์งานขั้นต้น)
            if (count($this->job_per_sheets_mod) == 0) {
                $cal_job_per_sheets = [];
                foreach ($this->job_per_sheets as $key => $item) {
                    foreach ($item as $index => $data) {
                        if ($data['job_per_sheet'] > 0) {
                            if ($this->printOnePage) { //งานพิมพ์ 1 หน้า
                                $cal_job_per_sheets[] = $data;
                            } elseif ($this->printTwoPage) { //งานพิมพ์ 2 หน้า
                                $place = $data['place'];

                                $newPlace = ArrayHelper::merge($place, [//ราคาเพลท * 2
                                            'place_price' => $place['place_price'] * 2
                                ]);

                                $cal_job_per_sheets[] = ArrayHelper::merge($data, [//ราคาวิ่งงาน * 2
                                            'place' => $newPlace,
                                            'print_price_start' => $data['print_price_start'] * 2
                                ]);
                            }
                        }
                    }
                }
//                if (count($cal_job_per_sheets) == 0) {
//                    throw new \yii\web\HttpException(422, 'เนื่องจากขนาดชิ้นงานของท่านมีไชส์ใหญ่เกินระบบจะประมาณผล กรุณาติดต่อโรงพิมพ์');
//                }
                // หาค่าพิมพ์งานขั้นต้นที่มีค่าต่ำสุด
//                ArrayHelper::multisort($cal_job_per_sheets, ['print_price_start', 'print_price_start'], [SORT_ASC, SORT_ASC]);
//                $cal_per_sheets = ArrayHelper::getColumn($cal_job_per_sheets, 'print_price_start');
//                $min_price_start = $this->findMinPriceStart($cal_per_sheets);
                // ค่าพิมพ์งานขั้นต้น
                // $cal_paper_sizes = ArrayHelper::merge($cal_job_per_sheets, $this->getCalculatePriceStart($cal_job_per_sheets, $min_price_start));
                $cal_paper_sizes = $cal_job_per_sheets;
            }
            $this->cal_paper_sizes = $cal_paper_sizes;

            if ($cal_paper_sizes) {
                // เปรียบเทียบราคาที่ถูกที่สุด
                $this->paper = $this->getPaperMinPriceStart($cal_paper_sizes);
                $this->start_print_sheet_total = $this->paper['start_print_sheet_total']; //จำนวนแผ่นที่ยังไม่เผื่อ
                $this->print_sheet_total = $this->paper['print_sheet_total']; //จำนวนแผ่นพิมพ์ที่บวกเผื่อกระดาษจากการคำนวนพิมพ์สี
            }

            $this->findCoating();
        }
    }

    private function findPaperCut($isSticker, $size) {
        if ($isSticker) { //เป็นสติ๊กเกอร์ + มีไดคัท
            return TblPaperCut::find()->where([
                        'paper_type' => 'offset',
                        'paper_sticker' => 1,
                        'paper_size' => $size,
                    ])->all();
        } else {
            return TblPaperCut::find()->where([
                        'paper_type' => 'offset',
                        'paper_sticker' => 0,
                        'paper_size' => $size,
                    ])->all();
        }
    }

    private function calculateLay($paperCuts, $paperDetail, $print_prices) {
        $model = $this->model;
        $cal_job_per_sheets = [];

        foreach ($paperCuts as $paper) {
            //แปลงหน่วยความกว้าง จาก นิ้วเป็นเซนติเมตร
            $paper_print_area_width = CalculetFnc::convertInToCm($paper['paper_print_area_width']); //ความกว้าง
            //แปลงหน่วยความยาว จาก นิ้วเป็นเซนติเมตร
            $paper_print_area_length = CalculetFnc::convertInToCm($paper['paper_print_area_length']); //ความยาว
            //หาจำนวนชิ้นงานแนวตั้ง
            $vertical_lay_total = CalculetFnc::calculateVerticalLayWidth($paper_print_area_width, $this->paperWidth, $paper_print_area_length, $this->paperLenght); //แนวตั้ง
//            $vertical_lay_total = round($vertical_lay_total, 2);
            //หาจำนวนชิ้นงานแนวนอน
            $horizon_lay_total = CalculetFnc::calculateHorizonLayWidth($paper_print_area_width, $this->paperWidth, $paper_print_area_length, $this->paperLenght); //แนวนอน
//            $horizon_lay_total = round($horizon_lay_total, 2);
            //ขนาดกระดาษจากฐานข้อมูล = กว้าง x ยาว (นิ้ว)
            $size = $paper['paper_print_area_width'] * $paper['paper_print_area_length']; // in
            // หาการวางงานที่ได้จำนวนเยอะที่สุด
            $job_per_sheet = $this->compareLay($vertical_lay_total, $horizon_lay_total);
            // จำนวนแผ่นพิมพ์ (จำนวนที่รับจากหน้าจอ/การวางงานที่ได้จำนวนเยอะที่สุด) + เผื่อกระดาษ
            $start_print_sheet_total = $job_per_sheet <= 0 ? 0 : round($model['cust_quantity'] / $job_per_sheet);
            $print_sheet_total = $start_print_sheet_total + $this->print_sheet_total;

            $is_mod = !($job_per_sheet % 2);
            if ($this->printTwoPage && $is_mod) { //พิมพ์ 2 หน้า 
                $print_sheet_total = $print_sheet_total * 2;
            }
            // จำนวนกระดาษแผ่นใหญ่ ( จำนวนแผ่นพิมพ์ total / paper_cut)
            $big_sheet_total = $print_sheet_total / $paper['paper_cut'];
            //เช็คว่าถ้าไม่มีไดคัทให้เพิ่มค่าตัด
            $cutting_price = 0;
            if (!$this->isDicut) {
                $cutting_price = (($vertical_lay_total + 1) + ($horizon_lay_total + 1)) * 10;
            }
            // หาราคาเพลท
            $place = CalculetFnc::calculatePricePlace($paper['paper_print_area_width'], $paper['paper_print_area_length'], $this->fourColors, $this->oneColors);
//            if ($this->printTwoPage) { //พิมพ์ 2 หน้า 
//                $place['place_price'] = ($place['place_price'] * 2);
//            }
            // ค่ากระดาษ 
            $paper_price = $big_sheet_total * $paperDetail['paper_price'];

            // หาค่าวิ่ง
            $printing_price = $this->findPrintingPrice($print_prices, $place, $print_sheet_total);

            //ค่าพิมพ์ขั้นต้น
            $print_price_start = $paper_price + $printing_price;

            $paper_cut_size = $paper['paper_print_area_width'] . 'x' . $paper['paper_print_area_length'];
            $cal_job_per_sheets[$paper_cut_size] = [
                'job_per_sheet' => $job_per_sheet,
                'size' => $size,
                'paper_cut' => $paper,
                'paper_print_area_width_cm' => $paper_print_area_width,
                'paper_print_area_length_cm' => $paper_print_area_length,
                'paper_detail' => $paperDetail,
                'vertical_lay_total' => $vertical_lay_total,
                'horizon_lay_total' => $horizon_lay_total,
                'big_sheet_total' => $big_sheet_total,
                'start_print_sheet_total' => $start_print_sheet_total,
                'print_sheet_total' => $print_sheet_total,
                'cutting_price' => $cutting_price,
                'place' => $place,
                'paper_price' => $paper_price,
                'printing_price' => $printing_price,
                'is_mod' => (!($job_per_sheet % 2) && $job_per_sheet != 0), // true = เลขคู่ ,false = เลขคี่
                'price' => $job_per_sheet > 0 ? round((($model['cust_quantity'] / $job_per_sheet) / $paper['paper_cut']) * $paperDetail['paper_price'], 2) : 0,
                'print_price_start' => $print_price_start,
                'paperWidth' => $this->paperWidth,
                'paperLenght' => $this->paperLenght
            ];
        }
        return $cal_job_per_sheets;
    }

    private function compareLay($vertical, $horizontal) { // (แนวตั้ง, แนวนอน)
        $job_per_sheet = 0;
        if ($vertical > $horizontal) { //ถ้ากระดาษแนวตั้งมากกว่าแนวนอน ให้ใช้ขนาดแนวตั้ง
            $job_per_sheet = $vertical;
        } else {
            $job_per_sheet = $horizontal; //ถ้ากระดาษแนวตั้งน้อยกว่าแนวนอน ให้ใช้ขนาดแนวนอน
        }
        return (int) $job_per_sheet;
    }

    private function findMaxJopPersheet($cal_per_sheets) {
        // หาจำนวนชิ้นงานที่มีค่ามากสุด
        $max_per_sheet = max($cal_per_sheets);
        return $max_per_sheet;
    }

    private function findMinPriceStart($cal_per_sheets) {
        // หาค่าพิมพ์งานขั้นต้น min
        $min_price_start = min($cal_per_sheets);
        return $min_price_start;
    }

    private function getCalculatePaperSize($cal_job_per_sheets, $cal_per_sheets, $max_per_sheet, $paperDetail) {
        $model = $this->model;
        //หาค่าที่ซ้ำกัน
        $duplicates = [];
        $cal_paper_sizes = [];
        foreach (array_count_values($cal_per_sheets) as $val => $per_sheet) {
            if ($per_sheet > 1) {
                $duplicates[] = $val;
            }
        }

        //ตรวจสอบหาชิ้นงานที่มีค่ามากสุด ในกลุ่มชิ้นงาน
        if (count($duplicates) > 0 && in_array($max_per_sheet, $duplicates)) {
            $papers = [];
            foreach ($cal_job_per_sheets as $key => $job_per_sheet) {
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
            if ($paper) {
                $cal_paper_sizes[] = $paper;
            }
        } else {
            // หาค่าสูงสุด
            $paper = null;
            foreach ($cal_job_per_sheets as $key => $job_per_sheet) {
                if ($job_per_sheet['job_per_sheet'] == $max_per_sheet) {
                    $paper = $job_per_sheet;
                    break;
                }
            }
            if ($paper) {
                $cal_paper_sizes[] = $paper;
            }
        }
        return $cal_paper_sizes;
    }

    // ค่าพิมพ์งานขั้นต้น
    private function getCalculatePriceStart($cal_job_per_sheets, $min_price_start) {
        $model = $this->model;
        //
        $cal_paper_sizes = [];
        $paper = null;
        foreach ($cal_job_per_sheets as $key => $item) {
            if ($item['print_price_start'] == $min_price_start) {
                $paper = $item;
                break;
            }
        }
        if ($paper) {
            $cal_paper_sizes[] = $paper;
        }
        return $cal_paper_sizes;
    }

    private function getPaperMinPrice($cal_paper_sizes) { //ราคากระดาษต่ำสุดที่ใช้คำนวณ
        $paper = null;
        if ($cal_paper_sizes) {
            $paper_prices = ArrayHelper::getColumn($cal_paper_sizes, 'price');
            $min_price = min($paper_prices);
            foreach ($cal_paper_sizes as $key => $cal_paper_size) {
                if ($cal_paper_size['price'] == $min_price) {
                    $paper = $cal_paper_size;
                    break;
                }
            }
        }
        return $paper;
    }

    private function getPaperMinPriceStart($cal_paper_sizes) { //ราคากระดาษต่ำสุดที่ใช้คำนวณ
        $paper = null;
        if ($cal_paper_sizes) {
            $paper_prices = ArrayHelper::getColumn($cal_paper_sizes, 'print_price_start');
            $min_price = min($paper_prices);
            foreach ($cal_paper_sizes as $key => $cal_paper_size) {
                if ($cal_paper_size['print_price_start'] == $min_price) {
                    $paper = $cal_paper_size;
                    break;
                }
            }
        }
        return $paper;
    }

    //หาราคาค่าวิ่งงานตามจำนวนรอบ
    public function findPrintingPrice($print_prices, $place, $print_sheet_total) {

        $place_cut = $place['place_cut'];
        $printing_price = 0;
        foreach ($print_prices as $key => $print_price) {
            if ($print_sheet_total <= $print_price['print_sheet_qty'] && $place_cut == $print_price['print_paper_cut']) {
                $printing_price = $print_price['price'];
                break;
            } else if ($print_sheet_total > 10000) {
                if ($place_cut == 2) {
                    $printing_price = ($print_sheet_total / 1000) * 850;
                } elseif ($place_cut == 3) {
                    $printing_price = ($print_sheet_total / 1000) * 660;
                } elseif ($place_cut == 4) {
                    $printing_price = ($print_sheet_total / 1000) * 470;
                }
            }
        }
//        if ($this->printTwoPage) { //พิมพ์ 2 หน้า 
//            $printing_price = ($printing_price * 2);
//        }
        return $printing_price;
    }

    ######################## เคลือบ ########################

    public $laminate_price = 0; //ราคาเคลือบ
    public $coating = null; // ไซต์เคลือบที่ได้จากการเปรียบเทียบ

    public function findCoating() {
        $model = $this->model;
        $paper = $this->paper; // กระดาษที่หาได้
        if ($this->isCoating && $paper) {
            $coating_prices = TblCoatingPrice::find()->all(); //ราคาเคลือบ
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //บวกเริ่มต้นที่ 20 ใบ และบวกเพิ่ม 20 ใบ ทุก ๆ 1000 แผ่นพิมพ์
            $sq = $paper['size'];
            $result = CalculetFnc::calculateCoatingPrice($coating_prices, $model['coating_id'], $sq, $paper['start_print_sheet_total']);
            $this->laminate_price = $result['laminate_price'];
            $this->coating = $result['coating'];

            if ($this->coatingTwoPage) { //เคลือบ 2 หน้า
                $this->laminate_price = $this->laminate_price * 2;
            }
            // ตรวจสอบราคาขั้นต่ำ 300
            if ($this->laminate_price < 300) {
                $this->laminate_price = 300;
            }
        }
        $this->findFoilPrice();
    }

    ######################## ปั๊มฟอยล์ ########################

    public $foil_price = 0; //ราคาฟอยล์
    public $foil_color_price = 0; // ค่าสีฟอยล์ ต่อ ตรน.
    public $block_foil_price = 0; //ค่าบล๊อกปั๊มฟอยล์
    public $sqFoilSize = 0; //ตารางนิ้วที่ต้องการปั๊ม

    public function findFoilPrice() {
        $model = $this->model;
        if ($model['foil_status'] == 'Y' && $this->paper) {

            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //บวกเริ่มต้นที่ 20 ใบ และบวกเพิ่ม 20 ใบ ทุก ๆ 1000 แผ่นพิมพ์
            $sqFoilSize = 0;
            $foil_size_width = $model['foil_size_width'];
            $foil_size_height = $model['foil_size_height'];

            if ($model['foil_size_unit'] == 2) { // หน่วยเป็นเซน
                $foil_size_width = CalculetFnc::convertCmToIn($model['foil_size_width']);
                $foil_size_height = CalculetFnc::convertCmToIn($model['foil_size_height']);
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
            $this->foil_color_price = ArrayHelper::getValue($foil_color_prices, $model['foil_color_id'], 0); //ค่าสีต่อตารางเมตร
            //ราคาสีฟอยล์ * ขนาดฟอยล์(นิ้ว) * จำนวนที่ลูกค้าต้องการ
            $this->foil_price = $this->foil_color_price * $sqFoilSize * $model['cust_quantity'];

            if ($this->foil_price < 300) { //ราคาขั้นต่ำปั๊มฟอยล์ 300
                $this->foil_price = 300;
            }
            $this->foil_price = $this->block_foil_price + $this->foil_price + 100; //ค่าบล๊อกฟอยล์ + ราคาฟอยล์ + ค่าขนส่งบล๊อก
            if ($this->foilTwoPage) {
                $this->foil_price = $this->foil_price * 2;
            }
        }
        $this->findEmbossPrice();
    }

    ######################## การปั๊มนูน ########################

    public $emboss_price = 0; // ราคาปั๊มนูน
    public $block_emboss_price = 0;  //ค่าบล๊อกปั๊มนูน

    public function findEmbossPrice() {
        $model = $this->model;
        if ($model['emboss_status'] == 'Y' && $this->paper) {
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //บวกเริ่มต้นที่ 20 ใบ และบวกเพิ่ม 20 ใบ ทุก ๆ 1000 แผ่นพิมพ์

            $sqeEbossSize = 0; // ขนาด ตรน
            $emboss_size_width = $model['emboss_size_width'];
            $emboss_size_height = $model['emboss_size_height'];

            if ($model['emboss_size_unit'] == 2) { // หน่วยเป็นเซนติเมตร
                $emboss_size_width = CalculetFnc::convertCmToIn($model['emboss_size_width']);
                $emboss_size_height = CalculetFnc::convertCmToIn($model['emboss_size_height']);
            }
            $sqeEbossSize = $emboss_size_width * $emboss_size_height; // ตรน ที่ลูกค้ากำหนด

            if ($sqeEbossSize >= 30) { //ขนาด 30 ตารางนิ้วขึ้นไป
                $this->block_emboss_price = $sqeEbossSize * 18; //ตารางนิ้วละ 18 บาท
            } else {
                $block_prices = TblEmbossPrice::find()->all(); //ราคาบล๊อกปั๊มนูน
                $this->block_emboss_price = CalculetFnc::calculateBlockEmboss($block_prices, $sqeEbossSize);
            }
            $this->emboss_price = $model['cust_quantity'] * 0.3; // คำนวณค่าปั๊มนูนใบละ 0.3 คูณจำนวนงานพิมพ์
            if ($this->emboss_price < 300) { //ราคาขั้นต่ำปั๊มนูน 300
                $this->emboss_price = 300;
            }
            $this->block_emboss_price = $this->block_emboss_price * 2;
            $this->emboss_price = $this->block_emboss_price + $this->emboss_price + 100; //ค่าบล๊อกปั๊มนูน + ราคาปั๊มนูน + ค่าขนส่งบล๊อก
            if ($this->embossTwoPage) {
                $this->emboss_price = $this->emboss_price * 2;
            }
        }
    }

    ######################## ไดคัท ########################

    public $dicut_price = 0;  //ราคาไดคัท
    public $block_dicut_price = 0;  //ราคาบล๊อกไดคัท

    public function findDicutPrice() {
        $paper = $this->paper; // กระดาษที่หาได้
        $isSticker = false;
        if ($this->isDicut && $this->paper) {
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //บวกเริ่มต้นที่ 20 ใบ และบวกเพิ่ม 20 ใบ ทุก ๆ 1000 แผ่นพิมพ์
            $isSticker = $paper['paper_detail']['stk_flag'] == 'Y';
            if ($this->isDicutDefault) { //ไดคัทตามรูปแบบ
                $params = [
                    'isSticker' => $isSticker, // สติ๊กเกอร์
                    'cal_print_sheet_total' => $paper['start_print_sheet_total'], // จำนวนแผ่นพิมพ์
                    'dicut_price' => $this->dicut_price, // ราคาไดคัท
                    'job_per_sheet' => $paper['job_per_sheet'], // ชิ้นงานที่วางได้
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

    ######################## มีการปะกาว ########################

    public $glue_price = 0; // ราคาปะกาว

    public function findGluePrice() {
        $model = $this->model;
        $paper = $this->paper; // กระดาษที่หาได้
        if ($this->isGlue && $this->paper) {
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 20); //บวกเริ่มต้นที่ 20 ใบ และบวกเพิ่ม 20 ใบ ทุก ๆ 1000 แผ่นพิมพ์

            $this->glue_price = $paper['start_print_sheet_total'] * 0.3; //คำนวณค่าปะกาวตามจำนวนจริง (ข้อ 4) คุณด้วย 0.3 (ขั้นต่ำ 300 บาท)
            if ($this->glue_price < 300) {//ราคาขั้นต่ำการปะกาว
                $this->glue_price = 300;
            }
        }
    }

    ######################## มีการพับ ########################

    public $fold_price = 0; //ราคาพับ
    public $fold_block_price = 0;  //ราคาบล๊อก(พับ)

    public function findFlod() {
        $model = $this->model;
        $modelPaper = $this->modelPaper; // ประเภทกระดาษ
        $paper = $this->paper; // กระดาษที่หาได้
        $cust_quantity = $model['cust_quantity']; // จำนวนที่ลูกค้าต้องการ
        if ($this->isFold && $this->paper) {
            $this->fold_block_price = 300;
            if ($modelPaper['paper_gram'] >= 200) {
                if ($paper['start_print_sheet_total'] <= 50) {
                    $this->fold_price = $paper['start_print_sheet_total'] * 20;
                } else {
                    $this->print_sheet_total = $this->print_sheet_total + 5;  //บวกเผื่อกระดาษ
                    $this->fold_price = $paper['start_print_sheet_total'] * 0.3;
                    if ($this->fold_price < 200) { //ราคาขั้นต่ำ 200
                        $this->fold_price = 200;
                    }
                    $this->fold_price = $this->fold_block_price + $this->fold_price;
                }
            } else { //กระดาษบาง
                $modelFold = $this->modelFold;
                if ($cust_quantity <= 500) {
                    $this->fold_price = $cust_quantity * 0.50 * $modelFold['fold_count']; //จำนวนลูกค้าต้องการ *0.50*จำนวนมุม
                } else {
                    $fold_count_price = 0;
                    switch ($modelFold['fold_count']) {  //หาราคาค่าพับ ตามจำนวนพับ
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
                    if ($cust_quantity > 500 && $cust_quantity < 1000) { //มากกว่า 500 และน้อยกว่า 1000 ชิ้น คิดตามราคาค่าพับพันละ
                        $this->fold_price = $fold_count_price;
                    } else {
                        $this->fold_price = ($cust_quantity / 1000) * $fold_count_price;  //มากกว่า 1000 เอาจำนวนที่ลูกค้าต้องการ / 1000 * ราคาค่าพับพันละ
                    }
                    if ($this->fold_price < 300) { //ราคาขั้นต่ำการพับ 300
                        $this->fold_price = 300;
                    }
                }
            }
        }
    }

    ######################## ราคาเชือกร้อยถุง ########################

    public $rope_price = 0; // ราคาเชือกร้อยถุง

    public function findRopePrice() {
        if ($this->isBag && $this->model['rope'] == 1 && $this->paper) { //มีเชือกร้อยถุง
            $this->rope_price = $this->model['cust_quantity'] * 4;  //จำนวนที่ลูกค้าต้องการ + 4(ค่าร้อยเชือก)
        }
    }

    ######################## ราคาประกอบถุงกระดาษ ########################

    public $glue_bag_price = 0;

    public function findGlueBagPrice() { //ราคาประกอบถุงกระดาษ
        if ($this->isBag && $this->paper) {
            $rows = (new \yii\db\Query())
                    ->select(['tbl_glue.*'])
                    ->from('tbl_glue')
                    ->all();

            $width = CalculetFnc::convertCmToIn($this->paperWidth);
            $lenght = CalculetFnc::convertCmToIn($this->paperLenght);
            $size = $width * $lenght;
            $glue_bag_price = 0;
            foreach ($rows as $row) {
                $glueSize = $row['glue_size_width'] * $row['glue_size_lenght']; //ขนาดจากฐานข้อมูล กว้าง * ยาว
                if ($size <= $glueSize) {
                    $glue_bag_price = $row['glue_price'];
                    break;
                }
            }
            $this->glue_bag_price = $glue_bag_price > 0 ? $this->model['cust_quantity'] * $glue_bag_price : 0;
        }
    }

    ######################## เข้าเล่ม ########################

    public $book_binding_price = 0; //ราคาเข้าเล่ม

    public function findBookBindingPrice() {
        if ($this->isvoucher && $this->model['book_binding_status'] == 1) { //เข้าเล่มบัตรกำนัล/คูปอง/voucher
            $this->book_binding_price = round($this->model['cust_quantity'] / $this->model['book_binding_qty']) * 2;  //จำนวนที่ลูกค้าต้องการ + 2 (ค่าเข้าเล่ม)
        }
    }

    ########################ราคา running number########################

    public $running_number_price = 0; //ราคา running number

    public function findRunningNumberPrice() {
        $paper = $this->paper;
        if ($this->model['running_number'] == '1' && !empty($paper)) { //มี runningnumber
            $this->running_number_price = $paper['start_print_sheet_total'] * 5;   //จำนวนกระดาษทที่ยังไม่เผื่อกระดาษ + 5(ค่า unning number)
        }
    }

    ########################คิดราคาปรุฉีก########################

    public $perforated_ripped_price = 0; //ราคาปรุฉีก
    public $block_perforated_ripped = 300; //ราคา block

    public function findPerforatedRippedPrice() {
        $paper = $this->paper;
        if ($this->model['perforated_ripped'] == 1 && !empty($paper)) { //มีปรุฉีก
            if ($paper['start_print_sheet_total'] <= 50) { // ไม่เกิน 50 แผ่น คิดใบละ 5 บาท 
                $this->perforated_ripped_price = $paper['start_print_sheet_total'] * 5;
            } else { // ถ้าเกิน 50 แผ่น ให้คิดค่าบล็อค 300 แล้วคิดค่าปรุอีกใบละ 0.3 บาท 
                $this->perforated_ripped_price = ($paper['start_print_sheet_total'] * 0.3) + $this->block_perforated_ripped;
            }

            if ($this->perforated_ripped_price < 300) { //ราคาขั้นต่ำปรุฉีก
                $this->perforated_ripped_price = 300;
            }
        }
    }

    ########################คิดราคาติดหน้าต่างกล่อง########################

    public $window_box_price = 0; //ราคาติดหน้าต่างกล่อง
    public $plastic_price = 0; //ราคาพลาสติก

    public function findWindowBoxPrice() {  //ติดหน้าต่างกล่อง
        $product = $this->modelProduct;

        if ($this->model['window_box'] == 1 && $this->paper) {
            $sqeWindowSize = 0;
            $window_box_width = $this->model['window_box_width'];
            $window_box_lenght = $this->model['window_box_lenght'];
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal($this->print_sheet_total, 20, 10); //บวกเริ่มต้นที่ 20 ใบ และบวกเพิ่ม 20 ใบ ทุก ๆ 1000 แผ่นพิมพ์

            if ($this->model['window_box_unit'] == 2) {//เซนติเมตร
                $window_box_width = CalculetFnc::convertCmToIn($this->model['window_box_width']);
                $window_box_lenght = CalculetFnc::convertCmToIn($this->model['window_box_lenght']);
            }

            $sqeWindowSize = $window_box_width * $window_box_lenght; // ตรน ที่ลูกค้ากำหนด

            if ($sqeWindowSize > 0) { //ขนาด 1 ตารางนิ้ว
                $this->plastic_price = $sqeWindowSize * 0.04; //ค่าพลาสติก ตารางนิ้วละ 0.04 บาท
            }
            if ($this->plastic_price < 0.50) { //ถ้าราคาไม่ถึง 50 สตางค์ 
                $this->plastic_price = $sqeWindowSize * 0.50;
            }
            $this->window_box_price = $this->plastic_price + 1;  //ค่าพลาสติก + ค่าติดหน้าต่าง

            if ($this->window_box_price < 1.50) { //ตรวจสอบราคาขั้นต่ำ ค่าพลาสติก + ค่าติดหน้าต่าง (น้อยกว่า 1.50 ให้คิด 1.50)
                $this->window_box_price = 1.50;
            }
            $this->window_box_price = $this->model['cust_quantity'] * $this->window_box_price; //จำนวนที่ลูกค้าต้องการ * ราคาติดหน้าต่าง
        }
    }

    ########################คิดราคาประกบกล่องลูกฟูก########################

    public $corrugated_box_price = 0; //ราคาประกบกล่องลูกฟูก
    public $width_feet; //กว้างฟุต
    public $lenght_feet; //ยาวฟุต
    public $corrugated_box_size = 0; //ขนาดกล่องลูกฟูก

    public function findCorrugatedBoxPrice() { //ราคาประกบกล่องลูกฟูก
        $product = $this->modelProduct;
        if (ArrayHelper::isIn($product['package_type_id'], [66]) && ArrayHelper::isIn($product['product_category_id'], [17]) && $this->paper) {
            $this->print_sheet_total = CalculetFnc::calculatePrintSheetTotal2($this->print_sheet_total, 20, 5); //บวกเริ่มต้นที่ 20 ใบ และบวกเพิ่ม 5 ใบ ทุก ๆ 100 แผ่นพิมพ์
            $this->width_feet = CalculetFnc::convertCmToFt($this->paperWidth); //กว้าง
            $this->lenght_feet = CalculetFnc::convertCmToFt($this->paperLenght); //ยาว
            $this->corrugated_box_size = $this->width_feet * $this->lenght_feet; //ขนาดกล่องลูกฟูก = กว้าง * ยาว

            if ($this->corrugated_box_size > 0) {
                if ($this->corrugated_box_size < 2) { //ขั้นต่ำ 2 ตารางฟุต 
                    $this->corrugated_box_price = 2 * 3; // 2 ตารางฟุต * 3 บาท
                } else {
                    $this->corrugated_box_price = ($this->corrugated_box_size * 3); // ขนาดจากหน้าจอ * ราคาตารางฟุตละ 3 บาท 
                }
                $this->corrugated_box_price = $this->model['cust_quantity'] * $this->corrugated_box_price; //จำนวนที่ลูกค้าต้องการ * ค่าประกบลูกฟูก
            }

            if ($this->corrugated_box_price < 1000) { //ราคาขั้นต่ำค่าประกบลูกฟูก
                $this->corrugated_box_price = 1000;
            }
        }
    }

    ########################คิดราคาปะกาวกล่อง########################

    public $gluing_box_price = 0;

    public function findGluingBoxPrice() { //ปะกาวกล่อง
        $product = $this->modelProduct;
        if (ArrayHelper::isIn($product['package_type_id'], [54, 66]) && ArrayHelper::isIn($product['product_category_id'], [17]) && $this->paper) {
            $rows = (new \yii\db\Query())
                    ->select(['tbl_assemble_box.*'])
                    ->from('tbl_assemble_box')
                    ->all();

            $paperHight = $this->model['paper_size_height']; //สูง
            if ($this->model['paper_size_unit'] == 2) {//เซนติเมตร
                $paperHight = CalculetFnc::convertCmToIn($this->model['paper_size_height']);
            }

            $gluing_box_price = 0;
            foreach ($rows as $row) {
                $gluingBoxHight = $row['assemble_box_size_height']; //ขนาดจากฐานข้อมูลความสูง
                if ($paperHight <= $gluingBoxHight) {
                    $gluing_box_price = $row['assemble_box_price'];
                    break;
                }
            }
            $this->gluing_box_price = $gluing_box_price > 0 ? $this->model['cust_quantity'] * $gluing_box_price : 0;

            if ($this->gluing_box_price < 300) { //ราคาขั้นต่ำปะกล่อง
                $this->gluing_box_price = 300;
            }
        }
    }

    ######################## กระดาษแผ่นใหญ่ ########################

    public $paper_bigsheet = 0;  //กระดาษแผ่นใหญ่
    public $final_paper_price = 0;  // ราคากระดาษ

    public function findPaperBigsheet() {
        $paper = $this->paper; // กระดาษที่หาได้
        if ($paper) {
            if ($this->print_sheet_total != 0 && $paper['paper_cut']['paper_cut'] != 0) {
                $this->paper_bigsheet = round($this->print_sheet_total / $paper['paper_cut']['paper_cut'], 0); //จำนวนแผ่นพิมพ์ที่บวกเผื่อ / (ขนาดกระดาษที่ตัด) 
            }
            $this->final_paper_price = round($this->paper_bigsheet * $paper['paper_detail']['paper_price']); //หาราคากระดาษ จำนวนกระดาษแผ่นใหญ่ * ราคากระดาษจากฐานข้อมูล
        }
    }

    //หาค่าพิมพ์งานตามจำนวนรอบ
    public $printing_price = 0;

    public function findPrintingPriceTotal() {
        $print_prices = TblPrintPrice::find()->all(); //ราคาค่าพิมพ์(ค่าวิ่งงาน)
        $paper = $this->paper; // กระดาษที่หาได้

        if ($paper) {
            $place_cut = $paper['place']['place_cut'];
            foreach ($print_prices as $key => $print_price) {
                if ($this->print_sheet_total <= $print_price['print_sheet_qty'] && $place_cut == $print_price['print_paper_cut']) {
                    $this->printing_price = $print_price['price'];
                    break;
                } else if ($this->print_sheet_total > 10000) {
                    if ($place_cut == 2) {
                        $this->printing_price = ($this->print_sheet_total / 1000) * 850;
                    } elseif ($place_cut == 3) {
                        $this->printing_price = ($this->print_sheet_total / 1000) * 660;
                    } elseif ($place_cut == 4) {
                        $this->printing_price = ($this->print_sheet_total / 1000) * 470;
                    }
                }
            }
            if (count($this->job_per_sheets_mod) == 0 && $this->printTwoPage) { //วางงานเลขคู่ไม่ได้ และเป็นพิมพ์ 2 หน้า 
                $this->printing_price = ($this->printing_price * 2);
            }
        }
    }

    ######################## เอาราคาทั้งหมดมาบวกกัน ########################

    public $final_price_offset = 0;
    public $price_per_item_offset = 0; // ราคาต่อชื้น
    public $final_price = 0; // รวมราคา

    public function summaryPrice() { //คำนวนราคาทั้งหมด 
        $paper = $this->paper; // กระดาษที่หาได้
        if ($paper) {
            $this->final_price_offset = $paper['place']['place_price'] + //ราคาเพลท
                    $this->final_paper_price + //ราคากระดาษ
                    $this->printing_price + //ราคาวิ่งงาน
                    $this->laminate_price + //ราคาเคลือบ
                    $this->dicut_price + //ราคาไดคัท
                    $this->fold_price + //ราคาพับ
                    $this->emboss_price + //ราคาปั๊มนูน
                    $this->glue_price + //ราคาปะกาว
                    $this->foil_price + //ราคาฟอยล์
                    $paper['cutting_price'] + //ราคาค่าตัด 
                    $this->rope_price + //ราคามีเชือกร้อยถุง
                    $this->glue_bag_price + //ราคาค่าประกอบถุง
                    $this->book_binding_price + //ราคาเข้าเล่ม
                    $this->running_number_price + //ราคา running number
                    $this->perforated_ripped_price + // ราคาปรุฉีก
                    $this->window_box_price + //ราคาติดหน้าต่างกล่อง
                    $this->corrugated_box_price + //ราคา ปะกบกล่องลูกฟูก
                    $this->gluing_box_price // ราคาปะกล่อง
            ;



            $final_price_offset_percent = ($this->final_price_offset / 100 ) * 20;  //ค่าบริการจัดการ 20%
            $this->final_price_offset = $this->final_price_offset + $final_price_offset_percent;

            //ราคาต่อชิ้น offset
            $price_per_item_offset = $this->final_price_offset / $this->model['cust_quantity'];
            $price_per_item_offset_decimal = (int) substr(number_format($price_per_item_offset, 2), -2);
            if ($price_per_item_offset_decimal < 90 && $price_per_item_offset_decimal > 0) {
                $price_per_item_offset_decimal = (ceil($price_per_item_offset_decimal / 10)) * 10;
                $price_per_item_offset = (int) $price_per_item_offset . '.' . $price_per_item_offset_decimal;
            } else {
                $price_per_item_offset = ceil($price_per_item_offset);
            }
            $this->price_per_item_offset = $price_per_item_offset;
            $this->final_price = ($price_per_item_offset * $this->model['cust_quantity']);
            //คำนวนราคาทั้งหมด (ค่าเพลท + ราคาเคลือบ + ราคาฟอยล์ + ราคาปั๊มนูน + ราคาไดคัท + ราคาปะกาว + ราคาพับ + ราคากระดาษ )
        }
    }

    public function getAttributeValue() {
        return [
            'สินค้า [modelProduct]' => $this->modelProduct,
            'ขนาด [modelPaperSize]' => $this->modelPaperSize,
            'ประเภทกระดาษ [modelPaper]' => $this->modelPaper,
            'ขนาดกระดาษ [paperSize]' => $this->paperSize,
            '1. งานพิมพ์' => [
                'สีที่พิมพ์ [modelColorPrint]' => $this->modelColorPrint,
                'พิมพ์หน้าเดียว [printOnePage]' => $this->printOnePage,
                'พิมพ์สองหน้า [printTwoPage]' => $this->printTwoPage,
                'งาน 1 สี [oneColors]' => $this->oneColors,
                'งาน 2 สี [twoColors]' => $this->twoColors,
                'งาน 4 สี [fourColors]' => $this->fourColors,
                'ใช้ Box [isBox]' => $this->isBox,
                'ความกว้าง (cm) [paperWidth]' => $this->paperWidth,
                'ความยาว (cm) [paperLenght]' => $this->paperLenght,
                'คูปอง[isvoucher]' => $this->isvoucher,
            ],
            '6 เคลือบ' => [
                'ข้อมูลเคลือบ [modelCoating]' => $this->modelCoating,
                'เคลือบ, ไม่เคลือบ [isCoating]' => $this->isCoating,
                'เคลือบด้านเดียว [coatingOnePage]' => $this->coatingOnePage,
                'เคลือบสองด้าน [coatingTwoPage]' => $this->coatingTwoPage,
                'ราคาเคลือบ [laminate_price]' => $this->laminate_price,
                'ไซต์เคลือบที่ได้จากการเปรียบเทียบ [coating]' => $this->coating,
            ],
            '7 ปั๊มฟอยล์' => [
                'หน่วยฟอยล์ [modelFoilUnit]' => $this->modelFoilUnit,
                'สีฟอยล์ [modelFoilColor]' => $this->modelFoilColor,
                'ปั๊มฟอยล์,ไม่ปั๊มฟอยล์ [isFoil]' => $this->isFoil,
                'ปั๊มฟอยล์ หน้าเดียว [foilOnePage]' => $this->foilOnePage,
                'ปั๊มฟอยล์ หน้า-หลัง [isDicutDefault]' => $this->foilTwoPage,
                'ราคาฟอยล์ [foil_price]' => $this->foil_price,
                'ค่าสีฟอยล์ ต่อ ตรน. [foil_color_price]' => $this->foil_color_price,
                'ค่าบล๊อกปั๊มฟอยล์ [block_foil_price]' => $this->block_foil_price,
                'ตารางนิ้วที่ต้องการปั๊ม [sqFoilSize]' => $this->sqFoilSize,
            ],
            '8 ปั๊มนูน' => [
                'ปั๊มนูน/ไม่ปั๊มนูน [isEmboss]' => $this->isEmboss,
                'ปั๊มนูน หน้าเดียว [embossOnePage]' => $this->embossOnePage,
                'ปั๊มนูน หน้า-หลัง [embossTwoPage]' => $this->embossTwoPage,
                'ราคาปั๊มนูน [emboss_price]' => $this->emboss_price,
                'ค่าบล๊อกปั๊มนูน [block_emboss_price]' => $this->block_emboss_price,
                'หน่วยปั๊มนูน [modelEmbossUnit]' => $this->modelEmbossUnit,
            ],
            '9 ไดคัท' => [
                'ไดคัท [modelDiCut]' => $this->modelDiCut,
                'ไดคัท, ไม่ไดคัท [isDicut]' => $this->isDicut,
                'ไดคัทตามรูปแบบ [isDicutDefault]' => $this->isDicutDefault,
                'ราคาไดคัท [dicut_price]' => $this->dicut_price,
                'ราคาบล๊อกไดคัท [block_dicut_price]' => $this->block_dicut_price,
            ],
            '10 ปะกาว' => [
                'ราคาปะกาว [glue_price]' => $this->glue_price,
                'ปะกาว/ไม่ปะกาว [isGlue]' => $this->isGlue,
            ],
            '13 พับ' => [
                'พับ/ไม่พับ [isFold]' => $this->isFold,
                'วิธีพับ [modelFold]' => $this->modelFold,
                'ราคาพับ [fold_price]' => $this->fold_price,
                'ราคาบล๊อก(พับ) [fold_block_price]' => $this->fold_block_price,
            ],
            '14 เจาะ' => [
                'มุมที่เจาะ [modelPerforateOptiont]' => $this->modelPerforateOptiont,
                'ตัดเป็นตัว/เจาะ [perforate]' => $this->perforate,
            ],
            '0.1[paperDetails]' => $this->paperDetails,
            '0.2[paper_sizes]' => $this->paper_sizes,
            '0.3[job_per_sheets]' => $this->job_per_sheets,
            '0.4[job_per_sheets_mod]' => $this->job_per_sheets_mod,
            '0.5[cal_paper_sizes]' => $this->cal_paper_sizes,
            '0.6[paper]' => $this->paper,
            'จำนวนแผ่นพิมพ์ที่เผื่อแล้ว [print_sheet_total]' => $this->print_sheet_total,
            'final_price_offset' => $this->final_price_offset,
            'กระดาษแผ่นใหญ่ [paper_bigsheet]' => $this->paper_bigsheet,
            'ราคากระดาษ [final_paper_price]' => $this->final_paper_price,
            'ค่าพิมพ์งาน [printing_price]' => $this->printing_price,
            'ราคาต่อชื้น [price_per_item_offset]' => $this->price_per_item_offset,
            'รวมราคา [final_price]' => $this->final_price,
            'final_price_offset' => $this->final_price,
            'price_per_item_offset' => $this->price_per_item_offset,
            'ราคามีเชือกร้อยหู' => $this->rope_price,
            'ราคาค่าประกอบถุง' => $this->glue_bag_price,
            'ราคาเข้าเล่ม' => $this->book_binding_price,
            'ราคาrunning_number' => $this->running_number_price,
            'ราคาปรุฉีก' => $this->perforated_ripped_price,
            'ค่าติดหน้าต่างกล่อง' => $this->window_box_price,
            'ราคาปะกบกล่องลูกฟูก' => $this->corrugated_box_price,
            'ราคาปะกาวกล่อง' => $this->gluing_box_price,
            'model' => $this->model
        ];
    }

}
