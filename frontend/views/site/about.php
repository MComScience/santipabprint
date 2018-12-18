<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@kidz/views/layouts/breadcrumbs') ?>
<!-- ====================================
    ——— MAIN SECTION
    ===================================== -->
<section class="mainContent full-width clearfix aboutSection">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-push-6 col-xs-12">
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="//www.youtube.com/embed/fFxmf36k5Hc"></iframe>
                </div>
            </div>
            <div class="col-sm-6 col-sm-pull-6 col-xs-12">
                <div class="schoolInfo">
                    <h2>เกี่ยวกับเรา</h2>
                    <p>บริษัทสันติภาพแพ็คพริ้นท์จำกัด เป็นหนึ่งในผู้นำด้านอุตสาหกรรมการพิมพ์และบรรจุภัณฑ์ในเขตภาคเหนือ
                        บริษัทเริ่มก่อตั้งในปี พ.ศ.2518 และมีการขยายกิจการอย่างต่อเนื่อง
                        จนปัจจุบันสามารถให้บริการครอบคลุมทุกขั้นตอนของกระบวนการพิมพ์ ตั้งแต่ขั้นตอนก่อนพิมพ์
                        ขั้นตอนการพิมพ์ และขั้นตอนหลังพิมพ์ ด้วยเทคโนโลยีและเครื่องจักรรุ่นใหม่
                        ทันสมัยที่สุดในภาคเหนือ</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================
——— COLOR SECTION
===================================== -->
<section class="mainContent full-width clearfix">
    <div class="container">
        <div class="sectionTitle text-center">
            <h2>
                <span class="shape shape-left bg-color-4"></span>
                <span>ประวัติของเรา</span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="accordionCommon" id="accordionOne">
                    <div class="panel-group" id="accordionFirst">
                        <div class="panel panel-default">
                            <a class="panel-heading accordion-toggle bg-color-1" data-toggle="collapse"
                               data-parent="#accordionFirst" href="#collapse-s-1">
                                <span>2557</span>
                                <span class="iconBlock iconTransparent"><i class="fa fa-chevron-down"></i></span>
                                <span class="separator"></span>
                            </a>
                            <div id="collapse-s-1" class="panel-collapse">
                                <div class="panel-body">
                                    <p>
                                        <strong>
                                            ขยายเครื่องจักรด้านการพิมพ์ดิจิตอล (Digital Printing) ด้วยเครื่องพิมพ์ FUJI XEROX Color 1000 Press
                                        </strong>
                                        ขยายเครื่องจักรด้านการพิมพ์ดิจิตอล (Digital Printing) ด้วยเครื่องพิมพ์ FUJI XEROX Color 1000 Press รองรับงานพิมพ์ Print on Demand การพิมพ์เปลี่ยนแปลงข้อมูลและรูปภาพ (1:1 Personalized Printing) และสิ่งพิมพ์ที่ต้องการความปลอดภัยสูง (Security Printing)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <a class="panel-heading accordion-toggle bg-color-1" data-toggle="collapse"
                               data-parent="#accordionFirst" href="#collapse-s-3">
                                <span>2549</span>
                                <span class="iconBlock iconTransparent"><i class="fa fa-chevron-down"></i></span>
                                <span class="separator"></span>
                            </a>
                            <div id="collapse-s-3" class="panel-collapse">
                                <div class="panel-body">
                                    <p>
                                        <strong>
                                            ขยายโรงงานและจดทะเบียนเป็น “บริษัท สันติภาพแพ็คพริ้นท์ จำกัด”
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xs-12">
                <div class="accordionCommon" id="accordionTwo">
                    <div class="panel-group" id="accordionSecond">
                        <div class="panel panel-default">
                            <a class="panel-heading accordion-toggle bg-color-1" data-toggle="collapse"
                               data-parent="#accordionSecond" href="#collapse-s-2">
                                <span>2556</span>
                                <span class="iconBlock iconTransparent"><i class="fa fa-chevron-down"></i></span>
                                <span class="separator"></span>
                            </a>
                            <div id="collapse-s-2" class="panel-collapse">
                                <div class="panel-body">
                                    <p>
                                        <strong>
                                            เพิ่มการลงทุนเครื่องปั๊มไดคัทอัตโนมัติและเครื่องไดคัทขึ้นรูปตัวอย่าง
                                        </strong>
                                        เพิ่มการลงทุนเครื่องปั๊มไดคัทอัตโนมัติและเครื่องไดคัทขึ้นรูปตัวอย่าง เพื่อรองรับความต้องการด้านงานพิมพ์บรรจุภัณฑ์ได้อย่างครบวงจร
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <a class="panel-heading accordion-toggle bg-color-1" data-toggle="collapse"
                               data-parent="#accordionSecond" href="#collapse-s-4">
                                <span>2537</span>
                                <span class="iconBlock iconTransparent"><i class="fa fa-chevron-down"></i></span>
                                <span class="separator"></span>
                            </a>
                            <div id="collapse-s-4" class="panel-collapse">
                                <div class="panel-body">
                                    <p>
                                        <strong>
                                            ย้ายโรงงานมาอยู่ ณ ที่อยู่ปัจจุบัน
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

