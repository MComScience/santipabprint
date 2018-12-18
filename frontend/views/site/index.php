<?php

/* @var $this yii\web\View */

$this->title = 'หน้าหลัก';
$themeAsset = Yii::$app->assetManager->getPublishedUrl('@kidz/assets/dist');

?>
<style>
    /* Small devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        img.img-preview {
            width: 262px;
            height: 214px;
        }
    }

    .isotopeFilters2 ul.filter > li a {
        padding: 0 25px;
        height: 40px;
        font-size: 14px;
        line-height: 40px;
        color: #222;
        text-transform: uppercase;
        font-weight: 600;
        display: inline-block;
        box-shadow: 0 4px 0 rgba(0, 0, 0, .1);
        background-color: #f8f8f8;
        border-radius: 4px;
    }

    .isotopeFilters2 ul.filter > li.active a {
        background-color: #ea7066;
        color: #fff;
    }
</style>
<!--====================================
    ——— BANNER
    ===================================== -->
<section class="bannercontainer bannercontainerV1">
    <div class="fullscreenbanner-container">
        <div class="fullscreenbanner">
            <ul>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="700" data-title="Slide 1">
                    <img src="<?= Yii::getAlias('@web/images/Diary1.JPG') ?>" alt="slidebg1" data-bgfit="cover"
                         data-bgposition="center center" data-bgrepeat="no-repeat">
                    <div class="slider-caption container">
                        <div class="tp-caption rs-caption-1 sft start"
                             data-hoffset="0"
                             data-y="200"
                             data-speed="800"
                             data-start="1000"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">
                            ไดอารี่ และ สมุด
                        </div>

                        <div class="tp-caption rs-caption-2 sft"
                             data-hoffset="0"
                             data-y="265"
                             data-speed="1000"
                             data-start="1500"
                             data-easing="Power4.easeOut"
                             data-endspeed="300"
                             data-endeasing="Power1.easeIn"
                             data-captionhidden="off">
                            สิ่งพิมพ์ประเภทหนึ่งที่องค์กรส่วนใหญ่ จัดทำขึ้นเพื่อแจกให้กับลูกค้า หรือบุคคลในองค์กร
                            ใช้จดบันทึก รวมถึงเป็นของที่ระลึก โดยภายในเล่มอาจจะเพิ่มข้อมูลเกี่ยวกับบริษัท หรือสินค้า
                            รวมไปถึงความรู้ทั่วๆไป เพื่อทำให้ไดอารี่หรือสมุดโน้ตนั้น มีจุดเด่นและแตกต่าง
                        </div>
                    </div>
                </li>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 2">
                    <img src="<?= Yii::getAlias('@web/images/Book5.JPG') ?>" alt="slidebg1" data-bgfit="cover"
                         data-bgposition="center center" data-bgrepeat="no-repeat">
                    <div class="slider-caption container">
                        <div class="tp-caption rs-caption-1 sft start text-center"
                             data-hoffset="0"
                             data-x="center"
                             data-y="200"
                             data-speed="800"
                             data-start="1000"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">
                            หนังสือ และ วารสาร
                        </div>

                        <div class="tp-caption rs-caption-2 sft text-center"
                             data-hoffset="0"
                             data-x="center"
                             data-y="265"
                             data-speed="1000"
                             data-start="1500"
                             data-easing="Power4.easeOut"
                             data-endspeed="300"
                             data-endeasing="Power1.easeIn"
                             data-captionhidden="off">
                            สิ่งพิมพ์สำหรับบอกเล่าเรื่องราว เผยแพร่บทความ กิจกรรม ข่าวสารต่างๆ ทั้งภายในและภายนอกองค์กร
                            รวมไปถึงการโฆษณาประชาสัมพันธ์
                            รูปแบบหนังสือ/วารสาร มักทำเล่มแบบเย็บมุงหลังคาหรือไสสันทากาว มีหลายขนาด A4 A5 หรือใกล้เคียง
                            เนื้อหาด้านในใช้กระดาษปรู๊ฟ กระดาษปอนด์ หรือกระดาษอาร์ต
                            แล้วแต่ความเหมาะสมและงบประมาณ มีการพิมพ์ด้วยระบบออฟเซ็ทสีเดียว สองสี หรือสี่สี
                            หรือมีหลายแบบในเล่มเดียวกัน
                        </div>
                    </div>
                </li>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="700" data-title="Slide 3">
                    <img src="<?= Yii::getAlias('@web/images/Diary1.JPG') ?>" alt="slidebg1" data-bgfit="cover"
                         data-bgposition="center center" data-bgrepeat="no-repeat">
                    <div class="slider-caption container">
                        <div class="tp-caption rs-caption-1 sft start text-right"
                             data-hoffset="0"
                             data-y="200"
                             data-x="right"
                             data-speed="800"
                             data-start="1000"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">
                            การ์ด และ นามบัตร
                        </div>

                        <div class="tp-caption rs-caption-2 sft text-right"
                             data-hoffset="0"
                             data-y="265"
                             data-x="right"
                             data-speed="1000"
                             data-start="1500"
                             data-easing="Power4.easeOut"
                             data-endspeed="300"
                             data-endeasing="Power1.easeIn"
                             data-captionhidden="off">
                            การ์ดเชิญ เป็น สิ่งพิมพ์ที่ทำขึ้นเพื่อ ประชาสัมพันธ์ พิธีต่างๆที่จะเกิดขึ้น ดังนั้น
                            เนื้อหาต้อง ชัดเจน เข้าใจง่าย
                            บอกรายละเอียดวัน เวลา สถานที่จัดงาน ธึมการแต่งตัวเพื่อให้เข้ากับบรรยากาศของงานด้วย
                            ซึ่งสามารถสื่อได้จากรูปแบบของการ์ดที่จัดขึ้นทำนั่นเอง
                            นามบัตร เรียกว่าเป็นเครื่องมือที่ใช้ในการแนะนำตัว ติดต่อประสานงานกับลูกค้า
                            เป็นอีกสิ่งที่สื่อถึงภาพลักษณ์ขององค์กรที่สำคัญ
                            ข้อมูลที่ควรอยู่ในนามบัตร ได้แก่ ชื่อนาม สกุล, โลโก้, ชื่อบริษัท, ที่อยู่, เบอร์โทร, e-mail,
                            เว็บไซต์สโลแกน
                        </div>
                    </div>
                </li>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 2">
                    <img src="<?= Yii::getAlias('@web/images/Diary1.JPG') ?>" alt="slidebg1" data-bgfit="cover"
                         data-bgposition="center center" data-bgrepeat="no-repeat">
                    <div class="slider-caption container">
                        <div class="tp-caption rs-caption-1 sft start text-center"
                             data-hoffset="0"
                             data-x="center"
                             data-y="200"
                             data-speed="800"
                             data-start="1000"
                             data-easing="Back.easeInOut"
                             data-endspeed="300">
                            ใบปลิว และ แผ่นพับ
                        </div>

                        <div class="tp-caption rs-caption-2 sft text-center"
                             data-hoffset="0"
                             data-x="center"
                             data-y="265"
                             data-speed="1000"
                             data-start="1500"
                             data-easing="Power4.easeOut"
                             data-endspeed="300"
                             data-endeasing="Power1.easeIn"
                             data-captionhidden="off">

                            ใบปลิวจัดเป็นสื่อโฆษณาชนิดไดเร็คมาร์เก็ตติ้ง เพื่อเผยแพร่ข้อมูลข่าวสาร โฆษณาประชาสัมพันธ์
                            ถึงกลุ่มเป้าหมายโดยเฉพาะ นิยมใช้กระดาษขนาดมาตรฐาน A4
                            ลักษณะเด่นของแผ่นพับหรือใบปลิว คือ มีขนาดเล็ก หยิบถือได้สะดวก สามารถเก็บรวบรวมข้อมูลได้มาก
                            ค่าใช้จ่ายในการผลิตตํ่า
                            หากออกแบบให้มีลักษณะที่น่าสนใจ จะก่อให้เกิดภาพลักษณ์ที่ดีต่อสินค้าหรือบริการนั้นๆ
                            ซึ่งจูงใจให้กลุ่มเป้าหมายหยิบขึ้นมาเพื่ออ่านรายละเอียดด้านใน
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<!--====================================
——— MAIN SECTION
===================================== -->
<section class="clearfix linkSection hidden-xs">
    <div class="sectionLinkArea hidden-xs scrolling">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <a href="#content1" class="sectionLink bg-color-1" id="coursesLink">
                        <i class="fa fa-print linkIcon border-color-1" aria-hidden="true"></i>
                        <span class="linkText">ดิจิตอลพริ้นท์</span>
                        <i class="fa fa-chevron-down locateArrow" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="col-sm-4 ">
                    <a href="#content2" class="sectionLink bg-color-2" id="teamLink">
                        <i class="fa fa-book linkIcon border-color-2" aria-hidden="true"></i>
                        <span class="linkText">สิ่งพิมพ์</span>
                        <i class="fa fa-chevron-down locateArrow" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="col-sm-4 ">
                    <a href="#content3" class="sectionLink bg-color-3" id="galleryLink">
                        <i class="fa fa-cubes linkIcon border-color-3" aria-hidden="true"></i>
                        <span class="linkText">บรรจุภัณฑ์</span>
                        <i class="fa fa-chevron-down locateArrow" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!--====================================
——— FEATURE SECTION
===================================== -->
<section class="mainContent full-width clearfix featureSection">
    <div class="container">
        <div class="sectionTitle text-center ">
            <h2 class="wow fadeInUp">
                <span class="shape shape-left bg-color-4"></span>
                <span>Service</span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
        </div>

        <div class="row ">
            <div class="col-sm-6 col-lg-4 col-xs-12">
                <div class="media featuresContent wow fadeInUp">
              <span class="media-left bg-color-1">
                <i class="fa fa-book bg-color-1" aria-hidden="true"></i>
              </span>
                    <div class="media-body">
                        <h3 class="media-heading color-1">หนังสือ</h3>
                        <p>สิ่งพิมพ์สำหรับบอกเล่าเรื่องราว เผยแพร่บทความ กิจกรรมและข่าวสารต่างๆ ทั้งภายในและภายนอกองค์กร
                            รวมไปถึงการโฆษณาประชาสัมพันธ์ รูปแบบหนังสือ/วารสาร มักจะทำเล่มแบบเย็บมุงหลังคาหรือไสสันทากาว
                            ปัจจุบันมีหลายขนาด ที่นิยมมากจะเป็นขนาด A4 หรือ A5 เนื้อหาใช้ กระดาษปอนด์ , กระดาษอาร์ต
                            หรือกระดาษปรู๊ฟ แล้วแต่ความเหมาะสมและงบประมาณ มีการพิมพ์ด้วยระบบออฟเซ็ทสีเดียว สองสี
                            หรือสี่สี หรือมีหลายแบบในเล่มเดียวกัน</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xs-12">
                <div class="media featuresContent wow fadeInUp">
              <span class="media-left bg-color-2">
                <i class="fa fa-map-o bg-color-2" aria-hidden="true"></i>
              </span>
                    <div class="media-body">
                        <h3 class="media-heading color-2">แผ่นพับ</h3>
                        <p>จัดเป็นสื่อโฆษณาชนิดไดเร็คมาร์เก็ตติ้งอย่างหนึ่ง ที่ผู้ผลิตใช้เผยแพร่ข้อมูลข่าวสาร
                            โฆษณาประชาสัมพันธ์ ถึงกลุ่มเป้าหมายโดยเฉพาะ นิยมใช้ขนาด A4 หรือ A5 ทั้งนี้
                            ลักษณะเด่นของแผ่นพับหรือใบปลิว คือ มีขนาดเล็ก หยิบถือได้สะดวก สามารถเก็บรวบรวมข้อมูลได้มาก
                            หากออกแบบให้มีลักษณะการพับที่น่าสนใจ จะก่อให้เกิดภาพลักษณ์ที่ดีต่อสินค้า หรือบริการนั้นๆ
                            รวมถึงจูงใจให้ลูกค้ากลุ่มเป้าหมายหยิบขึ้นมาอ่านรายละเอียดสินค้า/บริการด้านในอีกด้วย</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xs-12">
                <div class="media featuresContent wow fadeInUp">
              <span class="media-left bg-color-3">
                <i class="fa fa-calendar bg-color-3" aria-hidden="true"></i>
              </span>
                    <div class="media-body">
                        <h3 class="media-heading color-3">ปฏิทิน</h3>
                        <p>ปัจจุบันหลายๆองค์กรมีการสร้างสรรค์ออกแบบปฏิทินให้มีความน่าสนใจละแตกต่าง
                            เพื่อเป็นของขวัญมอบให้ลูกค้าช่วงปีใหม่ รวมถึงเพื่อแย่งพื้นที่บนโต๊ะทำงานของลูกค้า
                            โดยมุ่งหวังให้แบรนด์ของตัวเองอยู่กับลูกค้าตลอด 365 วัน เพราะสมัยนี้
                            ปฏิทินไม่ได้ใช้เพียงแค่แสดงถึง วัน เดือน ปืเท่านั้น
                            แต่ยังเป็นสื่อประชาสัมพันธ์ที่ช่วยสะท้อนภาพลักษณ์ให้กับบริษัท/องค์กรที่เป็นผู้จัดทำด้วย </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4 col-xs-12">
                <div class="media featuresContent wow fadeInUp">
              <span class="media-left bg-color-4">
                <i class="fa fa-desktop bg-color-4" aria-hidden="true"></i>
              </span>
                    <div class="media-body">
                        <h3 class="media-heading color-4">ดิจิตอลพริ้นท์</h3>
                        <p>งานพิมพ์จำนวนที่น้อย ด้วยคุณภาพงานพิมพ์เทียบเท่าระบบ Offset ด้วยเครื่องพิมพ์ทันสมัย Fuji
                            Xerox ทั้งยังเพิ่มความพิเศษและทันสมัยให้กับงานพิมพ์ที่ต้องการเปลี่ยนแปลงข้อมูล (1:1
                            Personalized & Security Printing) เช่น ข้อมูล ชื่อ ที่อยู่ ข้อความหรือรูปภาพ
                            เพิ่มความเฉพาะเจาะจงให้กับลูกค้าแต่ละราย เพื่อให้เกิดความประทับใจ
                            และสามารถใช้เป็นเครื่องมือทางการการตลาดรูปแบบใหม่ที่ช่วยให้สินค้าและบริการของคุณได้รับการตอบสนองในแง่ยอดขายและการจดจำในกลุ่มลูกค้าเป้าหมายได้ดีมากขึ้น
                            นอกจากนี้ ยังรองรับสิ่งพิมพ์ที่ต้องการความปลอดภัย ป้องกันการปลอมแปลงและลอกเลียนแบบ
                            ด้วยเทคโนโลยีอันทันสมัยของเครื่องพิมพ์ที่บริษัทมีการลงทุน </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xs-12">
                <div class="media featuresContent wow fadeInUp">
              <span class="media-left bg-color-5">
                <i class="fa fa-sticky-note-o bg-color-5" aria-hidden="true"></i>
              </span>
                    <div class="media-body">
                        <h3 class="media-heading color-5">ฉลากสินค้า</h3>
                        <p>เป็นสิ่งพิมพ์ที่ใช้ติดกับตัวสินค้าเพื่อแสดงรายละเอียดและสรรพคุณต่างๆของสินค้า
                            ขนาดและรูปแบบของฉลาก (Label) จะขึ้นอยู่กับภาพลักษณ์และความเหมาะสมของสินค้านั้นๆ ทั้งนี้
                            รูปแบบหรือสีสันที่โดดเด่นของฉลากจะช่วยดึงดูดความสนใจของลูกค้ามายังตัวสินค้าได้อีกทางหนึ่ง</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xs-12">
                <div class="media featuresContent wow fadeInUp">
              <span class="media-left bg-color-6">
                <i class="fa fa-cubes bg-color-6" aria-hidden="true"></i>
              </span>
                    <div class="media-body">
                        <h3 class="media-heading color-6">บรรจุภัณฑ์</h3>
                        <p>นอกเหนือจากหน้าที่หลักคือใส่สินค้าแล้ว
                            ยังสามารถใช้เป็นสื่อประชาสัมพันธ์แสดงรูปภาพรายละเอียดของสินค้า
                            เพื่อดึงดูดความสนใจและเสริมให้สินค้าดูมีมูลค่ามากขึ้น
                            ส่วนมากนิยมผลิตกล่องขึ้นรูปเป็นลักษณะทรง 4 เหลี่ยม
                            มีระบบลิ้นสำหรับล็อคปิด-เปิดสำหรับกล่องชิ้นเดียว หรือเป็นฝาครอบหากแยกเป็น 2 ชิ้น นอกจากนั้น
                            ยังสามารถขึ้นรูปตามที่ลูกค้าต้องการ สามารถผลิตตามขนาดที่บรรจุสินค้าได้
                            โดยทั่วไปนิยมใช้กระดาษกล่องแป้ง หรือกระดาษอาร์ตการ์ด ที่ความหนา 300 แกรม ขึ้นไป</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--====================================
——— WHITE SECTION
===================================== -->
<section class="whiteSection full-width clearfix coursesSection " id="content1">
    <div class="container">
        <div class="sectionTitle text-center">
            <h2 class="wow fadeInUp">
                <span class="shape shape-left bg-color-4"></span>
                <span>Print On Demend</span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
            <p>
                บริการงานพิมพ์จำนวนที่น้อย ด้วยคุณภาพงานพิมพ์เทียบเท่าระบบ Offset ด้วยเครื่องพิมพ์ทันสมัย Fuji Xerox
                Color 1000 Press
                สามารถรองรับงานพิมพ์ที่มีขนาดสูงสุด ถึง 13 x 19 นิ้ว และกระดาษที่มีความหนาตั้งแต่ 55 – 350 แกรม
                รวมถึงเทคโนโลยีหมึกใส (Clear Ink)
                ซึ่งสามารถสร้างสรรค์ความสวยงามและแตกต่างให้งานพิมพ์ของคุณดูโดดเด่นยิ่งขึ้น
                Print On Demand จึงเป็นอีกหนึ่งทางเลือกที่ทำให้คุณสามารถสั่งพิมพ์งานตามจำนวนที่ต้องการ ไม่มีขั้นต่ำ
                ไม่ต้องเสียเงินในการทำเพลท
            </p>
        </div>

        <div class="row isotopeContainer5" id="container1">
            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector charity ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/book%20print%20on%20demand.JPG"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/book%20print%20on%20demand.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector nature ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/photobook.JPG"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/photobook.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector nature ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/photobook1.JPG"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/photobook1.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector charity">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/print%20on%20demand-packaging1.JPG"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/print%20on%20demand-packaging1.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector nature">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/print%20on%20demand-packaging2.JPG"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/Print%20on%20Demand/print%20on%20demand-packaging2.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="whiteSection full-width clearfix coursesSection " id="content2">
    <div class="container">
        <div class="sectionTitle text-center">
            <h2 class="wow fadeInUp">
                <span class="shape shape-left bg-color-4"></span>
                <span>สื่อสิ่งพิมพ์</span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
            <p>
                เนื้อหาจำลองแบบเรียบๆ ที่ใช้กันในธุรกิจงานพิมพ์หรืองานเรียงพิมพ์มันได้กลายมาเป็น
                เนื้อหาจำลองมาตรฐานของธุรกิจดังกล่าวมาตั้งแต่ศตวรรษที่ 16
                เมื่อเครื่องพิมพ์โนเนมเครื่องหนึ่งนำรางตัวพิมพ์มาสลับสับตำแหน่งตัวอักษรเพื่อทำหนังสือตัวอย่าง
            </p>
        </div>

        <div class="row">
            <div class="col-xs-12 ">
                <div class="filter-container isotopeFilters wow fadeInUp">
                    <ul class="list-inline filter">
                        <li class="active"><a href="#" data-filter="*">ทั้งหมด</a></li>
                        <li><a href="#" data-filter=".book">หนังสือ</a></li>
                        <li><a href="#" data-filter=".booklet">สมุด</a></li>
                        <li><a href="#" data-filter=".book-card">ใบปลิว และ แผ่นพับ</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row isotopeContainer" id="container2">
            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector book ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/Book%20Gallery/Book%201.JPG" alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/Book%20Gallery/Book%201.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector book ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/Book%20Gallery/Book%203.JPG" alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/Book%20Gallery/Book%203.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector booklet ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/NoteBook%20Galler/Diary%201.JPG" alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/NoteBook%20Galler/Diary%201.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector booklet">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/NoteBook%20Galler/NoteBook%201.JPG"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/NoteBook%20Galler/NoteBook%201.JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector book-card">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/Poster%20Gallery/Leaflets%20(2).png"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/Poster%20Gallery/Leaflets%20(2).png">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>
        </div>
    </div>
</section>


<section class="whiteSection full-width clearfix coursesSection " id="content3">
    <div class="container">
        <div class="sectionTitle text-center">
            <h2 class="wow fadeInUp">
                <span class="shape shape-left bg-color-4"></span>
                <span>บรรจุภัณฑ์</span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
            <p>
                บรรจุภัณฑ์นอกจากจัดทำขึ้นเพื่อใส่สินค้าแล้ว
                ยังใช้เป็นสื่อประชาสัมพันธ์เพื่อแสดงรูปภาพรายละเอียดของสินค้า
                เพื่อดึงดูดความสนใจและส่งเสริมให้สินค้าดูมีมูลค่าน่าซื้อ
                ส่วนมากนิยมผลิตกล่องขึ้นรูปเป็นลักษณะทรง 4 เหลี่ยม มีระบบลิ้นสำหรับล็อคปิดเปิดสำหรับกล่องชิ้นเดียว
                หรือเป็นฝาครอบหากแยกเป็น 2 ชิ้น
                นอกจากนั้นยังสามารถขึ้นรูปตามที่ต้องการ สามารถผลิตตามขนาดที่บรรจุสินค้าได้ นิยมใช้กระดาษกล่องแป้ง
                หรือกระดาษอาร์ตการ์ดที่ความหนา 300 แกรม ขึ้นไป
            </p>
        </div>

        <div class="row">
            <div class="col-xs-12 ">
                <div class="filter-container isotopeFilters2 wow fadeInUp">
                    <ul class="list-inline filter">
                        <li class="active"><a href="#" data-filter="*">ทั้งหมด</a></li>
                        <li><a href="#" data-filter=".book1">ฉลากและป้ายสินค้า</a></li>
                        <li><a href="#" data-filter=".book2">กล่องกระดาษ</a></li>
                        <li><a href="#" data-filter=".book3">ถุงกระดาษ</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row isotopeContainer2" id="container2">
            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector book1 ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/label/%E0%B8%AA%E0%B8%A5%E0%B8%B2%E0%B8%81-01_03.png"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/label/%E0%B8%AA%E0%B8%A5%E0%B8%B2%E0%B8%81-01_03.png">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector book1 ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/label/%E0%B8%AA%E0%B8%A5%E0%B8%B2%E0%B8%81-034_03.png"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/label/%E0%B8%AA%E0%B8%A5%E0%B8%B2%E0%B8%81-034_03.png">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector book2 ">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/box/box69_03.png" alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images" href="http://santipab.co.th/wp-content/uploads/box/box69_03.png">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector book2">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/box/box92_03.png" alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images" href="http://santipab.co.th/wp-content/uploads/box/box92_03.png">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 isotopeSelector book3">
                <article class="wow fadeInUp">
                    <figure>
                        <img src="http://santipab.co.th/wp-content/uploads/PaperBag%20Gallery/paperbag%20(2).JPG"
                             alt="image"
                             class="img-rounded img-preview">
                        <div class="overlay-background">
                            <div class="inner"></div>
                        </div>
                        <div class="overlay">
                            <a data-fancybox="images"
                               href="http://santipab.co.th/wp-content/uploads/PaperBag%20Gallery/paperbag%20(2).JPG">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </figure>
                </article>
            </div>
        </div>
    </div>
</section>