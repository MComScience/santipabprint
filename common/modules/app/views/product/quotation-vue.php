<?php

use adminlte\helpers\Html;
use kartik\icons\Icon;
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use kartik\select2\Select2Asset;
use kartik\select2\ThemeBootstrapAsset;

SweetAlert2Asset::register($this);
Select2Asset::register($this);
ThemeBootstrapAsset::register($this);

$this->title = $modelProduct['product_name'];

//style
$styles = [
    '@web/bundle/waitMe.css',
    '@web/bundle/quotation.css',
    '@web/bundle/checkboxStyle.css'
];
foreach ($styles as $style) {
    $this->registerCssFile($style, [
        'depends' => [
            \yii\bootstrap\BootstrapAsset::className(),
            \kidz\assets\KidzAsset::className(),
            \frontend\assets\AppAsset::className()
        ],
    ]);
}
$this->registerCss(<<<CSS
.icon-container {
    margin: 10px;
    display: inline-block;
}
.list-item-content {
    margin: 10px;
    display: inline-block;
}
.list-price-content {
    display: inline-block;
    float: right;
    margin: 21px 10px;
    font-weight: 700;
}
.list-price-content h4 {
    display: inline-block;
    margin-right: 10px;
    margin-top: 5px;
}
.list-price-content i {
    display: inline-block;
    float: right;
}
.list-group-item {
    cursor: pointer;
}
.list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
    background-color: #9cd584 !important;
    color: #fff !important;
    border-color: #9cd584;
}
.list-group a:focus h3, .list-group a:focus h4, .list-group a:focus p {
    color: #fff !important;
}
.list-group-item.active h3, .list-group-item.active:focus h3, .list-group-item.active:hover h3,
.list-group-item.active h4, .list-group-item.active:focus h4, .list-group-item.active:hover h4,
.list-group-item.active p, .list-group-item.active:focus p, .list-group-item.active:hover p {
    color: #fff !important;
}
.on-remove-item {
    color: #ef694b !important;
}
/* Small devices (tablets, 768px and up) */
@media (max-width: 768px) {
    .quotation-detail {
        font-size: 20px !important;
    }
    .control-label, .select2-container--bootstrap .select2-selection {
        font-size: 18px !important;
    }
    .select2-container--bootstrap .select2-dropdown {
        font-size: 16px !important;
    }
    ul.quotation-detail li {
        margin-bottom: 10px !important;
    }
}
.lds-dual-ring {
  display: inline-block;
  width: 64px;
  height: 64px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid #42b983;
  border-color: #42b983 transparent #42b983 transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.loading {
    display: flex;
    align-items: center;
    justify-content: center;
}
.inline-block {
  display: inline-block;
}
.help-block.text-danger {
  color: #a94442 !important;
}
.label-option {
    background-color: #eee;
    color: #333;
    font-weight: bold;
    font-size: 14px;
}
.panel-quotation {
  border-top-left-radius: 0px;
  border-top-right-radius: 0px;
}
.select2-container--bootstrap .select2-results__group {
  display: block;
  color: #333;
  text-shadow: 0 1px 0 #fff;
  background-color: #eee;
  border-top: 1px solid #e0e0e0;
  border-bottom: 1px solid #e0e0e0;
  padding: 6px 12px;
  line-height: 1.428571429;
  white-space: nowrap;
}
CSS
);
?>
<div id="app">
    <section class="whiteSection full-width clearfix qoutationSection" style="padding: 20px 0;">
        <div class="container">
            <!-- Section Title -->
            <div class="sectionTitle text-center">
                <h2 class="wow" style="margin-bottom: 5px;">
                    <span class="shape shape-left bg-color-4"></span>
                    <span>
                        <?= $modelProduct['product_name']; ?>
                    </span>
                    <span class="shape shape-right bg-color-4"></span>
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <?= Html::a(Icon::show('file-text-o') . ' ขอใบเสนอราคา', ['/app/product/index']); ?>
                    </li>
                    <li class="active"><?= $modelProduct['product_name'] ?></li>
                </ol>
            </div>
            <!--  -->
            <div v-show="step === 1" class="row" id="form-container">
                <div class="col-md-7 col-lg-8 order-1 order-md-0">
                    <!-- Icon -->
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <?=
                            Html::img(Yii::getAlias('@web/images/document.png'), [
                                'width' => '50px',
                                'class' => 'img-responsive center-block'
                            ]) . Html::tag('p', 'กำหนดรายละเอียด', ['class' => 'text-center'])
                            ?>
                        </div>
                    </div>
                    <!--  -->
                    <!-- Form -->
                    <div class="tab-content product-content" id="panel-container">
                        <div role="tabpanel" class="tab-pane active" id="tab-form">
                            <div class="panel panel-info panel-quotation">
                                <div class="panel-body">
                                    <!-- loading -->
                                    <div class="loading hidden">
                                        <div class="lds-dual-ring" id="loading"></div>
                                    </div>
                                    <div class="container-form hidden">

                                        <form v-if="formOptions" v-on:submit.prevent="onSubmit" id="form-quotation">

                                            <!--แบ่งรายละเอียดสินค้า-->
                                                <!-- ขนาด -->
                                            <v-row v-if="isvisibleInput('paper_size_id')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('paper_size_id') ? 'has-error' : 'has-success']">
                                                        <label class="labe">
                                                            ขนาด 
                                                        </label>

                                                        <v-select2
                                                            id="paper_size_id"
                                                            :options="paperSizeIdOpts" 
                                                            v-model="formAttributes.paper_size_id"
                                                            name="paper_size_id"
                                                            @change="onChangePaperSizeId">
                                                            <option disabled value="">เลือกขนาด</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('paper_size_id') }}
                                                    </div>
                                                </v-col>
                                            </v-row>

                                            <span v-if="isvisibleInput('paper_size_id') && formAttributes.paper_size_id === 'custom'" class="label label-option custom-paper-size hidden">
                                                <label class="control-label has-star">
                                                    กำหนดขนาดเอง 
                                                </label>
                                            </span>

                                            <!-- ขนาดกำหนดเอง -->
                                            <v-row v-if="isvisibleInput('paper_size_id')  && formAttributes.paper_size_id === 'custom'" >
                                                <!-- กว้าง -->
                                                <v-col v-show="isvisibleInput('paper_size_width')" xs="12" sm="3" md="3">
                                                    <div v-bind:class="['form-group', errors.first('paper_size_width') ? 'has-error' : 'has-success']">
                                                        <label class="control-label has-star">
                                                            {{ inputLabel('paper_size_width') }}
                                                        </label>
                                                        <input 
                                                            id="paper_size_width"
                                                            name="paper_size_width"
                                                            placeholder="กว้าง"
                                                            class="form-control"
                                                            v-model="formAttributes.paper_size_width" />
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('paper_size_width') }}
                                                    </div>
                                                </v-col>
                                                <!-- ยาว -->
                                                <v-col v-show="isvisibleInput('paper_size_lenght')" xs="12" sm="3" md="3">
                                                    <div v-bind:class="['form-group', errors.first('paper_size_lenght') ? 'has-error' : 'has-success']">
                                                        <label class="control-label has-star">
                                                            {{ inputLabel('paper_size_lenght') }}
                                                        </label>
                                                        <input 
                                                            id="paper_size_lenght"
                                                            name="paper_size_lenght"
                                                            placeholder="ยาว"
                                                            class="form-control"
                                                            v-model="formAttributes.paper_size_lenght" />
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('paper_size_lenght') }}
                                                    </div>
                                                </v-col>
                                                <!-- สูง -->
                                                <v-col v-show="isvisibleInput('paper_size_height')" xs="12" sm="3" md="3">
                                                    <div v-bind:class="['form-group', errors.first('paper_size_height') ? 'has-error' : 'has-success']">
                                                        <label class="control-label has-star">
                                                            {{ inputLabel('paper_size_height') }}
                                                        </label>
                                                        <input 
                                                            id="paper_size_height"
                                                            name="paper_size_height"
                                                            placeholder="สูง"
                                                            class="form-control"
                                                            v-model="formAttributes.paper_size_height"/>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('paper_size_height') }}
                                                    </div>
                                                </v-col>
                                                <!-- หน่วย -->
                                                <v-col v-show="isvisibleInput('paper_size_unit')" xs="12" sm="3" md="3">
                                                    <div v-bind:class="['form-group', errors.first('paper_size_unit') ? 'has-error' : 'has-success']">
                                                        <label class="control-label has-star">
                                                            {{ inputLabel('paper_size_unit') }}
                                                        </label>
                                                        <v-select2
                                                            id="paper_size_unit"
                                                            :options="pageSizeUnitOpts" 
                                                            v-model="formAttributes.paper_size_unit"
                                                            name="paper_size_unit"
                                                            @change="onChangePageSizeUnit">
                                                            <option disabled value="">เลือกรายการ...</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('paper_size_unit') }}
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <!-- ขนาดกำหนดเอง -->

                                            <!-- กระดาษ -->
                                            <v-row v-if="isvisibleInput('paper_id')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('paper_id') ? 'has-error' : 'has-success']">
                                                        <!-- กระดาษ -->
                                                        <label v-if="isvisibleInput('paper_id')" class="control-label">
                                                            กระดาษ 
                                                        </label>
                                                        <v-select2
                                                            id="paper_id"
                                                            :options="paperIdOpts" 
                                                            v-model="formAttributes.paper_id"
                                                            name="paper_id"
                                                            @change="onChangePaperId">
                                                            <option disabled value="">เลือกกระดาษ</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('paper_id') }}
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            
                                            <!-- แนวตั้ง/แนวนอน  -->
                                            <v-row v-if="isvisibleInput('land_orient')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('land_orient') ? 'has-error' : 'has-success']">
                                                        <label class="control-label">
                                                            แนวตั้ง/แนวนอน
                                                        </label>
                                                        <v-land-orient 
                                                            :land-orient-options="landOrientOptions"
                                                            @change="onChangeLandOrient"
                                                            name="land_orient"
                                                            v-model="formAttributes.land_orient" /> 
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('land_orient') }}
                                                    </div>
                                                </v-col>
                                            </v-row>


                                            <!-- เข้าเล่ม -->
                                            <v-row v-if="isvisibleInput('book_binding_id')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('book_binding_id') ? 'has-error' : 'has-success']">
                                                        <label class="control-label">
                                                            เข้าเล่ม
                                                        </label>
                                                        <v-select2
                                                            id="book_binding_id"
                                                            :options="BookBindingOpts" 
                                                            v-model="formAttributes.book_binding_id"
                                                            name="book_binding_id"
                                                            @change="onChangeBookBinding">
                                                            <option disabled value="">เลือกรายการ...</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('book_binding_id') }}
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <p></p>
                                            <!-- จำนวนหน้า -->
                                            <v-row v-if="isvisibleInput('page_qty')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('page_qty') ? 'has-error' : 'has-success']">
                                                        <label class="control-label">
                                                            จำนวนหน้า
                                                        </label>
                                                        <input 
                                                            id="page_qty"
                                                            name="page_qty"
                                                            placeholder="ระบุจำนวน"
                                                            class="form-control"
                                                            v-model="formAttributes.page_qty"
                                                            />
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('page_qty') }}
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <p></p>
                                            
                                            <!--จำนวนแผ่นต่อชุด-->

                                            <v-row v-if="isvisibleInput('bill_detail_qty')" >
                                                <v-col v-if="isvisibleInput('bill_detail_qty')" xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('bill_detail_qty') ? 'has-error' : 'has-success']">
                                                       <label class="control-label">
                                                            จำนวนแผ่นต่อชุด
                                                        </label>
                                                        <v-select2
                                                            id="bill_detail_qty"
                                                            :options="billQtyOpts" 
                                                            v-model="formAttributes.bill_detail_qty"
                                                            name="bill_detail_qty"
                                                            @change="onChangeBillQty">
                                                            <option disabled value="">เลือก</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('bill_detail_qty') }}
                                                    </div>
                                                </v-col>
                                            </v-row>

                                            <hr v-show="isvisibleInput('print_option')">

                                            <!-- 2 -->
                                            
                                            <h4 v-show="isvisibleInput('print_option')" style="font-size: 16px;">
                                                งานพิมพ์ :
                                            </h4>
                                            <!-- พิมพ์สองหน้า/หน้าเดียว -->
                                            <v-row v-if="isvisibleInput('print_option')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form- <hr>group', errors.first('print_option') ? 'has-error' : 'has-success']">
                                                        <label class="control-label">
                                                            พิมพ์สองหน้า/หน้าเดียว 
                                                        </label>
                                                        <v-select2
                                                            id="print_option"
                                                            :options="printOptionOpts" 
                                                            v-model="formAttributes.print_option"
                                                            name="print_option"
                                                            @change="onChangePrintOption">
                                                            <option disabled value="">เลือกตัวเลือก</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('print_option') }}
                                                    </div>
                                                </v-col>
                                                <!-- สีที่พิมพ์ -->
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('print_color') ? 'has-error' : 'has-success']">
                                                        <label class="control-label">
                                                            สีที่พิมพ์   
                                                        </label>
                                                        <v-select2
                                                            id="print_color"
                                                            :options="printColorOpts" 
                                                            v-model="formAttributes.print_color"
                                                            name="print_color"
                                                            @change="onChangePrintColor">
                                                            <option disabled value="">เลือกสีที่พิมพ์</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('print_color') }}
                                                    </div>
                                                </v-col>
                                            </v-row>
                                           
                                            
                                            <hr v-show="isvisibleInput('coating_id')">
                                            <h4 v-show="isvisibleInput('coating_id')" style="font-size: 16px;">
                                                งานเคลือบ :
                                            </h4>
                                            <!-- เคลือบ -->
                                            <v-row v-if="isvisibleInput('coating_id')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('coating_id') ? 'has-error' : 'has-success']">
                                                        <v-select2
                                                            id="coating_id"
                                                            :options="coatingIdOpts" 
                                                            v-model="formAttributes.coating_id"
                                                            name="coating_id"
                                                            @change="onChangeCoatingId">
                                                            <option disabled value="">เลือกรายการ...</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('coating_id') }}
                                                    </div>
                                                </v-col>
                                                <v-col v-show="formAttributes.coating_id && formAttributes.coating_id !== 'N'" xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('coating_option') ? 'has-error' : 'has-success']">
                                                       
                                                        <v-coating-option 
                                                            :options="coatingOptionOptions"
                                                            @change="onChangeCoatingOption"
                                                            name="coating_option"
                                                            v-model="formAttributes.coating_option" /> 
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('coating_option') }}
                                                    </div>
                                                </v-col>
                                                <p></p>
                                            </v-row>
                                            
                                            <hr v-show="isvisibleInput('coating_id')">
                                            
                                            <h4 v-show="isvisibleInput('diecut') && !isvisibleInput('perforate')" style="font-size: 16px;">
                                                ไดคัท :
                                            </h4>
                                            <h4 v-show="isvisibleInput('diecut') && isvisibleInput('perforate')" style="font-size: 16px;">
                                                ไดคัท/ตัดเป็นตัว,เจาะ :
                                            </h4>
                                          <!--  <hr v-if="isvisibleInput('diecut') || isvisibleInput('perforate')">  -->
                                            <v-row v-if="isvisibleInput('diecut') || isvisibleInput('perforate')">
                                                <v-col xs="12" sm="12" md="12">
                                                    <div class="form-group">
                                                        <div id="tblquotationdetail-foil-status" role="radiogroup" aria-invalid="false">
                                                            <div v-for="(option, key) in radioOptions" :key="key" class="radio inline-block">
                                                                <label class="radio-inline">
                                                                    <input type="radio" 
                                                                           :id="'radio-option-' + key"
                                                                           :value="option.value"
                                                                           v-model="radioChecked">
                                                                           <span class="cr">
                                                                        <i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            
                                            <!-- ไดคัท -->
                                            <v-row v-if="isvisibleInput('diecut') && isDicut">
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('diecut') ? 'has-error' : 'has-success']">
                                                        <!-- <label class="control-label has-star">
                                                          {{ inputLabel('diecut') }}
                                                        </label> -->
                                                        <label class="control-label">
                                                            ไดคัท 
                                                        </label>
<!--                                                        <v-dicut 
                                                            :options="dicutOptions"
                                                            @change="onChangeDidut"
                                                            name="diecut"
                                                            v-model="formAttributes.diecut" /> -->
                                                        <v-select2
                                                            id="diecut"
                                                            :options="dicutOpts"
                                                            v-model="formAttributes.diecut"
                                                            name="diecut"
                                                            @change="onChangeDidut">
                                                            <option disabled value="">เลือกรายการ...</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('diecut') }}
                                                    </div>
                                                </v-col>
                                                
                                                <v-col v-if="isvisibleInput('diecut') && formAttributes.diecut === 'Curve'" xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('diecut_id') ? 'has-error' : 'has-success']">
                                                        <label class="control-label">
                                                          เลือกมุม
                                                        </label>
                                                        <v-select2
                                                            id="diecut_id"
                                                            :options="dicutIdOpts" 
                                                            v-model="formAttributes.diecut_id"
                                                            name="diecut_id"
                                                            @change="onChangeDidutId">
                                                            <option disabled value="">เลือกรายการ...</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('diecut_id') }}
                                                    </div>
                                                </v-col>
                                            </v-row>

                                            <!-- ตัดเป็นตัว/เจาะ -->
                                            <v-row v-if="isvisibleInput('perforate') && isPerforate" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('perforate') ? 'has-error' : 'has-success']">
                                                        <label class="control-label">
                                                          ตัดเป็นตัว/เจาะ
                                                        </label>
                                                        <v-select2
                                                            id="perforate"
                                                            :options="perforateOpts" 
                                                            v-model="formAttributes.perforate"
                                                            name="perforate"
                                                            @change="onChangePerforate">
                                                            <option disabled value="">เลือกรายการ...</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('perforate') }}
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <v-row v-show="isvisibleInput('perforate') && formAttributes.perforate === '1' && isPerforate" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('perforate_option_id') ? 'has-error' : 'has-success']">
                                                        <label class="control-label has-star">
                                                            {{ inputLabel('perforate_option_id') }}
                                                        </label>
                                                        <v-select2
                                                            id="perforate_option_id"
                                                            :options="perforateOptionOpts" 
                                                            v-model="formAttributes.perforate_option_id"
                                                            name="perforate_option_id"
                                                            @change="onChangePerforateOption">
                                                            <option disabled value="">เลือกรายการ...</option>
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('perforate_option_id') }}
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <hr v-show ="isvisibleInput('diecut') || isvisibleInput('perforate')">
                                            
                                            <h4 v-show="isvisibleInput('fold_id')" style="font-size: 16px;">
                                                วิธีพับ :
                                            </h4>
                                            <!-- วิธีพับ -->
                                            <v-row v-if="isvisibleInput('fold_id')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('fold_id') ? 'has-error' : 'has-success']">
                                                        <!-- <label class="control-label has-star">
                                                          {{ inputLabel('fold_id') }}
                                                        </label> -->
                                                        <v-select2
                                                            id="fold_id"
                                                            :options="foldIdOpts" 
                                                            v-model="formAttributes.fold_id"
                                                            name="fold_id"
                                                            @change="onChangeFoldId">
                                                        </v-select2>
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('fold_id') }}
                                                    </div>
                                                </v-col>
                                            </v-row>
                                            <hr v-show="isvisibleInput('fold_id')">
                                            
                                            <h4 v-show="isvisibleInput('foil_status')" style="font-size: 16px;">
                                                ปั๊มฟอยล์ :
                                            </h4>
                                            <!-- แก้ไขform ปั๊มafoil !-->
                                            <v-row v-if="isvisibleInput('foil_status')">
                                                <v-col xs="12" sm="12" md="12">
                                                    <div v-bind:class="['form-group', errors.first('foil_status') ? 'has-error' : 'has-success']">
                                                        <v-foil-status 
                                                            :options="foilStatusOptions"
                                                            @change="onChangeFoilStatus"
                                                            name="foil_status"
                                                            v-model="formAttributes.foil_status" /> 
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('foil_status') }}
                                                    </div>
                                                </v-col>
                                            </v-row>

                                            <!-- ความกว้าง/ความยาว/หน่วย,สีฟอยล์และปั๊มฟอยล์ หน้า-หลัง/หน้าเดียว  -->
                                            <v-row v-if="isvisibleInput('foil_status') && showFoilInput" >
                                                <v-col xs="12" sm="12" md="12">
                                                    <!-- ความกว้าง/ความยาว/หน่วย -->
                                                    <v-row v-if="
                                                           isvisibleInput('foil_size_width') || 
                                                           isvisibleInput('foil_size_height') || 
                                                           isvisibleInput('foil_size_unit') || 
                                                           isvisibleInput('foil_color_id')" >
                                                        <!-- กว้าง -->
                                                        <v-col xs="12" sm="3" md="3">
                                                            <div v-bind:class="['form-group', errors.first('foil_size_width') ? 'has-error' : 'has-success']">
                                                                <label class="control-label has-star">
                                                                    {{ inputLabel('foil_size_width') }}
                                                                </label>
                                                                <input 
                                                                    id="foil_size_width"
                                                                    name="foil_size_width"
                                                                    placeholder="กว้าง"
                                                                    class="form-control"
                                                                    v-model="formAttributes.foil_size_width"/>
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('foil_size_width') }}
                                                            </div>
                                                        </v-col>
                                                        <!-- ยาว -->
                                                        <v-col xs="12" sm="3" md="3">
                                                            <div v-bind:class="['form-group', errors.first('foil_size_height') ? 'has-error' : 'has-success']">
                                                                <label class="control-label has-star">
                                                                    {{ inputLabel('foil_size_height') }}
                                                                </label>
                                                                <input 
                                                                    id="foil_size_height"
                                                                    name="foil_size_height"
                                                                    placeholder="ยาว"
                                                                    class="form-control"
                                                                    v-model="formAttributes.foil_size_height" />
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('foil_size_height') }}
                                                            </div>
                                                        </v-col>
                                                        <!-- หน่วย -->
                                                        <v-col xs="12" sm="3" md="3">
                                                            <div v-bind:class="['form-group', errors.first('foil_size_unit') ? 'has-error' : 'has-success']">
                                                                <label class="control-label has-star">
                                                                    {{ inputLabel('foil_size_unit') }}
                                                                </label>
                                                                <v-select2
                                                                    id="foil_size_unit"
                                                                    :options="foilSizeUnitOpts" 
                                                                    v-model="formAttributes.foil_size_unit"
                                                                    name="foil_size_unit"
                                                                    @change="onChangeFoilSizeUnit">
                                                                    <option disabled value="">เลือกรายการ...</option>
                                                                </v-select2>
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('foil_size_unit') }}
                                                            </div>
                                                        </v-col>
                                                        <!-- สีฟอยล์ -->
                                                        <v-col xs="12" sm="3" md="3">
                                                            <div v-bind:class="['form-group', errors.first('foil_color_id') ? 'has-error' : 'has-success']">
                                                                <label class="control-label has-star">
                                                                    สีฟอยล์
                                                                </label>
                                                                <v-select2
                                                                    id="foil_color_id"
                                                                    :options="foilColorIdOpts" 
                                                                    v-model="formAttributes.foil_color_id"
                                                                    name="foil_color_id"
                                                                    @change="onChangeFoilColorId">
                                                                    <option disabled value="">เลือกรายการ...</option>
                                                                </v-select2>
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('foil_color_id') }}
                                                            </div>
                                                        </v-col>

                                                    </v-row>
                                                    <!-- ปั๊มฟอยล์ทั้งหน้า/หลัง หรือหน้าเดียว? -->
                                                    <v-row v-if="
                                                           isvisibleInput('foli_print')" >
                                                        <v-col xs="12" sm="6" md="6">
                                                            <div v-show="isvisibleInput('foli_print')" v-bind:class="['form-group', errors.first('foli_print') ? 'has-error' : 'has-success']">
                                                                   <label class="control-label">
                                                                        ปั๊มฟอยล์ หน้า-หลัง/หน้าเดียว
                                                                    </label>
                                                                <v-foli-print 
                                                                    :options="foliPrintOptions"
                                                                    @change="onChangeFoliPrint"
                                                                    name="foli_print"
                                                                    v-model="formAttributes.foli_print" /> 
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('foli_print') }}
                                                            </div>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>   
                                            <!--สิ้นสุด-->   
                                            <hr v-show="isvisibleInput('foil_status')">
                                            
                                            <h4 v-show="isvisibleInput('emboss_status')" style="font-size: 16px;">
                                                ปั๊มนูน :
                                            </h4>
                                            <!--แก้ไข form ปั๊มนูน -->
                                            <v-row v-if="isvisibleInput('emboss_status')">
                                                <v-col xs="12" sm="12" md="12">
                                                    <div v-bind:class="['form-group', errors.first('emboss_status') ? 'has-error' : 'has-success']">
                                                        <v-emboss-status 
                                                            :options="embossStatusOptions"
                                                            @change="onChangeEmbossStatus"
                                                            name="emboss_status"
                                                            v-model="formAttributes.emboss_status" /> 
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('emboss_status') }}
                                                    </div>
                                                </v-col>
                                            </v-row>

                                            <v-row v-if="isvisibleInput('emboss_status') && showEmbossInput" >
                                                <v-col xs="12" sm="12" md="12">
                                                    <!-- ความกว้าง/ความยาว/หน่วย -->
                                                    <v-row v-if="
                                                           isvisibleInput('emboss_size_width') ||
                                                           isvisibleInput('emboss_size_height') ||
                                                           isvisibleInput('emboss_size_unit')" >
                                                        <!-- กว้าง -->
                                                        <v-col xs="12" sm="3" md="3">
                                                            <div v-bind:class="['form-group', errors.first('emboss_size_width') ? 'has-error' : 'has-success']">
                                                                <label class="control-label has-star">
                                                                    {{ inputLabel('emboss_size_width') }}
                                                                </label>
                                                                <input 
                                                                    id="emboss_size_width"
                                                                    name="emboss_size_width"
                                                                    placeholder="กว้าง"
                                                                    class="form-control"
                                                                    v-model="formAttributes.emboss_size_width" />
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('emboss_size_width') }}
                                                            </div>
                                                        </v-col>
                                                        <!-- ยาว -->
                                                        <v-col xs="12" sm="3" md="3">
                                                            <div v-bind:class="['form-group', errors.first('emboss_size_height') ? 'has-error' : 'has-success']">
                                                                <label class="control-label has-star">
                                                                    {{ inputLabel('emboss_size_height') }}
                                                                </label>
                                                                <input 
                                                                    id="emboss_size_height"
                                                                    name="emboss_size_height"
                                                                    placeholder="ยาว"
                                                                    class="form-control"
                                                                    v-model="formAttributes.emboss_size_height" />
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('emboss_size_height') }}
                                                            </div>
                                                        </v-col>
                                                        <!-- หน่วย -->
                                                        <v-col xs="12" sm="3" md="3">
                                                            <div v-bind:class="['form-group', errors.first('emboss_size_unit') ? 'has-error' : 'has-success']">
                                                                <label class="control-label has-star">
                                                                    {{ inputLabel('emboss_size_unit') }}
                                                                </label>
                                                                <v-select2
                                                                    id="emboss_size_unit"
                                                                    :options="embossSizeUnitOpts" 
                                                                    v-model="formAttributes.emboss_size_unit"
                                                                    name="emboss_size_unit"
                                                                    @change="onChangeEmbossSizeUnit">
                                                                    <option disabled value="">เลือกรายการ...</option>
                                                                </v-select2>
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('emboss_size_unit') }}
                                                            </div>
                                                        </v-col>
                                                    </v-row>

                                                    <!-- ปั๊มฟอยล์ทั้งหน้า/หลัง หรือหน้าเดียว? -->
                                                    <v-row v-if="isvisibleInput('emboss_print')" >
                                                        <v-col xs="12" sm="6" md="6">
                                                            <div v-bind:class="['form-group', errors.first('emboss_print') ? 'has-error' : 'has-success']">
                                                                  <label class="control-label">
                                                                    ปั๊มนูน หน้า-หลัง/หน้าเดียว   
                                                                </label>
                                                                <v-emboss-print 
                                                                    :options="embossPrintOptions"
                                                                    @change="onChangeEmbossPrint"
                                                                    name="emboss_print"
                                                                    v-model="formAttributes.emboss_print" /> 
                                                            </div>
                                                            <div class="help-block text-danger">
                                                                {{ errors.first('emboss_print') }}
                                                            </div>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>
                                            <hr v-show="isvisibleInput('emboss_status')">
                                            
                                            <h4 v-show="isvisibleInput('glue')" style="font-size: 16px;">
                                                ปะกาว :
                                            </h4>
                                            <!-- ปะกาว -->
                                            <v-row v-if="isvisibleInput('glue')" >
                                                <v-col xs="12" sm="6" md="6">
                                                    <div v-bind:class="['form-group', errors.first('glue') ? 'has-error' : 'has-success']">
                                                        <v-glue 
                                                            :options="glueOptions"
                                                            @change="onChangeGlue"
                                                            name="glue"
                                                            v-model="formAttributes.glue" /> 
                                                    </div>
                                                    <div class="help-block text-danger">
                                                        {{ errors.first('glue') }}
                                                    </div>
                                                </v-col>
                                            </v-row>

                                        </form>
                                    </div>
                                </div>
                                <!-- footer -->
                                <div class="panel-footer">
                                    <div v-html="product ? product.product_description : null"></div>
                                    {{ liffData }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4">
                    <!-- Icon -->
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <p class="text-center" style="line-height: 15px">
                                <?=
                                Html::img(Yii::getAlias('@web/images/checklist.png'), [
                                    'width' => '50px',
                                    'class' => 'img-responsive center-block',
                                    'style' => 'margin-bottom: 5px;'
                                ]) . Html::tag('span', 'รายละเอียด', ['class' => 'text-center'])
                                ?>
                            </p>
                        </div>
                    </div>
                    <!-- Panel -->
                    <div ref="product_detail" class="panel panel-info product-panel">
                        <div class="panel-body">
                            <!-- loading -->
                            <div class="loading hidden">
                                <div class="lds-dual-ring" id="loading2"></div>
                            </div>
                            <div v-if="product" class="product-detail hidden">
                                <ul class="quotation-detail" style="font-size: 14px;padding: 0;">
                                    <li>
                                        <span>สินค้า</span>
                                        <span class="float-right">{{ product ? product.product_name : null }}</span>
                                    </li>
                                </ul>
                                <ul class="quotation-detail" style="font-size: 14px;padding: 0;">
                                    <!-- รูปแบบ -->
                                    <li v-show="isvisibleInput('land_orient')">
                                        <span>{{ inputLabel('land_orient', 'รูปแบบ') }}:</span>
                                        <span class="op_land_orient float-right" id="op_land_orient">
                                            {{ landOrientDetail }}
                                        </span>
                                    </li>
                                    <!-- ขนาด -->
                                    <li v-show="isvisibleInput('paper_size_id')">
                                        <span>{{ inputLabel('paper_size_id', 'ขนาด') }}:</span>
                                        <span class="op_paper_size_id float-right" id="op_paper_size_id">
                                            {{ paperSizeDetail }}
                                        </span>
                                    </li>
                                    <!-- เข้าเล่ม -->
                                    <li v-show="isvisibleInput('book_binding_id')">
                                        <span>{{ inputLabel('book_binding_id', 'เข้าเล่ม') }}:</span>
                                        <span class="op_book_binding_id float-right" id="op_book_binding_id">
                                            {{ bookBindingDetail }}
                                        </span>
                                    </li>
                                    <!-- จำนวนหน้า -->
                                    <li v-show="isvisibleInput('page_qty')">
                                        <span>{{ inputLabel('page_qty', 'จำนวนหน้า') }}:</span>
                                        <span class="op_page_qty float-right" id="op_page_qty">
                                            {{ page_qty }}
                                        </span>
                                    </li>
                                    <!-- กระดาษ -->
                                    <li v-show="isvisibleInput('paper_id')">
                                        <span>{{ inputLabel('paper_id', 'กระดาษ') }}:</span>
                                        <span class="op_paper_id float-right" id="op_paper_id">
                                            {{ paperDetail }}
                                        </span>
                                    </li>
                                    <!-- จำนวนชั้นกระดาษ -->
                                    <li v-show="isvisibleInput('bill_detail_qty')">
                                        <span>{{ inputLabel('bill_detail_qty', 'จำนวนชั้นกระดาษ') }}:</span>
                                        <span class="op_bill_detail_qty float-right" id="op_bill_detail_qty">
                                            {{ billDetail }}
                                        </span>
                                    </li>
                                    <!-- พิมพ์หน้าเดียว/พิมพ์สองหน้า -->
                                    <li v-show="isvisibleInput('print_option')">
                                        <span>พิมพ์:</span>
                                        <span class="op_print_one_page float-right" id="op_print_one_page">
                                            {{ printColorDetail }}
                                        </span>
                                    </li>
                                    <!-- เคลือบ -->
                                    <li v-show="isvisibleInput('coating_id')">
                                        <span>{{ inputLabel('coating_id', 'เคลือบ') }}</span>
                                        <span class="op_coating_id float-right" id="op_coating_id">
                                            {{ coatingDetail }}
                                        </span>
                                    </li>
                                    <!-- ไดคัท -->
                                    <li v-show="isvisibleInput('diecut')">
                                        <span>ไดคัท:</span>
                                        <span class="op_diecut_id float-right" id="op_diecut_id">
                                            {{ dicutDetail }}
                                        </span>
                                    </li>
                                    <!-- ตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว -->
                                    <li v-show="isvisibleInput('perforate')">
                                        <span>ตัด/เจาะ: </span>
                                        <span class="op_perforate_option float-right" id="op_perforate_option">
                                            {{ perforateDetail }}
                                        </span>
                                    </li>
                                    <!-- วิธีพับ -->
                                    <li v-show="isvisibleInput('fold_id')">
                                        <span>{{ inputLabel('fold_id', 'วิธีพับ') }}:</span>
                                        <span class="op_fold_id float-right" id="op_fold_id">
                                            {{ foldDetail }}
                                        </span>
                                    </li>
                                    <!-- รายละเอียดฟอยล์ -->
                                    <li v-show="
                                        isvisibleInput('foil_size_width') || 
                                        isvisibleInput('foil_size_height') || 
                                        isvisibleInput('foil_size_unit') || 
                                        isvisibleInput('foil_color_id')">
                                        <span>ฟอยล์:</span>
                                        <span class="op_foil_color_id float-right" id="op_foil_color_id">
                                            {{ foilDetail }}
                                        </span>
                                    </li>
                                    <!-- รายละเอียดปั๊มนูน -->
                                    <li v-show="
                                        isvisibleInput('emboss_size_width') ||
                                        isvisibleInput('emboss_size_height') ||
                                        isvisibleInput('emboss_size_unit')">
                                        <span>ปั๊มนูน:</span>
                                        <span class="op_embossing float-right" id="op_embossing">
                                            {{ embossDetail }}
                                        </span>
                                    </li>
                                    
                                    <!-- ปะกาว -->
                                    <li v-show="isvisibleInput('glue')">
                                        <span>ปะกาว:</span>
                                        <span class="op_embossing float-right" id="op_embossing">
                                            {{ glueDetail }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- ขั้นตอนถัดไป -->
                    <p>
                        <button v-on:click="nextStepOne" class="btn btn-info btn-lg btn-block">
                            ขั้นตอนถัดไป 
                            <i class="fa fa-angle-double-right"></i>
                        </button>
                    </p>
                    <p>
                        <?= Html::a('<i class="fa fa-angle-double-left"></i>' . ' กลับหน้าหลัก', ['/app/product/index'], ['class' => 'btn btn-info btn-lg btn-block']) ?>
                    </p>
                </div>
            </div>
            <!-- end form container -->
            <div v-show="step === 2" class="preview hidden">
                <div class="row">
                    <div class="col-md-5 col-lg-4 col-md-offset-4 preview-detail">
                        <!-- Icon -->
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <p class="text-center" style="line-height: 15px">
                                    <?=
                                    Html::img(Yii::getAlias('@web/images/checklist.png'), [
                                        'width' => '50px',
                                        'class' => 'img-responsive center-block',
                                        'style' => 'margin-bottom: 5px;'
                                    ]) . Html::tag('span', 'รายละเอียด', ['class' => 'text-center'])
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div ref="product_preview" id="preview-detail"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 list-group-price">
                        <div class="alert alert-info" role="alert">
                            Notice! เลือกจำนวนที่ต้องการพิมพ์โดยกดที่เครื่องหมายถูก <i class="fa fa-check-circle-o fa-2x"></i>
                        </div>
                        <div v-if="loadingQty" class="loading">
                            <div class="lds-dual-ring"></div>
                        </div>
                        <ul v-if="!loadingQty" class="list-group">
                            <li v-for="(item, key) in priceList" :key="key" class="list-group-item"  style="list-style-type: none;" @click="onSelectedPriceItem($event, item)">
                                <div v-if="priceSelected && priceSelected.cust_quantity === item.cust_quantity" class="icon-container">
                                    <i class="fa fa-check-circle-o fa-2x"></i>
                                </div>
                                <div class="list-item-content">
                                    <h3>{{ item.cust_quantity }} {{ item.unit }}</h3>
                                    <p>{{ item.price_per_item }} THB ต่อ{{ item.unit }}</p>
                                </div>
                                <div class="list-price-content">
                                    <h4>{{ item.final_price }} THB</h4>
                                    <i @click="onRemovePriceItem(item)" class="fa fa-times-circle-o fa-2x on-remove-item"></i>
                                </div>
                            </li>
                        </ul>
                        <div v-for="(item, key) in priceList" :key="key" class="hidden">
                            digitalAttr
                            <pre>
                          {{ JSON.stringify(item.digitalAttr, null, 2) }}
                            </pre>
                            offsetAttr
                            <pre>
                          {{ JSON.stringify(item.offsetAttr, null, 2) }}
                            </pre>
                        </div>
                    </div>
                </div>
                <div v-if="step === 2" class="row list-group-price">
                    <form v-on:submit.prevent="onAddQty">
                        <div v-show="!isvisibleInput('bill_detail_qty')" class="col-xs-4">

                            <div class="form-group highlight-addon field-tblquotationdetail-cust_quantity has-success">
                                <label class="control-label has-star" for="tblquotationdetail-cust_quantity">เพิ่มจำนวนอื่นๆ</label>
                                <input type="tel" 
                                       id="tblquotationdetail-cust_quantity" 
                                       class="form-control" 
                                       name="cust_quantity" 
                                       min="1" 
                                       placeholder="จำนวน" 
                                       aria-invalid="false"
                                       v-model="formAttributes.cust_quantity">
                                <div class="help-block">

                                </div>
                            </div>

                        </div>
                        <div v-show="!isvisibleInput('bill_detail_qty')" class="col-xs-4">
                            <p style="margin-top: 25px;">
                                <button v-bind:class="[loadingQty ? 'btn btn-primary btn-sm disabled' : 'btn btn-primary btn-sm']" @click="onAddQty"><i class="fa fa-plus"></i></button>
                            </p>
                        </div>
                        <div class="col-xs-4">
                            <input type="hidden" id="tblquotationdetail-final_price" name="TblQuotationDetail[final_price]">
                        </div>
                    </form>
                </div>
                <div v-if="step === 2" class="row list-group-price">
                    <div class="col-xs-6">
                        <p>
                            <a class="btn btn-info btn-lg btn-block" href="javascript:void(0);" @click="onBackStep(1)"><i class="fa fa-angle-double-left"></i> ขั้นตอนก่อนหน้า</a>
                        </p>
                    </div>
                    <div class="col-xs-6">
                        <p>
                            <button id="btn-download-quotation" class="btn btn-info btn-lg btn-block" @click="onDownloadQO"><i class="fa fa-file-text-o"></i> ดาวน์โหลดใบเสนอราคา</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
$this->registerJsFile(
    'https://d.line-scdn.net/liff/1.0/sdk.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
        '@web/js/axios.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
        YII_ENV_DEV ? '@web/js/vue.js' : '@web/js/vue.min.js', []
);
$this->registerJsFile(
        YII_ENV_DEV ? '@web/js/vee-validate.js' : '@web/js/vee-validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);

// $this->registerJsFile(
//         YII_ENV_DEV ? '@web/js/vue/quotation.js' : '@web/js/vue/quotation.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
// );

$this->registerJs(<<<JS
$(window).on("load", function (e) {
    // $('#loading').hide()
    $('.container-form.hidden, .preview').removeClass('hidden')
})
JS
);
$this->registerJs($this->render('@app/web/js/vue/quotation.js'))
?>
