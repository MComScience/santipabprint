<?php

namespace common\components;

use common\components\CalculetFnc;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblPaperCut;
use common\modules\app\models\TblPaperDetail;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblPaperType;
use common\modules\app\models\TblPrintPrice;
use common\modules\app\models\TblProduct;
use common\modules\settings\models\TblCoatingPrice;
use common\modules\settings\models\TblEmbossPrice;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class CalculateDigital extends Component {

    public $model;
    public $paperWidth = 0;
    public $paperLenght = 0;
    public $paperHight = 0;
    private $paper;
    private $paper_type;
    private $paper_detail;
    public $oneColors = false; // งาน 1 สี
    public $twoColors = false; // งาน 2 สี
    public $fourColors = false; // งาน 4 สี
    public $isSticker = false; //สติ๊กเกอร์
    // หาจำนวนชิ้นงานที่วางได้ใน 1 ใบพิมพ์
    public $paper_cut = 0; //กระดาษตัด
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
            $this->findRopePrice();
            $this->findGlueBagPrice();
            $this->findBookBindingPrice();
            $this->findRunningNumberPrice();
            $this->findPerforatedRippedPrice();
            $this->findWindowBoxPrice();
            $this->findCorrugatedBoxPrice(); //ปะกบกล่องลูกฟูก
            $this->findGluingBoxPrice();
            // $this->findPrintingPrice(); ไม่ต้องคิด คิดเฉพาะoffset
            $this->findPaperBigsheet();
            $this->summaryPrice();
        }
    }

    //ตรวจสอบพิมพ์งานกี่สี
    public function checkPrintingColor() {
        $colorPrinting = null;
        if (!empty($this->model['print_color'])) {
            $colorPrinting = TblColorPrinting::findOne($this->model['print_color']);
        }
        // if (!empty($this->model['after_print'])) {
        //     $colorPrinting = TblColorPrinting::findOne($this->model['after_print']);
        // }
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

    public $product = null;
    public $is_bag = false;
    public $paperWidthIN;
    public $paperLenghtIN;
    public $is_voucher = false;

    public function checkPaperSize() {
        $messages = $this->messages;
        $messages .= '===== หาขนาดกระดาษที่จะนำไปคำนวณ =====';
        $product = TblProduct::findOne($this->model['product_id']);
        $this->product = $product;
        if ($this->model['paper_size_id'] == 'custom') { // กำหนดเอง
            $messages .= '-:เป็นขนาดกำหนดเอง\n';
            //สินค้าเป็นประเภทกล่อง อยู่ในกลุ่มสินค้าบรรจุภัณฑ์
            $is_box = false;
            if (ArrayHelper::isIn($product['package_type_id'], [54, 66]) && ArrayHelper::isIn($product['product_category_id'], [17, 17])) {
                $is_box = true;
                $this->model['diecut'] = 'Default';
            }
            $is_bag = false; //ถุงกระดาษ
            if ($product['package_type_id'] == 36 && $product['product_category_id'] == 6) {
                $is_bag = true;
                $this->is_bag = true;
            }
            $is_voucher = false; //บัตรกำนัล/คูปอง/Voucher
            if ($product['package_type_id'] == 44 && $product['product_category_id'] == 12) {
                $is_voucher = true;
                $this->is_voucher = true;
            }
            //ขนาดสินค้า รับค่าจากหน้าจอ มีหน่วยเป็นนิ้ว
            if ($this->model['paper_size_unit'] == 3) {

                $messages .= "-:รับขนาดมาเป็นนิ้ว {$this->model['paper_size_width']} x {$this->model['paper_size_lenght']}x {$this->model['paper_size_height']} นิ้ว\n";

                if ($is_box) { //กล่อง
                    $paperWidth = CalculetFnc::convertInToCm($this->model['paper_size_width']); //กว้าง
                    $paperLenght = CalculetFnc::convertInToCm($this->model['paper_size_lenght']); // ยาว
                    $paperHight = CalculetFnc::convertInToCm($this->model['paper_size_height']); // สูง

                    $this->paperWidth = (($paperWidth * 2) + ($paperLenght * 2)) + 0.635; //ความกว้าง = (กว้าง * 2 (2ด้าน))+(ความยาว * 2 (2ด้าน)) + 0.635 เผื่ดติดกาว(แปลงจาก0.25นิ้ว)
                    $this->paperLenght = $paperHight + ($paperWidth * 2) + 1.27; //ความยาว = ความสูง + (ความกว้าง*2) + 1.27 ส่วนพับ(แปลงจาก 0.5 นิ้ว)
                } else if ($is_bag) { //ถุง
                    $paperWidth = CalculetFnc::convertInToCm($this->model['paper_size_width']); //กว้าง
                    $paperLenght = CalculetFnc::convertInToCm($this->model['paper_size_lenght']); // ยาว
                    $paperHight = CalculetFnc::convertInToCm($this->model['paper_size_height']); // สูง

                    $this->paperWidth = (($paperWidth * 2) + ($paperLenght * 2)) + 1.27; //ความกว้าง = (กว้าง * 2 (2ด้าน))+(ความยาว * 2 (2ด้าน)) +  เผื่ดติดกาว(แปลงจาก 0.5 นิ้ว)
                    $this->paperLenght = $paperHight + $paperWidth + 3.81; //ความยาว = ความสูง + ความกว้าง + ส่วนพับ(แปลงจาก 1.5 นิ้ว)
                } else {
                    $this->paperWidth = CalculetFnc::convertInToCm($this->model['paper_size_width']);
                    $this->paperLenght = CalculetFnc::convertInToCm($this->model['paper_size_lenght']);
                }
                $this->paperWidthIN = CalculetFnc::convertCmToIn($this->paperWidth);
                $this->paperLenghtIN = CalculetFnc::convertCmToIn($this->paperLenght);
                //
                $messages .= "-:แปลงขนาดจากนิ้วเป็นเซนติเมตร ได้ขนาด {$this->paperWidth} x {$this->paperLenght}";
            } else {
                $messages .= "-:รับขนาดมา {$this->model['paper_size_width']} x {$this->model['paper_size_lenght']} เซนติเมตร\n";

                if ($is_box) {//กล่อง
                    $paperWidth = $this->model['paper_size_width']; //กว้าง
                    $paperLenght = $this->model['paper_size_lenght']; // ยาว
                    $paperHight = $this->model['paper_size_height']; // สูง

                    $this->paperWidth = (($paperWidth * 2) + ($paperLenght * 2)) + 0.635;
                    $this->paperLenght = $paperHight + ($paperWidth * 2) + 1.27;
                } else if ($is_bag) { //ถุงกระดาษ
                    $paperWidth = $this->model['paper_size_width']; //กว้าง
                    $paperLenght = $this->model['paper_size_lenght']; // ยาว
                    $paperHight = $this->model['paper_size_height']; // สูง

                    $this->paperWidth = (($paperWidth * 2) + ($paperLenght * 2)) + 1.27;
                    $this->paperLenght = $paperHight + $paperWidth + 3.81;
                } else {
                    $this->paperWidth = $this->model['paper_size_width'];
                    $this->paperLenght = $this->model['paper_size_lenght'];
                }
            }
            if ($this->model['fold_id'] === 'FOLD-00001') { //เช็คว่าถ้ามีการพับครึ่ง
                $messages .= "-:มีการพับครึ่ง\n";
            }
            $messages .= '-:บวก 0.3 เซนติเมตร\n';
            $sizes = CalculetFnc::calculateWidthLength($this->model['fold_id'], $this->model['paper_size_unit'], $this->paperWidth, $this->paperLenght);
            $this->paperWidth = $sizes['width'];
            $this->paperLenght = $sizes['length'];
            $this->paperWidthIN = CalculetFnc::convertCmToIn($this->paperWidth);
            $this->paperLenghtIN = CalculetFnc::convertCmToIn($this->paperLenght);
            //
            $messages .= "-:เช็คเงื่อนไข แปลงค่าหน่วยกระดาษที่รับค่าจากหน้าจอได้ขนาด {$this->paperWidth} x {$this->paperLenght}\n";
        } else {
            $messages .= "-:เป็นขนาดจากฐานข้อมูล\n";

            //หาขนาดกระดาษจากฐานข้อมูล
            $paper = TblPaperSize::findOne($this->model['paper_size_id']);

            if ($paper) {
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
            }

            $sizes = CalculetFnc::calculateWidthLength($this->model['fold_id'], $this->model['paper_size_id'], $this->paperWidth, $this->paperLenght);
            $this->paperWidth = $sizes['width'];
            $this->paperLenght = $sizes['length'];
            if ($this->model['fold_id'] === 'FOLD-00001') { //เช็คว่าถ้ามีการพับครึ่ง
                $messages .= "-:มีการพับครึ่ง นำความกว้างไปคูณ 2\n";
            }
            $messages .= '-:บวก 0.6 เซนติเมตร\n';
            $messages .= "-:เช็คเงื่อนไข แปลงค่าหน่วยกระดาษที่รับค่าจากหน้าจอได้ขนาด {$this->paperWidth} x {$this->paperLenght}\n";
        }
        $this->messages = $messages;
    }

    public $job_per_sheets = [];

    public function findJobPerSheet() {
        $isDicut = !empty($this->model['diecut']) && $this->model['diecut'] != 'N';
        $messages = $this->messages;
        $messages .= '===== หาการวางชิ้นงานที่ได้จำนวนเยอะที่สุด =====';

        $model = $this->model;
        $paper = TblPaper::findOne($model['paper_id']);
        $paperDetails = TblPaperDetail::find()->where(['paper_id' => $model['paper_id']])->groupBy('paper_size')->all();
        $messages .= "-:กระดาษ " . Json::encode($paper);

        $paperType = TblPaperType::findOne($paper['paper_type_id']);
        $messages .= "-:ประเภทกระดาษ " . Json::encode($paperType);
        $per_sheets = [];
        $job_per_sheets = [];

        $cal_paper_sizes = [];
        foreach ($paperDetails as $key => $paperDetail) {
            if ($paperDetail['stk_flag'] != 'N') { //เป็นสติ๊กเกอร์
                $this->isSticker = true;
            }
            $calPapers = []; //ขนาดกระดาษที่นำไปคำนวน

            if ($this->isSticker) { //เป็นสติ๊กเกอร์
                $calPapers = TblPaperCut::find()->where([
                            'paper_type' => 'digital',
                            'paper_sticker' => 1,
                            'paper_size' => $paperDetail['paper_size'],
                        ])->all();
            } else {
                $calPapers = TblPaperCut::find()->where([
                            'paper_type' => 'digital',
                            'paper_sticker' => 0,
                            'paper_size' => $paperDetail['paper_size'],
                        ])->all();
            }
            $cal_job_per_sheets = [];
            $cal_per_sheets = [];

            foreach ($calPapers as $calPaper) {
                //แปลงหน่วยความกว้าง จาก นิ้วเป็นเซนติเมตร
                $paper_print_area_width = CalculetFnc::convertInToCm($calPaper['paper_print_area_width']); //ความกว้าง
                //แปลงหน่วยความยาว จาก นิ้วเป็นเซนติเมตร
                $paper_print_area_length = CalculetFnc::convertInToCm($calPaper['paper_print_area_length']); //ความยาว
                //หาจำนวนชิ้นงานแนวตั้ง
                $vertical_lay_total = CalculetFnc::calculateVerticalLayWidth($paper_print_area_width, $this->paperWidth, $paper_print_area_length, $this->paperLenght, $isDicut); //แนวตั้ง
                //หาจำนวนชิ้นงานแนวนอน
                $horizon_lay_total = CalculetFnc::calculateHorizonLayWidth($paper_print_area_width, $this->paperWidth, $paper_print_area_length, $this->paperLenght, $isDicut); //แนวนอน
                //ขนาดกระดาษจากฐานข้อมูล = กว้าง x ยาว (นิ้ว)
                $size = $calPaper['paper_print_area_width'] * $calPaper['paper_print_area_length'];
                // หาการวางงานที่ได้จำนวนเยอะที่สุด
                $job_per_sheet = 0;

                //เช็คว่าถ้าไม่มีไดคัทให้เพิ่มค่าตัด
                $cutting_price = 0;
                if ($this->model['diecut'] == 'N' || empty($this->model['diecut'])) {
                    $cutting_price = (($vertical_lay_total + 1) + ($horizon_lay_total + 1)) * 10;
                }

                if ($vertical_lay_total > $horizon_lay_total) { //ถ้ากระดาษแนวตั้งมากกว่าแนวนอน ให้ใช้ขนาดแนวตั้ง
                    $job_per_sheet = (int) $vertical_lay_total;
                } else {
                    $job_per_sheet = (int) $horizon_lay_total; //ถ้ากระดาษแนวตั้งน้อยกว่าแนวนอน ให้ใช้ขนาดแนวนอน
                }
                $cal_job_per_sheets[] = [
                    'job_per_sheet' => $job_per_sheet,
                    'size' => $size,
                    'paper_size_id' => $calPaper['paper_size_id'],
                    'paper_cut' => $calPaper['paper_cut'],
                    'paper_print_area_width' => $calPaper['paper_print_area_width'],
                    'paper_print_area_length' => $calPaper['paper_print_area_length'],
                    'paper_print_area_width_cm' => $paper_print_area_width,
                    'paper_print_area_length_cm' => $paper_print_area_length,
                    'vertical_lay_total' => $vertical_lay_total,
                    'horizon_lay_total' => $horizon_lay_total,
                    'paper_size' => $calPaper['paper_size'],
                    'paper_type' => $calPaper['paper_type'],
                    'paper_sticker' => $calPaper['paper_sticker'],
                    'paper_detail' => $paperDetail,
                    'cutting_price' => $cutting_price
                ];
            }
            if ($cal_job_per_sheets) {
                $this->job_per_sheets[] = $cal_job_per_sheets;

                $new_cal_job_per_sheets = [];
                foreach ($cal_job_per_sheets as $item) {
                    if ($item['job_per_sheet'] > 0) {
                        $new_cal_job_per_sheets[] = $item;
                    }
                }
                if ($new_cal_job_per_sheets) {
                    ArrayHelper::multisort($new_cal_job_per_sheets, ['job_per_sheet', 'job_per_sheet'], [SORT_ASC, SORT_ASC]);
                    $cal_per_sheets = ArrayHelper::getColumn($new_cal_job_per_sheets, 'job_per_sheet');

                    // หาจำนวนชิ้นงานที่มีค่ามากสุด
                    $max_per_sheet = max($cal_per_sheets);

                    //หาค่าที่ซ้ำกัน
                    $duplicates = [];
                    foreach (array_count_values($cal_per_sheets) as $val => $per_sheet) {
                        if ($per_sheet > 1) {
                            $duplicates[] = $val;
                        }
                    }

                    //ตรวจสอบหาชิ้นงานที่มีค่ามากสุด ในกลุ่มชิ้นงาน
                    if (count($duplicates) > 0 && in_array($max_per_sheet, $duplicates)) {
                        $papers = [];
                        foreach ($new_cal_job_per_sheets as $key => $job_per_sheet) {
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
                            $paper['price'] = 0;
                            if ($model['cust_quantity'] != 0 && $paper['job_per_sheet'] != 0 && $paper['paper_cut'] != 0) {
                                $paper['price'] = (($model['cust_quantity'] / $paper['job_per_sheet']) / $paper['paper_cut'] ) * $paperDetail['paper_price'];
                            }
                            $cal_paper_sizes[] = $paper;
                        }
                    } else {
                        // หาค่าสูงสุด
                        $paper = null;
                        foreach ($new_cal_job_per_sheets as $key => $job_per_sheet) {
                            if ($job_per_sheet['job_per_sheet'] == $max_per_sheet) {
                                $paper = $job_per_sheet;
                                break;
                            }
                        }
                        if ($paper) {
                            $paper['price'] = 0;
                            if ($model['cust_quantity'] != 0 && $paper['job_per_sheet'] != 0 && $paper['paper_cut'] != 0) {
                                $paper['price'] = (($model['cust_quantity'] / $paper['job_per_sheet']) / $paper['paper_cut']) * $paperDetail['paper_price'];
                            }

                            $cal_paper_sizes[] = $paper;
                        }
                    }
                }
            }
        }

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

        if ($paper != null) {
            if ($paper['paper_detail']['stk_flag'] != 'N') { //เป็นสติ๊กเกอร์
                $this->isSticker = true;
            } else {
                $this->isSticker = false;
            }
            $this->job_per_sheet = $paper['job_per_sheet'];
            $this->print_area_width = $paper['paper_print_area_width'];
            $this->print_area_length = $paper['paper_print_area_length'];
            $this->paper_cut = $paper['paper_cut'];
            $this->paper_size = $paper['paper_size'];
            $this->paper_detail = $paper['paper_detail'];
            $this->paper = $paper;
        }

        if ($this->job_per_sheet != 0 && $model['cust_quantity'] != 0) {
            $this->print_sheet_total = $this->job_per_sheet > 0 ? round($model['cust_quantity'] / $this->job_per_sheet) : 0; //คำนวณหาจำนวนแผ่นพิมพ์
        }
        $this->cal_print_sheet_total = $this->print_sheet_total;

        $this->messages = $messages;
    }

    //หาราคาเคลือบ
    public $laminate_price = 0; //ราคาเคลือบ
    public $coating = null;

    public function findCoating() {

        if (!empty($this->model['coating_id']) && $this->model['coating_id'] != 'N' && $this->paper) { //ถ้ามีเคลือบ
            $coating_prices = TblCoatingPrice::find()->orderBy('coating_sq_in asc')->all(); //ราคาเคลือบ
            $this->print_sheet_total = $this->print_sheet_total + 2; //จำนวนแผ่นพิมพ์ + เผื่อกระดาษ
            $sq = $this->paper['size'];
            $result = CalculetFnc::calculateCoatingPrice($coating_prices, $this->model['coating_id'], $sq, $this->cal_print_sheet_total);
            $this->laminate_price = $result['laminate_price'];
            $this->coating = $result['coating'];
            //ถ้าเคลือบสองหน้า
            if ($this->model['coating_option'] == 'two_page') { //เคลือบ 2 หน้า
                $this->laminate_price = $this->laminate_price * 2;
            }
            // ตรวจสอบราคาขั้นต่ำ 200
            if ($this->laminate_price < 200) {
                $this->laminate_price = 200;
            }
        }
    }

    // การปั๊มฟอยล์
    public $foil_price = 0; //ราคาฟอยล์
    public $foil_color_price = 0; // ค่าสีฟอยล์ ต่อ ตรน.
    public $block_foil_price = 0; //ค่าบล๊อกปั๊มฟอยล์
    public $sqFoilSize = 0; //ตารางนิ้วที่ต้องการปั๊ม

    public function findFoilPrice() {
        if ($this->model['foil_status'] == 'Y' && $this->paper) {

            $this->print_sheet_total = $this->print_sheet_total + 5; //บวกเผื่อกระดาษ
            $sqFoilSize = 0;
            $foil_size_width = $this->model['foil_size_width'];
            $foil_size_height = $this->model['foil_size_height'];
            if ($this->model['foil_size_unit'] == 2) {
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
    public $block_emboss_price = 0; //ค่าบล๊อกปั๊มนูน

    public function findEmbossPrice() {
        if ($this->model['emboss_status'] == 'Y' && $this->paper) {
            $sqeEbossSize = 0;
            $this->print_sheet_total = $this->print_sheet_total + 5; // เผื่อกระดาษ
            $emboss_size_width = $this->model['emboss_size_width'];
            $emboss_size_height = $this->model['emboss_size_height'];

            if ($this->model['paper_size_unit'] == 2) {//เซนติเมตร
                $emboss_size_width = CalculetFnc::convertCmToIn($this->model['emboss_size_width']);
                $emboss_size_height = CalculetFnc::convertCmToIn($this->model['emboss_size_height']);
            }
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

    // มีการพับ
    public $fold_price = 0; //ราคาพับ
    public $fold_block_price = 300; //ราคาบล๊อก

    public function findFlod() {
        $details = $this->flod_detail;
        if (!empty($this->model['fold_id']) && $this->model['fold_id'] !== 'N' && $this->paper) {
            if ($this->paper_type['paper_gram'] >= 200) {
                if ($this->cal_print_sheet_total <= 50) {
                    $this->fold_price = $this->cal_print_sheet_total * 20; //จำนวนที่คำนวนได้ * 20
                } else {
                    $this->print_sheet_total = $this->print_sheet_total + 5; //บวกเผื่อกระดาษ
                    $this->fold_price = $this->cal_print_sheet_total * 0.3;
                    if ($this->fold_price < 200) {
                        $this->fold_price = 200;
                    }
                    $this->fold_price = $this->fold_block_price + $this->fold_price; //ราคาบล๊อกพับ + ราคาพับ
                }
            } else { //กระดาษบาง(คำนวณจากค่าที่รับจากหน้าจอ/ลูกค้าต้องการ)
                $fold = TblFold::findOne($this->model['fold_id']);
                if ($this->model['cust_quantity'] <= 500) {
                    $this->fold_price = $this->model['cust_quantity'] * 0.50 * $fold['fold_count']; //จำนวนลูกค้าต้องการ *0.50*จำนวนมุม
                } else {
                    $fold_count_price = 0;
                    switch ($fold['fold_count']) { //หาราคาค่าพับ ตามจำนวนพับ
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
                        $this->fold_price = ($this->model['cust_quantity'] / 1000) * $fold_count_price; //มากกว่า 1000 เอาจำนวนที่ลูกค้าต้องการ / 1000 * ราคาค่าพับพันละ
                    }
                    if ($this->fold_price < 300) { //ราคาขั้นต่ำการพับ 300
                        $this->fold_price = 300;
                    }
                }
            }
            $details = [
                'fold_block_price' => $this->fold_block_price,
                'fold_price' => $this->fold_price,
            ];
        }
        $this->flod_detail = $details;
    }

    //ไดคัท
    public $dicut_price = 0; //ราคาไดคัท
    public $block_dicut_price = 0; //ราคาบล๊อกไดคัท

    public function findDicutPrice() {
        
        if (!empty($this->model['diecut']) && $this->model['diecut'] != 'N' && $this->paper) {
            if ($this->model['diecut'] == 'Curve') { // ไดคัทมุมม
                $diecut_curve = (new \yii\db\Query())
                        ->select(['tbl_diecut.*', 'tbl_diecut_group.*'])
                        ->from('tbl_diecut')
                        ->innerJoin('tbl_diecut_group', 'tbl_diecut_group.diecut_group_id = tbl_diecut.diecut_group_id')
                        ->where(['tbl_diecut.diecut_id' => $this->model['diecut_id']])
                        ->one();

                $params = [
                    'cust_quantity' => $this->model['cust_quantity'], // จำนวนที่ลูกค้าต้องการ
                    'curve' => $diecut_curve, // ไดคัทมุมมน
                    'print_area_width' => $this->print_area_width, //ขนาดความกว้าง
                    'print_area_length' => $this->print_area_length, //ขนาดความยาว
                    'dicut_price' => $this->dicut_price, // ราคาไดคัท
                    'block_dicut_price' => $this->block_dicut_price, // ราคาบล๊อกไดคัท
                ];
                $result = CalculetFnc::calculateDicutCurveDigital($params);
                $this->block_dicut_price = $result['block_dicut_price']; // ราคาบล๊อกไดคัท
                $this->dicut_price = $result['dicut_price']; // ราคาไดคัท
            } else if ($this->model['diecut'] == 'Default') { //ไดคัทตามรูปแบบ
                $params = [
                    'isSticker' => $this->isSticker, // สติ๊กเกอร์
                    'cal_print_sheet_total' => $this->cal_print_sheet_total, // จำนวนแผ่นพิมพ์
                    'dicut_price' => $this->dicut_price, // ราคาไดคัท
                    'job_per_sheet' => $this->job_per_sheet, // ชิ้นงานที่วางได้
                    'print_sheet_total' => $this->print_sheet_total, // จำนวนแผ่นพิมพ์เผื่อ
                    'block_dicut_price' => $this->block_dicut_price, // ราคาบล๊อกไดคัท
                ];
                $result = CalculetFnc::calculateDicutDefaultDigital($params);
                $this->block_dicut_price = $result['block_dicut_price']; // ราคาบล๊อกไดคัท
                $this->dicut_price = $result['dicut_price']; // ราคาไดคัท
                $this->print_sheet_total = $result['print_sheet_total']; // จำนวนแผ่นพิมพ์ที่เผื่อ
            }
        }
    }

    // มีการปะกาว
    public $glue_price = 0;

    public function findGluePrice() {
        if ($this->model['glue'] == 1 && $this->paper) {
            $this->glue_price = $this->cal_print_sheet_total * 0.3; //จำนวนกระดาษทที่ยังไม่เผื่อกระดาษ * 0.3
            if ($this->glue_price < 300) { //ราคาขั้นต่ำปะกาว
                $this->glue_price = 300;
            }
        }
    }

    public $rope_price = 0; // ราคาเชือกร้อยถุง

    public function findRopePrice() {
        if ($this->is_bag && $this->model['rope'] == 1 && $this->paper) { //มีเชือกร้อยถุง
            $this->rope_price = $this->model['cust_quantity'] * 4;  //จำนวนที่ลูกค้าต้องการ + 4(ค่าร้อยเชือก)
        }
    }

    public $glue_bag_price = 0;

    public function findGlueBagPrice() { //ราคาประกอบถุงกระดาษ
        if ($this->is_bag && $this->paper) {
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

    public $book_binding_price = 0; //ราคา

    public function findBookBindingPrice() {
        if ($this->is_voucher && $this->model['book_binding_status'] == 1) {//เข้าเล่มบัตรกำนัล/คูปอง/voucher
            $this->book_binding_price = round($this->model['cust_quantity'] / $this->model['book_binding_qty']) * 2;  //จำนวนที่ลูกค้าต้องการ + 2 (ค่าเข้าเล่ม)
        }
    }

    public $running_number_price = 0; //ราคา running number

    public function findRunningNumberPrice() {//มี running number
        if ($this->model['running_number'] == 1 && $this->paper) { //มี runningnumber
            $this->running_number_price = $this->cal_print_sheet_total * 5;   //จำนวนกระดาษทที่ยังไม่เผื่อกระดาษ + 5(ค่า unning number)
        }
    }

    public $perforated_ripped_price = 0; //ราคาปรุฉีก
    public $block_perforated_ripped = 300; //ราคา block

    public function findPerforatedRippedPrice() { //ปรุฉีก
        if ($this->model['perforated_ripped'] == 1 && $this->paper) { //มีปรุฉีก
            if ($this->cal_print_sheet_total <= 50) { // ไม่เกิน 50 แผ่น คิดใบละ 5 บาท 
                $this->perforated_ripped_price = $this->cal_print_sheet_total * 5;
            } else { // ถ้าเกิน 50 แผ่น ให้คิดค่าบล็อค 300 แล้วคิดค่าปรุอีกใบละ 0.3 บาท 
                $this->perforated_ripped_price = ($this->cal_print_sheet_total * 0.3) + $this->block_perforated_ripped;
            }

            if ($this->perforated_ripped_price < 300) { //ราคาขั้นต่ำปรุฉีก
                $this->perforated_ripped_price = 300;
            }
        }
    }

    public $window_box_price = 0; //ราคาติดหน้าต่างกล่อง
    public $plastic_price = 0; //ราคาพลาสติก

    public function findWindowBoxPrice() {  //ติดหน้าต่างกล่อง
        $product = $this->product;

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

    public $corrugated_box_price = 0; //ราคาประกบกล่องลูกฟูก
    public $width_feet; //กว้างฟุต
    public $lenght_feet; //ยาวฟุต
    public $corrugated_box_size = 0; //ขนาดกล่องลูกฟูก

    public function findCorrugatedBoxPrice() { //ราคาประกบกล่องลูกฟูก
        $product = $this->product;
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

    public $gluing_box_price = 0;

    public function findGluingBoxPrice() { //ปะกาวกล่อง
        $product = $this->product;
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

    //คำนวณค่าพิมพ์  ตรวจสอบจากหน้าจอว่าลูกค้าเลือกพิมพ์สองหน้า หรือหน้าเดียว
    public $print_one_page = false; //พิมพ์หน้าเดียว
    public $print_two_page = false; //พิมพ์สองหน้า
    public $printing_color_price = 0;

    public function findPrintingColorPrice() {
        if ($this->model['print_option'] == 'two_page') { //พิมพ์ 2 หน้า
            $this->print_two_page = true;
        }
        if ($this->model['print_option'] == 'one_page') { //พิมพ์ 1 หน้า
            $this->print_one_page = true;
        }
        if ($this->print_one_page) { //พิมพ์ 1 หน้า
            if ($this->model['print_color'] == 'PT-00005') { //สีดำ
                $this->printing_color_price = $this->cal_print_sheet_total * 5;
            } else {
                $this->printing_color_price = $this->cal_print_sheet_total * 20;
            }
        } else if ($this->print_two_page) {
            if ($this->model['print_color'] == 'PT-00005') { //สีดำ
                $this->printing_color_price = (($this->cal_print_sheet_total * 5) * 2);
            } else {
                $this->printing_color_price = (($this->cal_print_sheet_total * 20) * 2);
            }
        }
    }

    // หาราคากระดาษแผ่นใหญ่
    public $paper_bigsheet = 0; //กระดาษแผ่นใหญ่
    public $final_paper_price = 0; // ราคากระดาษ

    public function findPaperBigsheet() {
        $paper_bigsheet = $this->print_sheet_total > 0 && $this->paper_cut > 0 ? $this->print_sheet_total / $this->paper_cut : 0;
        $this->paper_bigsheet = round($paper_bigsheet, 0); //จำนวนแผ่นพิมพ์ที่บวกเผื่อดาษ / (ขนาดกระดาษที่ตัด)
        $this->final_paper_price = round($this->paper_bigsheet * $this->paper_detail['paper_price']); //หาราคากระดาษ จำนวนกระดาษแผ่นใหญ่ * ราคากระดาษจากฐานข้อมูล
    }

    /*
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
     */

    //เอาราคาทั้งหมดมาบวกกัน
    public $final_price_digital = 0;

    public function summaryPrice() { //คำนวนราคาทั้งหมด
        $isDicut = !empty($this->model['diecut']) && $this->model['diecut'] != 'N';
        $cutting_price = 0;
        if ($this->paper) {
            if (!$isDicut) {
                $cutting_price = $this->paper['cutting_price'];
            }
            $this->final_price_digital = $this->final_paper_price + $this->printing_color_price +
                    $this->laminate_price + $this->dicut_price +
                    $this->fold_price + $this->emboss_price + $this->glue_price + $this->foil_price +
                    $cutting_price + $this->rope_price + $this->glue_bag_price + $this->book_binding_price +
                    $this->running_number_price + $this->perforated_ripped_price + $this->window_box_price +
                    $this->corrugated_box_price + $this->gluing_box_price;
            /* +$this->printing_price */

            $final_price_digital_percent = ($this->final_price_digital / 100) * 20; //ค่าบริการจัดการ 20%

            $this->final_price_digital = $this->final_price_digital + $final_price_digital_percent;
        }
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
            //      'ราคาค่าพิมพ์งาน(วิ่ง)' => $this->printing_price,
            'ราคาตัด' => $this->paper ? $this->paper['cutting_price'] : 0,
            'ราคากระดาษ' => $this->final_paper_price,
            'กระดาษแผ่นใหญ่' => $this->paper_bigsheet,
            'ราคารวมทั้งหมดฝั่งดิจิตอล' => $this->final_price_digital,
            'ราคารวมทั้งหมดฝั่งดิจิตอล(ปัดเศษ)' => ceil($this->final_price_digital / 10) * 10,
            'final_price_digital' => $this->final_price_digital,
            'paper' => $this->paper,
            'price_per_item_digital' => $this->final_price_digital / $this->model['cust_quantity'],
            'coating' => $this->coating,
            'ราคามีเชือกร้อยหู' => $this->rope_price,
            'ราคาค่าประกอบถุง' => $this->glue_bag_price,
            'ถุงกระดาษ' => $this->is_bag,
            'paperWidthIN' => $this->paperWidthIN,
            'paperLenghtIN' => $this->paperLenghtIN,
            'ราคาเข้าเล่ม_คูปอง' => $this->book_binding_price,
            'ราคา running_number' => $this->running_number_price,
            'ราคาปรุฉีก' => $this->perforated_ripped_price,
            'ราคาค่าติดหน้าต่างกล่อง' => $this->window_box_price,
            'ราคาปะกบกล่องลูกฟูก' => $this->corrugated_box_price,
            'ปะกาวกล่อง' => $this->gluing_box_price
        ];
    }

}
