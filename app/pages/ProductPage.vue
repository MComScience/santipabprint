<template>
  <div>
    <section class="whiteSection full-width clearfix productsSection">
      <div class="container">
        <!--begin: Section Title -->
        <section-title
          :title="sectionTitle"
          :is-selected-category="isSelectedCategory"
          :is-selected-product="isSelectedProduct"
          :category="categorySelected"
          :product="productSelected"
          @select-group="onSelectGroup"
          @select-cat="onSelectCat"
        />
        <!--end: Section Title -->

        <!--begin: Product Grid -->
        <product-grid
          :categories="categories"
          :products="products"
          :loading="loading && !productSelected"
          :show-category="isSelectedCategory"
          :show-product="isSelectedProduct"
          @select-category="onSelectCategory"
          @select-product="onSelectProduct"
        />

        <!--end: Product Grid -->
        <!--begin:FormContainer-->
        <form-container v-show="isSelectedProduct" class="row" id="form-container">
          <div ref="mainstage" class="col-md-7 col-lg-8 order-1 order-md-0 mainstage">
            <!--begin: Icon -->
            <image-form :step="step" />
            <!--end: Icon -->

            <!-- begin: Form -->
            <kt-portlet v-show="step === 1" ribbon-title="1. เลือกตัวเลือกของคุณ">
              <template v-slot:body>
                <!-- begin: loading -->
                <loading v-if="loading" class="hidden" />
                <!-- end: loading -->
                <div class="container-form">
                  <form
                    v-show="formOptions && !loading"
                    @submit.prevent="onSubmit"
                    id="form-quotation"
                  >
                    <!--begin: ขนาด -->
                    <v-row v-show="isvisibleInput('paper_size_id')">
                      <v-col xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('paper_size_id')">
                          <select2
                            :options="paperSizeIdOption"
                            v-model="attributes.paper_size_id"
                            @change="onChangePaperSizeId"
                            id="paper_size_id"
                            name="paper_size_id"
                          >
                            <option disabled>เลือกขนาด</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!--end: ขนาด -->

                    <!--begin: ขนาดกำหนดเอง -->
                    <v-row v-show="isvisibleInput('paper_size_id')  && isCustomPaper">
                      <!--begin: กว้าง -->
                      <v-col v-show="isvisibleInput('paper_size_width')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('paper_size_width')">
                          <input
                            id="paper_size_width"
                            name="paper_size_width"
                            placeholder="กว้าง"
                            class="form-control"
                            v-model="attributes.paper_size_width"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: กว้าง -->

                      <!--begin: ยาว -->
                      <v-col v-show="isvisibleInput('paper_size_lenght')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('paper_size_lenght')">
                          <input
                            id="paper_size_lenght"
                            name="paper_size_lenght"
                            placeholder="ยาว"
                            class="form-control"
                            v-model="attributes.paper_size_lenght"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ยาว -->

                      <!-- begin: สูง -->
                      <v-col v-show="isvisibleInput('paper_size_height')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('paper_size_height')">
                          <input
                            id="paper_size_height"
                            name="paper_size_height"
                            placeholder="สูง"
                            class="form-control"
                            v-model="attributes.paper_size_height"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: สูง -->

                      <!-- begin: หน่วย -->
                      <v-col v-show="isvisibleInput('paper_size_unit')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('paper_size_unit')">
                          <select2
                            id="paper_size_unit"
                            :options="pageSizeUnitOption"
                            v-model="attributes.paper_size_unit"
                            name="paper_size_unit"
                            @change="onChangeInput"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: หน่วย -->
                    </v-row>
                    <!--end: ขนาดกำหนดเอง -->

                    <!-- begin: กระดาษ -->
                    <v-row v-show="isvisibleInput('paper_id')">
                      <v-col xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('paper_id')">
                          <select2
                            id="paper_id"
                            :options="paperIdOption"
                            v-model="attributes.paper_id"
                            name="paper_id"
                            @change="onChangePaperId"
                          >
                            <option disabled>เลือกกระดาษ</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: กระดาษ -->

                    <!-- begin: แนวตั้ง/แนวนอน  -->
                    <v-row v-show="isvisibleInput('land_orient')">
                      <v-col xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('land_orient')">
                          <v-col sm="12">
                            <a-radio-group
                              name="land_orient"
                              v-model="attributes.land_orient"
                              @change="onChangeRadioInput"
                            >
                              <a-radio
                                v-for="(option, index) in landOrientOptions"
                                :key="index"
                                :value="option.value"
                              >{{option.text}}</a-radio>
                            </a-radio-group>
                          </v-col>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: แนวตั้งแนวนอน -->

                    <!-- begin: จำนวนหน้า -->
                    <v-row v-show="isvisibleInput('page_qty')">
                      <v-col xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('page_qty')">
                          <input
                            id="page_qty"
                            name="page_qty"
                            placeholder="ระบุจำนวน"
                            class="form-control"
                            v-model="attributes.page_qty"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: จำนวนหน้า -->

                    <!-- begin: จำนวนแผ่นต่อชุด -->
                    <v-row v-show="isvisibleInput('bill_detail_qty')">
                      <v-col xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('bill_detail_qty')">
                          <select2
                            id="bill_detail_qty"
                            :options="billQtyOption"
                            v-model="attributes.bill_detail_qty"
                            name="bill_detail_qty"
                            @change="onChangeInput"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: จำนวนแผ่นต่อชุด -->

                    <!-- begin: เข้าเล่ม -->
                    <box-title
                      v-show="isvisibleInput('book_binding_status')"
                      title="เข้าเล่ม"
                      line
                    />
                    <v-row v-show="isvisibleInput('book_binding_status')">
                      <!-- begin: สถานะเข้าเล่ม -->
                      <v-col v-show="isvisibleInput('book_binding_status')" xs="12" sm="6" md="6">
                        <form-group :label="false">
                          <v-col sm="12">
                            <a-radio-group
                              name="book_binding_status"
                              v-model="attributes.book_binding_status"
                              @change="onChangeBookBindingStatus"
                            >
                              <a-radio
                                v-for="(option, index) in bookBindingStatusOptions"
                                :key="index"
                                :value="option.id"
                              >{{option.text}}</a-radio>
                            </a-radio-group>
                          </v-col>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: สถานะเข้าเล่ม -->
                    </v-row>
                    <!-- begin: วิธีเข้าเล่ม -->
                    <v-row v-show="isBookBindingStatus">
                      <v-col v-show="isvisibleInput('book_binding_id')" xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('book_binding_id')">
                          <select2
                            id="book_binding_id"
                            :options="bookBindingOption"
                            v-model="attributes.book_binding_id"
                            name="book_binding_id"
                            @change="onChangeSelectInput"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <v-col v-show="isvisibleInput('book_binding_qty')" xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('book_binding_qty')">
                          <input
                            id="book_binding_qty"
                            name="book_binding_qty"
                            placeholder="ระบุจำนวน"
                            class="form-control"
                            v-model="attributes.book_binding_qty"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: วิธีเข้าเล่ม -->
                    <!-- end: เข้าเล่ม -->

                    <!-- begin: งานพิมพ์ -->
                    <box-title v-show="isvisibleInput('print_option')" title="งานพิมพ์" line />

                    <v-row v-show="isvisibleInput('print_option') || isvisibleInput('print_color')">
                      <!-- begin: พิมพ์สองหน้า/หน้าเดียว -->
                      <v-col v-show="isvisibleInput('print_option')" xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('print_option')">
                          <select2
                            id="print_option"
                            :options="printOptionOption"
                            v-model="attributes.print_option"
                            name="print_option"
                            @change="onChangeSelectInput"
                          >
                            <option disabled>เลือกรายการ</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: พิมพ์สองหน้า/หน้าเดียว -->

                      <!-- begin: สีที่พิมพ์ -->
                      <v-col v-show="isvisibleInput('print_color')" xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('print_color')">
                          <select2
                            id="print_color"
                            :options="printColorOption"
                            v-model="attributes.print_color"
                            name="print_color"
                            @change="onChangeSelectInput"
                          >
                            <option disabled>เลือกสีที่พิมพ์</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: สีที่พิมพ์ -->
                    </v-row>
                    <!-- end: งานพิมพ์ -->

                    <!-- begin: งานเคลือบ -->
                    <box-title v-show="isvisibleInput('coating_id')" title="งานเคลือบ" line />

                    <v-row
                      v-show="isvisibleInput('coating_id') || isvisibleInput('coating_option')"
                    >
                      <!-- begin: เคลือบ -->
                      <v-col v-show="isvisibleInput('coating_id')" xs="12" sm="6" md="6">
                        <form-group :label="false">
                          <select2
                            id="coating_id"
                            :options="coatingIdOption"
                            v-model="attributes.coating_id"
                            name="coating_id"
                            @change="onChangeCoatingId"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: เคลือบ -->

                      <!-- begin: ด้านที่เคลือบ -->
                      <v-col v-show="isCoating" xs="12" sm="6" md="6">
                        <form-group :label="false">
                          <v-col sm="12">
                            <p></p>
                            <a-radio-group
                              name="coating_option"
                              v-model="attributes.coating_option"
                              @change="onChangeRadioInput"
                            >
                              <a-radio
                                v-for="(option, index) in coatingOptionOptions"
                                :key="index"
                                :value="option.value"
                              >{{option.text}}</a-radio>
                            </a-radio-group>
                          </v-col>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ด้านที่เคลือบ -->
                    </v-row>
                    <!-- end: งานเคลือบ -->

                    <!-- begin: ไดคัท -->
                    <box-title
                      v-show="isvisibleInput('diecut')  && !isvisibleInput('perforate')"
                      title="ไดคัท"
                      line
                    />
                    <box-title
                      v-show="isvisibleInput('diecut')  && isvisibleInput('perforate')"
                      title="ไดคัท/ตัดเป็นตัว,เจาะ"
                      line
                    />

                    <v-row v-if="isvisibleInput('diecut') || isvisibleInput('perforate')">
                      <!-- begin: สถานะไดคัท -->
                      <v-col v-show="isvisibleInput('diecut_status')" xs="12" sm="12" md="12">
                        <form-group :label="false">
                          <a-radio-group
                            name="diecut_status"
                            v-model="attributes.diecut_status"
                            @change="onChangeDiecutStatus"
                          >
                            <a-radio
                              v-for="(option, index) in dicutStatusOptions"
                              :key="index"
                              :value="option.value"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                          <p></p>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: สถานะไดคัท -->
                    </v-row>

                    <v-row v-if="isvisibleInput('diecut') && isDicut">
                      <!-- begin: รูปแบบไดคัท -->
                      <v-col v-show="isvisibleInput('diecut')" xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('diecut')">
                          <select2
                            id="diecut"
                            :options="dicutOption"
                            v-model="attributes.diecut"
                            name="diecut"
                            @change="onChangeDicut"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: รูปแบบไดคัท -->

                      <!-- begin: ไดคัทมุมมน -->
                      <v-col v-if="isDicutCurve" xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('diecut_id')">
                          <select2
                            id="diecut_id"
                            :options="dicutIdOption"
                            v-model="attributes.diecut_id"
                            name="diecut_id"
                            @change="onChangeSelectInput"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ไดคัทมุมมน -->
                    </v-row>
                    <!-- end: ไดคัท -->

                    <!-- begin: ตัดเป็นตัว/เจาะ -->
                    <v-row v-if="isvisibleInput('perforate') && isPerforate">
                      <v-col xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('perforate')">
                          <select2
                            id="perforate"
                            :options="perforateOption"
                            v-model="attributes.perforate"
                            name="perforate"
                            @change="onChangePerforate"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: ตัดเป็นตัว/เจาะ -->

                    <!-- begin: มุมที่เจาะ -->
                    <v-row
                      v-show="isvisibleInput('perforate') && attributes.perforate === '1' && isPerforate"
                    >
                      <v-col xs="12" sm="6" md="6">
                        <form-group :input-label="inputLabel('perforate_option_id')">
                          <select2
                            id="perforate_option_id"
                            :options="perforateOptionOption"
                            v-model="attributes.perforate_option_id"
                            name="perforate_option_id"
                            @change="onChangeSelectInput"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: มุมที่เจาะ -->

                    <!-- begin: วิธีพับ -->
                    <box-title v-show="isvisibleInput('fold_id')" title="วิธีพับ" line />
                    <v-row v-if="isvisibleInput('fold_id')">
                      <v-col xs="12" sm="6" md="6">
                        <form-group :label="false">
                          <select2
                            id="fold_id"
                            :options="foldIdOption"
                            v-model="attributes.fold_id"
                            name="fold_id"
                            @change="onChangeSelectInput"
                          ></select2>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: วิธีพับ -->

                    <!-- begin: ปั๊มฟอยล์ -->
                    <box-title v-show="isvisibleInput('foil_status')" title="ปั๊มฟอยล์" line />
                    <!-- begin: สถานะ ฟอยล์ -->
                    <v-row v-show="isvisibleInput('foil_status')">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :label="false">
                          <a-radio-group
                            name="foil_status"
                            v-model="attributes.foil_status"
                            @change="onChangeFoilStatus"
                          >
                            <a-radio
                              v-for="(option, index) in foilStatusOptions"
                              :key="index"
                              :value="option.value"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: สถานะ ฟอยล์ -->

                    <v-row v-show="isvisibleInput('foil_status') && isFoil">
                      <!-- begin: ความกว้าง ฟอยล์ -->
                      <v-col v-show="isvisibleInput('foil_size_width')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('foil_size_width')">
                          <input
                            id="foil_size_width"
                            name="foil_size_width"
                            placeholder="กว้าง"
                            class="form-control"
                            v-model="attributes.foil_size_width"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ความกว้าง ฟอยล์ -->

                      <!-- begin: ความยาว ฟอยล์ -->
                      <v-col v-show="isvisibleInput('foil_size_height')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('foil_size_height')">
                          <input
                            id="foil_size_height"
                            name="foil_size_height"
                            placeholder="ยาว"
                            class="form-control"
                            v-model="attributes.foil_size_height"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ความยาว ฟอยล์ -->

                      <!-- begin: หน่วย ฟอยล์ -->
                      <v-col v-show="isvisibleInput('foil_size_unit')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('foil_size_unit')">
                          <select2
                            id="foil_size_unit"
                            :options="foilSizeUnitOption"
                            v-model="attributes.foil_size_unit"
                            name="foil_size_unit"
                            @change="onChangeSelectInput"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: หน่วย ฟอยล์ -->

                      <!-- begin: สี ฟอยล์ -->
                      <v-col v-show="isvisibleInput('foil_color_id')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('foil_color_id')">
                          <select2
                            id="foil_color_id"
                            :options="foilColorIdOption"
                            v-model="attributes.foil_color_id"
                            name="foil_color_id"
                            @change="onChangeSelectInput"
                          >
                            <option disabled value>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: สี ฟอยล์ -->
                    </v-row>

                    <!-- begin: ปั๊มฟอยล์ทั้งหน้า/หลัง หรือหน้าเดียว? -->
                    <v-row v-show="isvisibleInput('foil_print') && isFoil">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :input-label="inputLabel('foil_print')">
                          <p></p>
                          <a-radio-group
                            name="foil_print"
                            v-model="attributes.foil_print"
                            @change="onChangeRadioInput"
                          >
                            <a-radio
                              v-for="(option, index) in foliPrintOptions"
                              :key="index"
                              :value="option.value"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: ปั๊มฟอยล์ทั้งหน้า/หลัง หรือหน้าเดียว? -->

                    <!-- end: ปั๊มฟอยล์ -->

                    <!-- begin: ปั๊มนูน -->
                    <box-title v-show="isvisibleInput('emboss_status')" title="ปั๊มนูน" line />
                    <!-- begin: สถานะปั๊มนูน -->
                    <v-row v-show="isvisibleInput('emboss_status')">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :label="false">
                          <a-radio-group
                            name="emboss_status"
                            @change="onChangeEmbossStatus"
                            v-model="attributes.emboss_status"
                          >
                            <a-radio
                              v-for="(option, index) in embossStatusOptions"
                              :key="index"
                              :value="option.value"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: สถานะปั๊มนูน -->

                    <v-row v-show="isEmboss">
                      <!-- begin: ความกว้าง ปั๊มนูน -->
                      <v-col v-show="isvisibleInput('emboss_size_width')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('emboss_size_width')">
                          <input
                            id="emboss_size_width"
                            name="emboss_size_width"
                            placeholder="กว้าง"
                            class="form-control"
                            v-model="attributes.emboss_size_width"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ความกว้าง ปั๊มนูน -->

                      <!-- begin: ความยาว ปั๊มนูน -->
                      <v-col v-show="isvisibleInput('emboss_size_height')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('emboss_size_height')">
                          <input
                            id="emboss_size_height"
                            name="emboss_size_height"
                            placeholder="ยาว"
                            class="form-control"
                            v-model="attributes.emboss_size_height"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ความยาว ปั๊มนูน -->

                      <!-- begin: หน่วย ปั๊มนูน -->
                      <v-col v-show="isvisibleInput('emboss_size_unit')" xs="12" sm="3" md="3">
                        <form-group :input-label="inputLabel('emboss_size_unit')">
                          <select2
                            id="emboss_size_unit"
                            :options="embossSizeUnitOption"
                            v-model="attributes.emboss_size_unit"
                            name="emboss_size_unit"
                            @change="onChangeSelectInput"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: หน่วย ปั๊มนูน -->
                    </v-row>

                    <!-- begin: ปั๊มฟอยล์ทั้งหน้า/หลัง หรือหน้าเดียว? -->
                    <v-row v-show="isvisibleInput('emboss_print') && isEmboss">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :input-label="inputLabel('emboss_print')">
                          <p></p>
                          <a-radio-group
                            name="emboss_print"
                            v-model="attributes.emboss_print"
                            @change="onChangeRadioInput"
                          >
                            <a-radio
                              v-for="(option, index) in embossPrintOptions"
                              :key="index"
                              :value="option.value"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: ปั๊มฟอยล์ทั้งหน้า/หลัง หรือหน้าเดียว? -->

                    <!-- end: ปั๊มนูน -->

                    <!-- begin: ปะกาว -->
                    <box-title v-show="isvisibleInput('glue')" title="ปะกาว" line />
                    <v-row v-show="isvisibleInput('glue')">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :label="false">
                          <a-radio-group
                            name="glue"
                            v-model="attributes.glue"
                            @change="onChangeRadioInput"
                          >
                            <a-radio
                              v-for="(option, index) in glueOptions"
                              :key="index"
                              :value="option.value"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: ปะกาว -->

                    <!-- begin: ร้อยเชือกหูถุง -->
                    <box-title v-show="isvisibleInput('rope')" title="ร้อยเชือกหูถุง" line />
                    <v-row v-show="isvisibleInput('rope')">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :label="false">
                          <a-radio-group
                            name="rope"
                            v-model="attributes.rope"
                            @change="onChangeRadioInput"
                          >
                            <a-radio
                              v-for="(option, index) in ropeOptions"
                              :key="index"
                              :value="option.value"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: ร้อยเชือกหูถุง -->

                    <!-- begin: ปรุฉีก -->
                    <box-title v-show="isvisibleInput('perforated_ripped')" title="ปรุฉีก" line />
                    <v-row v-show="isvisibleInput('perforated_ripped')">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :label="false">
                          <a-radio-group
                            name="perforated_ripped"
                            v-model="attributes.perforated_ripped"
                            @change="onChangeRadioInput"
                          >
                            <a-radio
                              v-for="(option, index) in perforatedRippedOptions"
                              :key="index"
                              :value="option.id"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: ปรุฉีก -->

                    <!-- begin: Running number -->
                    <box-title
                      v-show="isvisibleInput('running_number')"
                      title="Running number"
                      line
                    />
                    <v-row v-show="isvisibleInput('running_number')">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :label="false">
                          <!-- <el-radio-group name="running_number" v-model="attributes.running_number">
                            <el-radio
                              v-for="(option, index) in runningNumberOptions"
                              :key="index"
                              :label="option.id"
                            >{{option.text}}</el-radio>
                          </el-radio-group>-->
                          <a-radio-group
                            name="running_number"
                            v-model="attributes.running_number"
                            @change="onChangeRadioInput"
                          >
                            <a-radio
                              v-for="(option, index) in runningNumberOptions"
                              :key="index"
                              :value="option.id"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: Running number -->

                    <!-- begin: ติดหน้าต่าง -->
                    <box-title v-show="isvisibleInput('window_box')" title="ติดหน้าต่าง" line />
                    <!-- begin: สถานะติดหน้าต่าง -->
                    <v-row v-show="isvisibleInput('window_box')">
                      <v-col xs="12" sm="12" md="12">
                        <form-group :label="false">
                          <a-radio-group
                            name="window_box"
                            v-model="attributes.window_box"
                            @change="onChangeRadioInput"
                          >
                            <a-radio
                              v-for="(option, index) in windowBoxOptions"
                              :key="index"
                              :value="option.id"
                            >{{option.text}}</a-radio>
                          </a-radio-group>
                        </form-group>
                        <help-block />
                      </v-col>
                    </v-row>
                    <!-- end: สถานะติดหน้าต่าง -->
                    <v-row v-show="isWindowbox">
                      <!-- begin: ความกว้างติดหน้าต่าง -->
                      <v-col v-show="isvisibleInput('window_box_width')" xs="12" sm="4" md="4">
                        <form-group :input-label="inputLabel('window_box_width')">
                          <input
                            id="window_box_width"
                            name="window_box_width"
                            placeholder="กว้าง"
                            class="form-control"
                            v-model="attributes.window_box_width"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ความกว้างติดหน้าต่าง -->

                      <!-- begin: ความยาวติดหน้าต่าง -->
                      <v-col v-show="isvisibleInput('window_box_lenght')" xs="12" sm="4" md="4">
                        <form-group :input-label="inputLabel('window_box_lenght')">
                          <input
                            id="window_box_lenght"
                            name="window_box_lenght"
                            placeholder="ยาว"
                            class="form-control"
                            v-model="attributes.window_box_lenght"
                            @change="onChangeInput"
                          />
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: ความยาวติดหน้าต่าง -->

                      <!-- begin: หน่วย ปั๊มนูน -->
                      <v-col v-show="isvisibleInput('window_box_unit')" xs="12" sm="4" md="4">
                        <form-group :input-label="inputLabel('window_box_unit')">
                          <select2
                            id="window_box_unit"
                            :options="windowBoxUnitOption"
                            v-model="attributes.window_box_unit"
                            name="window_box_unit"
                            @change="onChangeSelectInput"
                          >
                            <option disabled>เลือกรายการ...</option>
                          </select2>
                        </form-group>
                        <help-block />
                      </v-col>
                      <!-- end: หน่วย ปั๊มนูน -->
                    </v-row>
                    <!-- end: ติดหน้าต่าง -->
                  </form>
                </div>
              </template>
              <template v-slot:footer>
                <div v-html="productData ? productData.product_description : null"></div>
              </template>
            </kt-portlet>
            <!-- end: Form -->

            <div v-show="step === 2" class="step-two-container" id="step-two-container">
              <v-row>
                <v-col md="12">
                  <!-- begin: Content -->
                  <kt-portlet ribbon-title="2. เลือกจำนวนหรือเพิ่มจำนวนที่ต้องการ">
                    <template v-slot:body>
                      <!-- begin: Form -->
                      <form @submit.prevent="handleAddQty">
                        <v-row>
                          <v-col xs="12" sm="6" md="6">
                            <form-group :label="false">
                              <el-input
                                placeholder="จำนวนที่ต้องการ"
                                v-model="cust_quantity"
                                autofocus
                                type="tel"
                              >
                                <template slot="append">
                                  <el-button
                                    type="primary"
                                    @click="handleAddQty"
                                    v-loading.fullscreen.lock="loadingQty"
                                  >
                                    <i class="fa fa-plus"></i>
                                  </el-button>
                                </template>
                              </el-input>
                            </form-group>
                            <help-block />
                          </v-col>
                        </v-row>
                      </form>
                      <!-- end: Form -->
                      <!-- begin: widget -->
                      <kt-widget1>
                        <el-radio-group v-model="attributes.cust_quantity">
                          <el-radio
                            v-for="(item, key) in priceList"
                            :key="key"
                            :label="item.cust_quantity"
                          >
                            <widget1-item
                              :title="item.cust_quantity + ' ' + item.unit"
                              :desc="item.price_per_item + ' THB ต่อ' + item.unit"
                              :number="item.final_price + ' THB'"
                            >
                              <el-button
                                type="danger"
                                size="mini"
                                circle
                                plain
                                @click="onRemovePriceList(item.cust_quantity)"
                              >
                                <i class="fa fa-close"></i>
                              </el-button>
                            </widget1-item>
                          </el-radio>
                        </el-radio-group>
                      </kt-widget1>
                      <!-- end: widget -->
                    </template>
                    <template v-slot:footer>
                      <v-row>
                        <v-col xs="12" sm="6" md="6">
                          <p>
                            <a-button type="primary" size="large" block @click="handleBackStep">
                              <a-icon type="double-left" />ขั้นตอนก่อนหน้า
                            </a-button>
                          </p>
                        </v-col>
                        <v-col xs="12" sm="6" md="6">
                          <p>
                            <a-button
                              type="primary"
                              size="large"
                              block
                              @click="handleDownload"
                              :disabled="isEmpty(attributes.cust_quantity)"
                            >
                              <a-icon type="file-text" />ขอใบเสนอราคา
                            </a-button>
                          </p>
                        </v-col>
                      </v-row>
                    </template>
                  </kt-portlet>
                  <!-- end: Content -->
                </v-col>
              </v-row>
            </div>
          </div>
          <div class="col-md-5 col-lg-4">
            <div class="panel_scroll">
              <!-- Icon -->
              <icon-check-list />
              <!-- รายละเอียด -->
              <kt-portlet
                ribbon-title="รายละเอียดสินค้าของคุณ"
                class="product-panel animated zoomIn faster"
                :footer="step === 1"
              >
                <template v-slot:body>
                  <!-- begin: content -->
                  <div v-if="productSelected && formOptions" class="product-detail">
                    <ul class="quotation-detail" style="font-size: 14px;padding: 0;">
                      <li>
                        <span>สินค้า</span>
                        <span
                          class="float-right"
                        >{{ productSelected ? productSelected.product_name : null }}</span>
                      </li>
                    </ul>
                    <!-- loading -->
                    <loading v-if="loading" class="hidden" />
                    <ul class="quotation-detail" style="font-size: 14px;padding: 0;">
                      <!-- ขนาด -->
                      <li
                        v-for="(value, attr) in formOptions"
                        :key="attr"
                        v-show="isvisibleInput(attr) && !skipAttributes.includes(attr)"
                        class="widget-item"
                      >
                        <span class="info-label">{{ inputLabel(attr, '') }}:</span>
                        <span class="float-right">{{ getProductInfo(attr) }}</span>
                      </li>
                    </ul>
                  </div>
                  <!-- end: content -->
                </template>
                <template v-slot:footer>
                  <!-- action next step -->
                  <p>
                    <a-button type="primary" size="large" block @click="handleNextStep">
                      ขั้นตอนถัดไป
                      <a-icon type="double-right" />
                    </a-button>
                  </p>
                </template>
              </kt-portlet>
            </div>
          </div>
        </form-container>
        <!--end:FormContainer-->
      </div>
    </section>
    <div
      class="modal fade"
      id="myModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">
              <i class="fa fa-download"></i> ขอใบเสนอราคา
            </h4>
          </div>
          <div class="modal-body">
            <ValidationObserver ref="form" v-slot="{ invalid, passes }">
              <form @submit.prevent="passes(onSubmitDownload)">
                <v-row>
                  <v-col sm="12">
                    <ValidationProvider name="ชื่อลูกค้า" rules="required" v-slot="{ errors }">
                      <form-group input-label="ชื่อลูกค้า">
                        <input
                          v-model="attributeQuotation.quotation_customer_name"
                          type="text"
                          class="form-control"
                          name="quotation_customer_name"
                          id="quotation_customer_name"
                        />
                      </form-group>
                      <help-block :message="errors[0]" class="text-danger" />
                    </ValidationProvider>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col sm="12">
                    <ValidationProvider name="ที่อยู่" rules="required" v-slot="{ errors }">
                      <form-group input-label="ที่อยู่">
                        <textarea
                          v-model="attributeQuotation.quotation_customer_address"
                          type="text"
                          class="form-control"
                          name="quotation_customer_address"
                          id="quotation_customer_address"
                        />
                      </form-group>
                      <help-block :message="errors[0]" class="text-danger" />
                    </ValidationProvider>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col sm="12">
                    <ValidationProvider name="อีเมล์" rules="required|email" v-slot="{ errors }">
                      <form-group input-label="อีเมล์">
                        <input
                          v-model="attributeQuotation.quotation_customer_email"
                          type="email"
                          class="form-control"
                          name="quotation_customer_email"
                          id="quotation_customer_email"
                        />
                      </form-group>
                      <help-block :message="errors[0]" class="text-danger" />
                    </ValidationProvider>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col sm="6">
                    <ValidationProvider
                      name="เบอร์โทร"
                      rules="required|numeric"
                      v-slot="{ errors }"
                    >
                      <form-group input-label="เบอร์โทร">
                        <input
                          v-model="attributeQuotation.quotation_customer_tel"
                          type="tel"
                          class="form-control"
                          name="quotation_customer_tel"
                          id="quotation_customer_tel"
                        />
                      </form-group>
                      <help-block :message="errors[0]" class="text-danger" />
                    </ValidationProvider>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col sm="6">
                    <ValidationProvider name="แฟกซ์" rules="numeric" v-slot="{ errors }">
                      <form-group input-label="แฟกซ์">
                        <input
                          v-model="attributeQuotation.quotation_customer_fax"
                          type="text"
                          class="form-control"
                          name="quotation_customer_fax"
                          id="quotation_customer_fax"
                        />
                      </form-group>
                      <help-block :message="errors[0]" class="text-danger" />
                    </ValidationProvider>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col sm="12" class="text-right">
                    <a-button type="danger" data-dismiss="modal">
                      <a-icon type="close" />ยกเลิก
                    </a-button>
                    <a-button type="primary" htmlType="submit">
                      <a-icon type="file-text" />ขอใบเสนอราคา
                    </a-button>
                  </v-col>
                </v-row>
              </form>
            </ValidationObserver>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Loading } from "element-ui";
import Swal from "sweetalert2";
import Select2 from "../components/Select2";
import ProductGrid from "../components/ProductGrid";
import Panel from "../components/Panel";
import SectionTitle from "../components/SectionTitle";
import FormContainer from "../components/FormContainer";
import ImageForm from "../components/ImageForm";
import LoadingContent from "../components/Loading";
import VCol from "../components/Col";
import VRow from "../components/Row";
import BoxTitle from "../components/BoxTitle";
import FormGroup from "../components/InputFormGroup";
import HelpBlock from "../components/HelpBlock";
import KtPortlet from "../components/KtPortlet";
import KtWidget1 from "../components/KtWidget1";
import Widget1Item from "../components/Widget1Item";
import IconCheckList from "../components/IconCheckList";
import { ValidationObserver } from "vee-validate";

function format(state) {
  if (!state.id) return state.text; // optgroup
  return state.text;
}
let token = document.head.querySelector('meta[name="csrf-token"]');

export default {
  name: "ProductPage",
  components: {
    Select2,
    ProductGrid,
    Panel,
    SectionTitle,
    FormContainer,
    ImageForm,
    VCol,
    VRow,
    BoxTitle,
    FormGroup,
    HelpBlock,
    loading: LoadingContent,
    ValidationObserver,
    KtPortlet,
    KtWidget1,
    Widget1Item,
    IconCheckList
  },
  data() {
    return {
      loading: false,
      loadingQty: false,
      liffData: null,
      checkList: "",
      cust_quantity: "", // จำนวนที่ต้องการ
      options: [{ id: 1, text: "Hello" }, { id: 2, text: "World" }],
      categories: [], // ประเภทสินค้า
      products: [], // สินค้า

      radioStyle: {
        display: "block",
        height: "30px",
        lineHeight: "30px"
      },

      catId: "", // ไอดีประเภทสินค้า
      productId: "", // ไอดีสินค้า

      dataOptions: {},
      formOptions: {},
      productData: null,
      attributes: {
        "_csrf-frontend": window.yii ? window.yii.getCsrfToken() : token.content
      },

      step: 1,

      // input options
      // ขนาด
      paperSizeIdOption: {
        data: [],
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกขนาด",
        language: "th"
      },
      // หน่วยขนาด
      pageSizeUnitOption: {
        data: [],
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกหน่วย",
        language: "th"
      },
      // เข้าเล่ม
      bookBindingOption: {
        data: [],
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกรายการ...",
        language: "th"
      },
      // กระดาษ
      paperIdOption: {
        data: [],
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกกระดาษ",
        language: "th"
      },
      // สีที่พิมพ์
      printColorOption: {
        data: [],
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกรายการ...",
        language: "th"
      },
      // จำนวนแผ่นต่อชุด
      billQtyOption: {
        data: [],
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกจำนวนแผ่นต่อชุด",
        language: "th"
      },
      // เคลือบ
      coatingIdOption: {
        data: [],
        placeholder: "เลือกรายการ ...",
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกวิธีเคลือบ",
        language: "th"
      },
      // ไดคัทมุมมน
      dicutIdOption: {
        data: [],
        placeholder: "เลือกรายการ ...",
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกไดคัท",
        language: "th"
      },
      // ตัดเป็นตัว/เจาะ
      perforateOption: {
        data: [],
        placeholder: "เลือกรายการ ...",
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือก",
        language: "th"
      },
      // พับ
      foldIdOption: {
        data: [],
        placeholder: "เลือกรายการ ...",
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        language: "th"
      },
      // หน่วยฟอยล์
      foilSizeUnitOption: {
        data: [],
        placeholder: "เลือกหน่วย ...",
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกหน่วย",
        language: "th"
      },
      // สีฟอย์ล
      foilColorIdOption: {
        data: [],
        placeholder: "เลือกสีฟอยล์ ...",
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกสีฟอยล์",
        language: "th"
      },
      // หน่วยปั๊มนูน
      embossSizeUnitOption: {
        data: [],
        placeholder: "เลือกหน่วย ...",
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกหน่วย",
        language: "th"
      },
      // เจาะ
      perforateOptionOption: {
        data: [],
        placeholder: "เลือกรายการ ...",
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกมุมเจาะ",
        language: "th"
      },
      // สถานะปั๊มฟอยล์
      foilStatusOption: {
        data: [],
        placeholder: "เลือกรายการ ...",
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        language: "th"
      },
      // สถานะปั๊มนูน
      embossStatusOption: {
        data: [],
        placeholder: "เลือกรายการ ...",
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m;
        },
        theme: "bootstrap",
        width: "100%",
        language: "th"
      },
      // พิมพ์สองหน้าหรือหน้าเดียว
      printOptionOption: {
        data: [],
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกรายการ...",
        language: "th"
      },
      // ไดคัท
      dicutOption: {
        data: [],
        placeholder: "เลือกรายการ ...",
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกรูปแบบไดคัท",
        language: "th",
        data: []
      },
      // หน่วยติดหน้าต่าง
      windowBoxUnitOption: {
        data: [],
        placeholder: "เลือกหน่วย ...",
        allowClear: true,
        theme: "bootstrap",
        width: "100%",
        placeholder: "เลือกหน่วย",
        language: "th"
      },

      /* ข้อมูลตัวเลือก */

      // สถานะฟอยล์
      foilStatusOptions: [],
      // ปั๊มฟอยล์ หน้า-หลัง/หน้าเดียว
      foliPrintOptions: [],
      // สถานะปั๊มนูน
      embossStatusOptions: [],
      // ปั๊มนูน หน้า-หลัง/หน้าเดียว
      embossPrintOptions: [],
      // ปะกาว
      glueOptions: [],
      // ร้อยเชือกหูถุง
      ropeOptions: [],
      // แนวตั้ง/แนวนอน
      landOrientOptions: [],
      // เคลือบด้านเดียวหรือสองด้าน
      coatingOptionOptions: [],
      // สถานะไดคัท
      dicutStatusOptions: [],
      // สถานะเข้าเล่ม
      bookBindingStatusOptions: [],
      // ปรุฉีก
      perforatedRippedOptions: [],
      // running number
      runningNumberOptions: [],
      // ติดหน้าต่าง
      windowBoxOptions: [],
      // ราคา
      priceList: [],
      // ฟิลด์ที่ไม่ต้องการแสดงรายละเอียด
      skipAttributes: [],
      // ฟิลด์ฟอร์มดาวน์โหลดใบเสนอราคา
      attributeQuotation: {
        "_csrf-frontend": window.yii
          ? window.yii.getCsrfToken()
          : token.content,
        quotation_customer_name: "",
        quotation_customer_address: "",
        quotation_customer_email: "",
        quotation_customer_tel: "",
        quotation_customer_fax: ""
      }
    };
  },
  computed: {
    // สถานะการเลือกประเภทสินค้า
    isSelectedCategory() {
      return !this.isEmpty(this.catId);
    },
    // สถานะการเลือกสินค้า
    isSelectedProduct() {
      return !this.isEmpty(this.productId);
    },
    // สินค้าที่เลือก
    productSelected() {
      if (!this.isSelectedProduct || !this.products) return null;
      return this.products.find(item => item.product_id === this.productId);
    },
    // ประเภทสินค้าที่เลือก
    categorySelected() {
      if (!this.isSelectedCategory) return null;
      return this.categories.find(
        item => item.product_category_id === this.catId
      );
    },
    sectionTitle() {
      if (!this.isSelectedCategory && !this.isSelectedProduct)
        return "หมวดหมู่";
      if (this.isSelectedCategory && !this.isSelectedProduct) return "สินค้า";
      if (this.isSelectedProduct && this.productSelected) {
        return this.productSelected.product_name;
      }
      return "หมวดหมู่";
    },
    // กำหนดขนาดเอง true or false
    isCustomPaper() {
      if (this.isEmpty(this.attributes["paper_size_id"])) return false;
      return this.attributes.paper_size_id === "custom";
    },
    // เคลือบ ไม่เคลือบ true or false
    isCoating() {
      if (this.isEmpty(this.attributes["coating_id"])) return false;
      return this.attributes.coating_id && this.attributes.coating_id !== "N";
    },
    // ไดคัท true or false
    isDicut() {
      if (this.isEmpty(this.attributes["diecut_status"])) return false;
      return this.attributes.diecut_status === "dicut";
    },
    // ไดคัมมุมมน true or false
    isDicutCurve() {
      if (!this.isDicut) return false;
      return (
        this.attributes.diecut === "Curve" && this.isvisibleInput("diecut_id")
      );
    },
    // สถานะตัดเป็นตัว เจาะ true or false
    isPerforate() {
      return this.attributes.diecut_status === "perforate";
    },
    // สถานะปั๊มฟอยล์ true or false
    isFoil() {
      if (this.isEmpty(this.attributes["foil_status"])) return false;
      return this.attributes.foil_status === "Y";
    },
    // สถานะปั๊มนูน true or false
    isEmboss() {
      if (this.isEmpty(this.attributes["emboss_status"])) return false;
      return this.attributes.emboss_status === "Y";
    },
    // สถานะเข้าเล่ม true or false
    isBookBindingStatus() {
      if (this.isEmpty(this.attributes["book_binding_status"])) return false;
      return this.attributes.book_binding_status === 1;
    },
    // สถานะ running number true or false
    isRunningNumber() {
      if (this.isEmpty(this.attributes["running_number"])) return false;
      return this.attributes.running_number === 1;
    },
    // สถานะติดหน้าต่าง true or false
    isWindowbox() {
      if (this.isEmpty(this.attributes["window_box"])) return false;
      return this.attributes.window_box === 1;
    },
    // รายละเอียดขนาด
    paperSizeDetail() {
      const _this = this;
      if (_this.isEmpty(_this.attributes.paper_size_id)) return "-"; // ถ้าไม่เลือกขนาด
      const paper = _this.paperSizeIdOption.data.find((item, index) => {
        return item.id === _this.attributes.paper_size_id;
      }); // หาขนาดที่เลือก
      if (_this.isEmpty(paper)) return "-"; // ไม่เจอขนาดที่เลือก
      if (_this.isCustomPaper) {
        // ถ้าเลือกขนาดกำหนดเอง
        if (_this.paper_size_height) {
          // ถ้ามีขนาดความสูง return {กว้าง x ยาว x สูง หน่วย}
          return `${_this.paper_size_width}x${_this.paper_size_lenght}x${_this.paper_size_height} ${_this.paper_size_unit}`;
        }
        // ถ้าไม่มีขนาดความสูง return {กว้าง x ยาว หน่วย}
        return `${_this.paper_size_width}x${_this.paper_size_lenght} ${_this.paper_size_unit}`;
      }
      return _this.replaceHtml(paper.text); // ชื่อขนาด
    },
    // ความกว้างกำหนดเอง
    paper_size_width() {
      if (!this.attributes.paper_size_width) return "";
      return this.attributes.paper_size_width;
    },
    // ความยาวกำหนดเอง
    paper_size_lenght() {
      if (!this.attributes.paper_size_lenght) return "";
      return this.attributes.paper_size_lenght;
    },
    // ความสูงกำหนดเอง
    paper_size_height() {
      if (!this.attributes.paper_size_height) return "";
      return this.attributes.paper_size_height;
    },
    // หน่วยกำหนดเอง
    paper_size_unit() {
      if (!this.attributes.paper_size_unit) return "";
      const data = this.pageSizeUnitOption.data.find(item => {
        return item.id === this.attributes.paper_size_unit;
      });
      return data ? this.replaceHtml(data.text) : "";
    },
    // รายละเอียดกระดาษ
    paperDetail: function() {
      if (!this.attributes.paper_id) return "-";
      let paper = null;

      this.paperIdOption.data.map(item => {
        if (item.id === this.attributes.paper_id) {
          paper = item;
        } else if (item.children.length > 0) {
          return item.children.map(children => {
            if (children.id === this.attributes.paper_id) {
              paper = children;
            }
          });
        }
      });
      if (this.isEmpty(paper)) return "-";
      return this.replaceHtml(paper.text);
    },
    // รายละเอียดแนวตั้ง แนวนอน
    landOrientDetail() {
      if (!this.attributes.land_orient) return "-";
      const data = this.landOrientOptions.find(
        item => item.value === this.attributes.land_orient
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // รายละเอียดวิธีเข้าเล่ม
    bookBindingDetail() {
      if (this.isEmpty(this.attributes.book_binding_status)) return "-";
      if (!this.attributes.book_binding_status) return "ไม่เข้าเล่ม";
      const data = this.bookBindingOption.data.find(
        item => item.id === this.attributes.book_binding_id
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // รายละเอียดจำนวนหน้า/จำนวนแผ่น
    pageQty() {
      if (this.isEmpty(this.attributes.page_qty)) return "-";
      return this.attributes.page_qty;
    },
    // รายละเอียดจำนวนแผ่นต่อชุด
    billQty() {
      if (!this.attributes.bill_detail_qty) return "-";
      const data = this.billQtyOption.data.find(
        item => item.id === this.attributes.bill_detail_qty
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // รายละเอียดพิมพ์สองหน้า พิมพ์หน้าเดียว
    printOptionDetail() {
      if (!this.attributes.print_option) return "-";
      const data = this.printOptionOption.data.find(
        item => item.id === this.attributes.print_option
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // รายละเอียดสีที่พิมพ์
    printColorDetail() {
      if (!this.attributes.print_color) return "-";
      const data = this.printColorOption.data.find(
        item => item.id === this.attributes.print_color
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // รายละเอียดเคลือบ
    coatingDetail() {
      if (!this.attributes.coating_id) return "-";
      const data = this.coatingIdOption.data.find(
        item => item.id === this.attributes.coating_id
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text) + " " + this.coatingOptionDetail;
    },
    // รายละเอียดด้านที่เคลือบ
    coatingOptionDetail() {
      if (!this.attributes.coating_option) return "";
      const data = this.coatingOptionOptions.find(
        item => item.value === this.attributes.coating_option
      );
      if (this.isEmpty(data)) return "";
      return this.replaceHtml(data.text);
    },
    // รายละเอียดไดคัท/ตัดเป็นตัว,เจาะ
    dicutStatusDetail() {
      if (!this.attributes.diecut_status) return "-";
      const data = this.dicutStatusOptions.find(
        item => item.value === this.attributes.diecut_status
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // รายละเอียดตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว
    perforateDetail() {
      if (!this.attributes.perforate) return "-";
      const data = this.perforateOption.data.find(
        item => item.id === this.attributes.perforate
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // มุมที่เจาะ
    perforateOptionDetail() {
      if (!this.attributes.perforate_option_id) return "-";
      let perforate = null;

      this.perforateOptionOption.data.map(item => {
        if (item.id === this.attributes.perforate_option_id) {
          perforate = item;
        } else if (item.children.length > 0) {
          return item.children.map(children => {
            if (children.id === this.attributes.perforate_option_id) {
              perforate = children;
            }
          });
        }
      });
      if (this.isEmpty(perforate)) return "-";
      return this.replaceHtml(perforate.text);
    },
    // รูปแบบไดคัท
    diecutDetail() {
      if (!this.attributes.diecut) return "-";
      const data = this.dicutOption.data.find(
        item => item.id === this.attributes.diecut
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // ไดคัทมุมมน
    dicutCurveDetail() {
      if (!this.attributes.diecut_id) return "-";
      const data = this.dicutIdOption.data.find(
        item => item.id === this.attributes.diecut_id
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // วิธีพับ
    foldDetail() {
      if (!this.attributes.fold_id) return "-";
      const data = this.foldIdOption.data.find(
        item => item.id === this.attributes.fold_id
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // ปั๊มฟอยล์
    foilDetail() {
      if (this.attributes.foil_status === "N") return "ไม่ปั๊มฟอยล์";
      if (!this.isFoil) return "-";
      return `${this.foil_size_width}x${this.foil_size_height} ${this.foil_size_unit} ${this.foil_color} ${this.foil_print}`;
    },
    // ความกว้าง(ฟอยล์)
    foil_size_width() {
      if (!this.attributes.foil_size_width) return "";
      return this.attributes.foil_size_width;
    },
    // ความยาว(ฟอยล์)
    foil_size_height() {
      if (!this.attributes.foil_size_height) return "";
      return this.attributes.foil_size_height;
    },
    // หน่วย(ฟอยล์)
    foil_size_unit() {
      if (!this.attributes.foil_size_unit) return "";
      const data = this.foilSizeUnitOption.data.find(
        item => item.id === this.attributes.foil_size_unit
      );
      if (this.isEmpty(data)) return "";
      return this.replaceHtml(data.text);
    },
    // สีฟอยล์
    foil_color() {
      if (!this.attributes.foil_color_id) return "";
      const data = this.foilColorIdOption.data.find(
        item => item.id === this.attributes.foil_color_id
      );
      if (this.isEmpty(data)) return "";
      return this.replaceHtml(data.text);
    },
    // ปั๊มฟอยล์ หน้า-หลัง/หน้าเดียว
    foil_print() {
      if (!this.attributes.foil_print) return "-";
      const data = this.foliPrintOptions.find(
        item => item.value === this.attributes.foil_print
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // ปั๊มนูน
    embossDetail() {
      if (this.attributes.emboss_status === "N") return "ไม่ปั๊มนูน";
      if (!this.isEmboss) return "-";
      return `${this.emboss_size_width}x${this.emboss_size_height} ${this.emboss_size_unit} ${this.emboss_print}`;
    },
    // กว้าง(ปั๊มนูน)
    emboss_size_width() {
      if (!this.attributes.emboss_size_width) return "";
      return this.attributes.emboss_size_width;
    },
    // ยาว(ปั๊มนูน)
    emboss_size_height() {
      if (!this.attributes.emboss_size_height) return "";
      return this.attributes.emboss_size_height;
    },
    // หน่วย(ปั๊มนูน)
    emboss_size_unit() {
      if (!this.attributes.emboss_size_unit) return "";
      const data = this.embossSizeUnitOption.data.find(
        item => item.id === this.attributes.emboss_size_unit
      );
      if (this.isEmpty(data)) return "";
      return this.replaceHtml(data.text);
    },
    // ปั๊มนูน หน้า-หลัง/หน้าเดียว
    emboss_print() {
      if (!this.attributes.emboss_print) return "-";
      const data = this.embossPrintOptions.find(
        item => item.value === this.attributes.emboss_print
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // ปะกาว
    glueDetail() {
      if (!this.attributes.glue) return "-";
      const data = this.glueOptions.find(
        item => item.value === this.attributes.glue
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // ร้อยเชือกหูถุง
    ropeDetail() {
      if (!this.attributes.rope) return "-";
      const data = this.ropeOptions.find(
        item => item.value === this.attributes.rope
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // รายละเอียดปรุฉีก
    perforatedRippedDetail() {
      if (this.isEmpty(this.attributes.perforated_ripped)) return "-";
      const data = this.perforatedRippedOptions.find(
        item => item.id === this.attributes.perforated_ripped
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // จำนวนแผ่นต่อเล่ม(คูปอง)
    book_binding_qty() {
      if (!this.attributes.book_binding_qty) return "-";
      return this.attributes.book_binding_qty;
    },
    // รายละเอียด running_number
    runningNumberDetail() {
      if (this.isEmpty(this.attributes.running_number)) return "-";
      const data = this.runningNumberOptions.find(
        item => item.id === this.attributes.running_number
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    },
    // ติดหน้าต่าง
    windowBoxDetail() {
      if (this.isEmpty(this.attributes.window_box)) return "-";
      if (!this.attributes.window_box) return "ไม่ติดหน้าต่าง";
      if (!this.isWindowbox) return "-";
      return `${this.window_box_width}x${this.window_box_lenght} ${this.window_box_unit}`;
    },
    // ความกว้างติดหน้าต่าง
    window_box_width() {
      if (!this.attributes.window_box_width) return "";
      return this.attributes.window_box_width;
    },
    // ความยาวติดหน้าต่าง
    window_box_lenght() {
      if (!this.attributes.window_box_lenght) return "";
      return this.attributes.window_box_lenght;
    },
    // หน่วย(ปั๊มนูน)
    window_box_unit() {
      if (!this.attributes.window_box_unit) return "";
      const data = this.windowBoxUnitOption.data.find(
        item => item.id === this.attributes.window_box_unit
      );
      if (this.isEmpty(data)) return "";
      return this.replaceHtml(data.text);
    },
    // จำนวน
    oldQtyItems() {
      const _this = this;
      const items = [];
      _this.priceList.map(item => {
        items.push(item.cust_quantity);
      });
      return items;
    },
    bookBindingStatus() {
      if (this.isEmpty(this.attributes.book_binding_status)) return "-";
      const data = this.bookBindingStatusOptions.find(
        item => item.id === this.attributes.book_binding_status
      );
      if (this.isEmpty(data)) return "-";
      return this.replaceHtml(data.text);
    }
  },
  mounted() {
    this.fetchDataProductCategoryList();
    this.initializeApp();
  },
  methods: {
    async fetchDataProductCategoryList() {
      var _this = this;
      _this.setLoading(true);
      let loadingInstance = Loading.service({ fullscreen: true });
      const params = this.$route.query; // window.yii.getQueryParams(window.location.search);

      try {
        const { data } = await window.axios.get(
          "/app/api/product-category-list"
        );
        // handle success
        _this.categories = await data;
        if (!_this.isEmpty(params) && !_this.isEmpty(params.catId)) {
          this.catId = parseInt(params.catId);
          await _this.fetchDataProductCategory(params.catId);
          await _this.onSelectProduct(params.productId);
        }
        setTimeout(function() {
          _this.initLazyImages();
        });
        _this.setLoading(false);
        loadingInstance.close();
      } catch (error) {
        // handle error
        _this.setLoading(false);
        loadingInstance.close();
        this.$message.error(this.getErrorMessage(error));
      }
    },
    // กลุ่มสินค้า
    async fetchDataProductCategory(id) {
      var _this = this;
      _this.setLoading(true);
      let loadingInstance = Loading.service({ fullscreen: true });
      try {
        const { data } = await window.axios.get(
          `/app/api/get-product-category?id=${id}`
        );
        _this.products = await data.items;
        _this.setLoading(false);
        loadingInstance.close();
        _this.scrollTop();
      } catch (error) {
        _this.setLoading(false);
        loadingInstance.close();
        this.$message.error(this.getErrorMessage(error));
      }
    },
    // ข้อมูลตัวเลือก
    async fetchDataOptions() {
      const _this = this;
      _this.setLoading(true);
      let loadingInstance = Loading.service({ fullscreen: true });
      try {
        const { data } = await window.axios.get(
          `/app/api/quotation?p=${_this.productId}`
        );
        const {
          dataOptions,
          formOptions,
          formAttributes,
          product,
          skipAttributes
        } = data;
        // set options
        _this.dataOptions = await dataOptions; // ข้อมูลตัวเลือก
        _this.formOptions = await formOptions; // ข้อมูลตั้งค่าฟิลด์
        _this.skipAttributes = await skipAttributes; // ข้อมูลตั้งค่าฟิลด์
        _this.attributes = await _this.updateObject(
          // ฟิลด์ข้อมูล tbl_quotation_detail
          _this.attributes,
          this.updateObject(formAttributes, {
            product_id: _this.productId
          })
        );
        _this.productData = await product; // ข้อมูลสินค้าที่เลือก

        await _this.setInputDataOptions(); // กำหนดข้อมูลตัวเลือก
        _this.$nextTick(function() {
          _this.restoreStorage();
        });
        _this.setLoading(false);
        const cacheData = JSON.parse(localStorage.getItem("formData"));
        const selectElm = $("#form-quotation").find("select.select2");
        const select2 = [];

        if (_this.isEmpty(cacheData)) {
          $("select.select2")
            .val("")
            .trigger("change");
        }
        await new Promise(resolve => {
          setTimeout(function() {
            $("#paper_size_id")
              .val(_this.attributes.paper_size_id)
              .trigger("change");
            selectElm.each(function(index, el) {
              if (_this.isEmpty(_this.attributes[el.id])) {
                $("#" + el.id)
                  .val("")
                  .trigger("change");
              } else if (!_this.isEmpty(_this.attributes[el.id])) {
                $("#" + el.id)
                  .val(_this.attributes[el.id])
                  .trigger("change");
              }
            });
            $("#loading, #loading2, .desc").hide();
            loadingInstance.close();
            _this.initScroll();
            _this.scrollTop();
            resolve();
          }, 1000);
        });
      } catch (error) {
        _this.setLoading(false);
        loadingInstance.close();
        this.$message.error(this.getErrorMessage(error));
      }
    },
    // จำนวนแผ่นต่อชุด
    async fetchDataBillFloorOptions() {
      let attributes = this.attributes;
      if (this.isvisibleInput("bill_detail_qty")) {
        try {
          const { data } = await window.axios.get(
            `/app/api/bill-floor-options?paper_size_id=${attributes.paper_size_id}&paper_id=${attributes.paper_id}`
          );
          // handle success
          this.billQtyOption = await this.updateObject(this.billQtyOption, {
            data: this.mapDataOptions(data)
          });
          // this.$nextTick(function() {
          //   this.attributes.bill_detail_qty = "";
          // });
          setTimeout(() => {
            $("#bill_detail_qty")
              .val(this.attributes.bill_detail_qty)
              .trigger("change");
          }, 500);
        } catch (error) {
          this.$message.error(this.getErrorMessage(error));
        }
      }
    },
    // เลือกประเภทสินค้า
    onSelectCategory(catId) {
      this.catId = catId;
      this.fetchDataProductCategory(catId);
      /* const data = { "first name": "George", "last name": "Jetson", age: 110 };
      const querystring = this.encodeQueryData(data); */
    },
    onSelectCat(catId) {
      this.catId = catId;
      this.productId = "";
    },
    onSelectGroup() {
      this.catId = "";
      this.productId = "";
    },
    // เลือกสินค้า
    onSelectProduct(productId) {
      this.step = 1;
      this.productId = productId;
      this.formOptions = {};
      this.productData = null;
      this.fetchDataOptions();
    },
    onSubmit() {
      console.log("onSubmit");
    },
    setLoading: function(loading) {
      this.loading = loading;
    },
    initLazyImages: function() {
      var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

      if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function(
          entries,
          observer
        ) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              let lazyImage = entry.target;
              lazyImage.src = lazyImage.dataset.src;
              lazyImage.srcset = lazyImage.dataset.srcset;
              lazyImage.classList.remove("lazy");
              setTimeout(function() {
                lazyImage.classList.remove("blur");
              }, 1000);
              lazyImageObserver.unobserve(lazyImage);
            }
          });
        });

        lazyImages.forEach(function(lazyImage) {
          lazyImageObserver.observe(lazyImage);
        });
      }
    },
    isEmpty: function(value) {
      return value === null || value === undefined || value.length === 0;
    },
    isvisibleInput: function(attribute) {
      if (this.isEmpty(this.formOptions)) return false;
      if (this.isEmpty(this.formOptions[attribute])) return false;
      return (
        this.formOptions[attribute] && this.formOptions[attribute].value === "1"
      );
    },
    // event เลือกขนาด
    onChangePaperSizeId: function(e) {
      const _this = this;
      if (e.target.value !== "custom") {
        // กำหนดเอง
        _this.attributes = _this.updateObject(_this.attributes, {
          paper_size_width: "",
          paper_size_lenght: "",
          paper_size_height: "",
          paper_size_unit: ""
        });
        $("#paper_size_unit")
          .val("")
          .trigger("change");
      }
      // จำนวนแผ่นต่อชุด
      if (this.isvisibleInput("bill_detail_qty")) {
        this.fetchDataBillFloorOptions();
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    // event เลือกกระดาษ
    onChangePaperId: function(e) {
      // จำนวนแผ่นต่อชุด
      if (this.isvisibleInput("bill_detail_qty")) {
        this.fetchDataBillFloorOptions();
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    // event เลือกเคลือบ
    onChangeCoatingId: function(e) {
      if (e.target.value === "N" || this.isEmpty(e.target.value)) {
        // ถ้าไม่เคลือบ ให้เคลียร์ข้อมูลด้านที่เคลือบ
        this.attributes.coating_option = "";
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    // event เลือกไดคัท
    onChangeDiecutStatus: function(e) {
      const _this = this;
      // const value = e.target.value;
      if (e.target.value === "not-dicut" || e.target.value === "perforate") {
        // ไม่ไดคัท หรือ ตัดเจาะ
        _this.attributes.diecut = "N";
        _this.attributes.diecut_id = ""; // set empty รูปแบบไดคัท
        setTimeout(function() {
          // set empty รูปแบบไดคัท, มุมไดคัท, ตัดเป็นตัว เจาะ
          $("#diecut, #diecut_id, #perforate")
            .val("")
            .trigger("change");
        }, 300);
      } else if (e.target.value === "dicut") {
        // ไดคัท
        _this.attributes.diecut = ""; // set empty รูปแบบไดคัท
        _this.attributes.perforate = ""; // set empty ตัดเป็นตัว เจาะ
        _this.attributes.perforate_option_id = ""; // set empty มุมที่เจาะ
        setTimeout(function() {
          // set empty
          $("#perforate, #perforate_option_id")
            .val("")
            .trigger("change");
        }, 300);
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    // event เลือกรูปแบบไดคัท
    onChangeDicut: function(value) {
      if (value === "N" || value === "Default" || this.isEmpty(value)) {
        // ถ้าไม่ไดคัท หรือ ไดคัทตามรูปแบบ
        this.attributes.diecut_id = ""; // set empty
        $("#diecut_id") // set empty
          .val("")
          .trigger("change");
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    // เลือกตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว
    onChangePerforate: function(e) {
      const _this = this;
      if (e.target.value !== "1") {
        // ไม่ตัดเป็นตัว
        _this.attributes.perforate_option_id = ""; // set empty มุมที่เจาะ
        $("#perforate_option_id") // set empty
          .val("")
          .trigger("change");
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    // event เลือกสถานะปั๊มฟอยล์
    onChangeFoilStatus: function(e) {
      if (e.target.value !== "Y" || this.isEmpty(e.target.value)) {
        // ไม่ปั๊ม
        this.attributes = this.updateObject(this.attributes, {
          foil_color_id: "", // set empty สี
          foil_size_height: "", // set empty ความสูง
          foil_size_unit: "", // set empty หน่วย
          foil_size_width: "", // set empty ความกว้าง
          foil_print: "" // set empty ปั๊มฟอยล์ทั้งหน้า/หลังหรือหน้าเดียว
        });
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    // event เลือกสถานะปั๊มนูน
    onChangeEmbossStatus: function(e) {
      if (e.target.value !== "Y" || this.isEmpty(e.target.value)) {
        // ไม่ปั๊ม
        this.attributes = this.updateObject(this.attributes, {
          emboss_size_height: "", // set empty ความสูง
          emboss_size_unit: "", // set empty หน่วย
          emboss_size_width: "", // set empty ความกว้าง
          emboss_print: "" // set empty ปั๊มทั้งหน้า/หลังหรือหน้าเดียว
        });
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    // event เลือกเข้าเล่ม
    onChangeBookBindingStatus: function(e) {
      const _this = this;
      if (e.target.value === 0) {
        // ไม่เข้าเล่ม
        _this.attributes.book_binding_id = ""; // set empty วิธีเข้าเล่ม
        $("#book_binding_id")
          .val("")
          .trigger("change");
      }
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    onChangeInput() {
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    onChangeRadioInput() {
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    onChangeSelectInput() {
      this.$nextTick(function() {
        this.saveStorage();
      });
    },
    updateObject(oldObject, updatedProperties) {
      return {
        ...oldObject,
        ...updatedProperties
      };
    },
    storeData: async function() {
      let formData = {};
      const cacheData = await JSON.parse(localStorage.getItem("formData"));
      if (cacheData && cacheData[this.productId]) {
        const attributes = await this.attributes;
        const cacheAttributes = await cacheData[this.productId];
        for (let i in this.attributes) {
          if (
            this.isEmpty(attributes[i]) &&
            !this.isEmpty(cacheAttributes[i])
          ) {
            attributes[i] = cacheAttributes[i];
          }
        }
        formData[this.productId] = await attributes;
      } else if (cacheData) {
        formData[this.productId] = await this.attributes;
        formData = await this.updateObject(formData, cacheData);
      }
      localStorage.setItem(
        "formData",
        JSON.stringify(Object.assign(cacheData, formData))
      );
    },
    saveStorage() {
      let formData = {};
      const cacheData = JSON.parse(localStorage.getItem("formData"));
      formData[this.productId] = this.attributes;
      if (cacheData) {
        localStorage.setItem(
          "formData",
          JSON.stringify(Object.assign(cacheData, formData))
        );
      } else {
        localStorage.setItem("formData", JSON.stringify(formData));
      }
    },
    restoreStorage() {
      const cacheData = JSON.parse(localStorage.getItem("formData"));
      if (cacheData && cacheData[this.productId]) {
        this.attributes = Object.assign(
          this.attributes,
          cacheData[this.productId]
        );
      }
    },
    mapDataOptions: function(options) {
      let dataOptions = [];
      for (const key in options) {
        if (typeof options[key] === "object") {
          dataOptions.push({
            id: key,
            text: key,
            children: this.mapDataOptions(options[key])
          });
        } else {
          dataOptions.push({ id: key, text: options[key] });
        }
      }
      return dataOptions;
    },
    async setInputDataOptions() {
      const _this = this;
      const { dataOptions, formOptions } = _this;
      if (!_this.isEmpty(dataOptions) && !_this.isEmpty(formOptions)) {
        // ขนาด
        if (
          _this.isvisibleInput("paper_size_width") &&
          _this.isvisibleInput("paper_size_lenght") &&
          _this.isvisibleInput("paper_size_unit")
        ) {
          await _this.mapSelect2Data(
            "paperSizeIdOption",
            dataOptions.paperSizeOptions
          );
        } else {
          const paperSizeOptions = {};
          for (const key in dataOptions.paperSizeOptions) {
            if (key !== "custom") {
              paperSizeOptions[key] = dataOptions.paperSizeOptions[key];
            }
          }
          await _this.mapSelect2Data(
            "paperSizeIdOption",
            dataOptions.paperSizeOptions
          );
        }

        // หน่วยขนาด
        await _this.mapSelect2Data(
          "pageSizeUnitOption",
          dataOptions.paperSizeUnitOptions
        );
        // เข้าเล่ม
        await _this.mapSelect2Data(
          "bookBindingOption",
          dataOptions.bookBindingOptions
        );
        // กระดาษ
        await _this.mapSelect2Data("paperIdOption", dataOptions.paperOptions);
        // สีที่พิมพ์
        await _this.mapSelect2Data(
          "printColorOption",
          dataOptions.printColorOptions
        );
        // เคลือบ
        await _this.mapSelect2Data(
          "coatingIdOption",
          dataOptions.coatingOptions
        );
        // ไดคัทมุมมน
        await _this.mapSelect2Data(
          "dicutIdOption",
          dataOptions.dicutRoundedOptions
        );
        // ตัดเป็นตัว เจาะ
        await _this.mapSelect2Data(
          "perforateOption",
          dataOptions.perforateOptions
        );
        // วิธีพับ
        await _this.mapSelect2Data("foldIdOption", dataOptions.foldOptions);
        // หน่วยฟอยล์
        await _this.mapSelect2Data(
          "foilSizeUnitOption",
          dataOptions.foilUnitOptions
        );
        // สีฟอยล์
        await _this.mapSelect2Data(
          "foilColorIdOption",
          dataOptions.foilColorOptions
        );
        // หน่วยปั๊มนูน
        await _this.mapSelect2Data(
          "embossSizeUnitOption",
          dataOptions.embossUnitOptions
        );

        // มุมที่เจาะ
        await _this.mapSelect2Data(
          "perforateOptionOption",
          dataOptions.perforateOptionOptions
        );
        // ปํ๊มฟอยล์หรือไม่
        await _this.mapSelect2Data(
          "foilStatusOption",
          dataOptions.foilStatusOpts
        );
        // ปํ๊มนูนหรือไม่
        await _this.mapSelect2Data(
          "embossStatusOption",
          dataOptions.embossStatusOpts
        );
        // หน่วยติดหน้าต่าง
        await _this.mapSelect2Data(
          "windowBoxUnitOption",
          dataOptions.windowBoxUnitOption
        );
        // พิมพ์สองหน้า หน้าเดียว
        _this.printOptionOption = await _this.updateObject(
          _this.printOptionOption,
          {
            data: dataOptions.printOptions
          }
        );
        // รูปแบบไดคัท
        _this.dicutOption = await _this.updateObject(_this.dicutOption, {
          data: dataOptions.dicutOptions
        });
        // สถานะปั๊มฟอยล์
        _this.foilStatusOptions = await dataOptions.foilStatusOptions;
        // ปั๊มฟอยล์ ทั้งหน้าหลัง
        _this.foliPrintOptions = await dataOptions.foilPrintOptions;
        // สถานะปั๊มนูน
        _this.embossStatusOptions = await dataOptions.embossStatusOptions;
        // ปัีมนุน หน้าหลัง
        _this.embossPrintOptions = await dataOptions.embossPrintOptions;
        // ปะกาว
        _this.glueOptions = await dataOptions.glueOptions;
        // ร้อยเชือกหูถุง
        _this.ropeOptions = await dataOptions.ropeOptions;
        // แนวตั้ง แนวนอน
        _this.landOrientOptions = await dataOptions.landOrientOptions;
        // วิธีเคลือบ
        _this.coatingOptionOptions = await dataOptions.coatingOptionOptions;
        // สถานะไดคัท
        _this.dicutStatusOptions = await dataOptions.dicutStatusOptions;
        // สถานะเข้าเล่ม
        _this.bookBindingStatusOptions = await dataOptions.bookBindingStatusOptions;
        // ปรุฉีก
        _this.perforatedRippedOptions = await dataOptions.perforatedRippedOptions;
        // running number
        _this.runningNumberOptions = await dataOptions.runningNumberOptions;
        // ติดหน้าต่าง
        _this.windowBoxOptions = await dataOptions.windowBoxOptions;

        await _this.fetchDataBillFloorOptions();
      }
    },
    mapSelect2Data(optionKey, options = []) {
      const _this = this;
      _this[optionKey] = _this.updateObject(_this[optionKey], {
        data: _this.mapDataOptions(options)
      });
    },
    inputLabel: function(attr, defaultLabel = "") {
      if (!this.formOptions[attr]) return defaultLabel;
      return this.formOptions[attr].label;
    },
    replaceHtml: function(value) {
      return value.replace(/<p>(.*)<\/p>/g, "");
    },
    // รายละเอียดสินค้า
    getProductInfo(field) {
      const _this = this;
      const { attributes, skipAttributes } = _this;
      let info = "";
      if (skipAttributes.includes(field)) return;
      switch (field) {
        case "paper_size_id":
          info = _this.paperSizeDetail;
          break;
        case "page_qty":
          info = _this.pageQty;
          break;
        case "bill_detail_qty":
          info = _this.billQty;
          break;
        case "print_option":
          info = _this.printOptionDetail;
          break;
        case "print_color":
          info = _this.printColorDetail;
          break;
        case "paper_id":
          info = _this.paperDetail;
          break;
        case "coating_id":
          info = _this.coatingDetail;
          break;
        case "coating_option":
          info = _this.coatingOptionDetail;
          break;
        case "diecut_status":
          info = _this.dicutStatusDetail;
          break;
        case "diecut":
          info = _this.diecutDetail;
          break;
        case "diecut_id":
          info = _this.dicutCurveDetail;
          break;
        case "perforate":
          info = _this.perforateDetail;
          break;
        case "perforate_option_id":
          info = _this.perforateOptionDetail;
          break;
        case "fold_id":
          info = _this.foldDetail;
          break;
        case "foil_status":
          info = _this.foilDetail;
          break;
        case "foil_status":
          info = _this.foilDetail;
          break;
        case "foil_print":
          info = _this.foil_print;
          break;
        case "emboss_status":
          info = _this.embossDetail;
          break;
        case "emboss_print":
          info = _this.emboss_print;
          break;
        case "glue":
          info = _this.glueDetail;
          break;
        case "rope":
          info = _this.ropeDetail;
          break;
        case "land_orient":
          info = _this.landOrientDetail;
          break;
        case "book_binding_id":
          info = _this.bookBindingDetail;
          break;
        case "perforated_ripped":
          info = _this.perforatedRippedDetail;
          break;
        case "book_binding_qty":
          info = _this.book_binding_qty;
          break;
        case "running_number":
          info = _this.runningNumberDetail;
          break;
        case "window_box":
          info = _this.windowBoxDetail;
          break;
        case "book_binding_status":
          info = _this.bookBindingStatus;
          break;
        default:
          break;
      }
      return info;
    },
    initScroll() {
      const _this = this;
      var scrollHight = $(".mainstage").height(),
        panel_scroll = $(".panel_scroll"),
        cPostion = $(".product-panel").offset().top,
        panelHeight = panel_scroll.height(),
        limitScroll = scrollHight - panelHeight + cPostion;
      // $(".product-panel").height(scrollHight);
      $(window).scroll(function() {
        var wTop = $(window).scrollTop();
        if (_this.step === 1) {
          if (wTop >= cPostion && wTop <= limitScroll) {
            panel_scroll.css("top", wTop - cPostion + 100);
          }
          if (wTop < cPostion) {
            panel_scroll.css("top", 0);
          }
          if (wTop > limitScroll) {
            panel_scroll.css("top", scrollHight - panelHeight);
          }
        } else {
          panel_scroll.css("top", 0);
          panel_scroll.css("position", "relative");
          panel_scroll.css("padding", 0);
        }
      });
    },
    scrollTop() {
      $("html, body").animate(
        { scrollTop: $("#form-container").offset().top - 80 },
        "slow"
      );
    },
    // ขั้นตอนถัดไป
    async handleNextStep() {
      const _this = this;
      // คำนวณราคา
      _this.priceList = [];
      _this.cust_quantity = "";
      await _this.fetchDataPriceList();
      _this.step = 2;
      _this.scrollTop();
    },
    // ขั้นตอนก่อนหน้า
    handleBackStep() {
      const _this = this;
      _this.step = 1;
      _this.scrollTop();
    },
    // ดาวน์โหลดใบเสนอราคา
    handleDownload() {
      if (!this.isEmpty(this.attributes.cust_quantity)) {
        // ถ้าเลือกจำนวนที่ต้องการ
        this.$refs.form.reset();
        const modal = $("#myModal"); // แสดง modal
        modal.modal("show");
      } else {
        Swal.fire({
          type: "warning",
          title: "กรุณาเลือกจำนวนที่ต้องการ!",
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          showCancelButton: false,
          timer: 3000
        });
      }
    },
    // เพิ่มจำนวน
    handleAddQty() {
      const _this = this;
      // หาที่จำนวนที่เพิ่มเข้ามา ในรายการที่คำนวณไว้ก่อนหน้า
      const item = _this.priceList.find(
        item => parseInt(item.cust_quantity) === parseInt(_this.cust_quantity)
      );
      if (!_this.isEmpty(_this.cust_quantity) && _this.isEmpty(item)) {
        // ถ้าไม่มีจำนวนที่ตรงกัน
        _this.fetchDataPriceList(); // คำนวณราคา
        _this.attributes.cust_quantity = "";
      }
    },
    // คำนวณราคา
    async fetchDataPriceList() {
      const _this = this;
      const formData = new FormData();
      let loadingInstance = Loading.service({ fullscreen: true });
      try {
        _this.loadingQty = true;
        let qty = [];
        // เก็บจำนวนที่คำนวณไว้ [500, 1000, 2000]
        _this.priceList.map(item => {
          qty.push(item.cust_quantity);
        });
        // ถ้าไม่มีจำนวนเดิมอยู่แล้ว และจำนวนที่เพิ่มเข้ามาไม่มีอยู่ในจำนวนเดิม
        if (
          !qty.includes(_this.cust_quantity) &&
          !_this.isEmpty(_this.cust_quantity)
        ) {
          qty.push(_this.cust_quantity);
        }
        formData.append("qty", qty);
        // ข้อมูลสินค้าที่เลือก tbl_quotation_detail
        Object.keys(_this.attributes).forEach(key =>
          formData.append(
            key,
            _this.isEmpty(_this.attributes[key]) ? "" : _this.attributes[key]
          )
        );
        const { data } = await window.axios.post(
          `/app/api/calculate-price`,
          formData
        );
        // เก็บราคาที่คำนวณ
        _this.priceList = data.price_list;

        _this.loadingQty = false;
        loadingInstance.close();
      } catch (error) {
        _this.loadingQty = false;
        _this.$message.error(this.getErrorMessage(error));
        loadingInstance.close();
      }
    },
    // ลบจำนวน
    onRemovePriceList(qty) {
      if (qty === this.attributes.cust_quantity) {
        this.attributes.cust_quantity = "";
      }
      this.priceList = this.priceList.filter(
        item => item.cust_quantity !== qty
      );
    },
    initializeApp() {
      const _this = this;
      liff.init(
        data => {
          // Now you can call LIFF API
          _this.liffData = data;
        },
        err => {
          // LIFF initialization failed
          console.log(err);
          _this.$message.error("LIFF initialization failed");
        }
      );
    },
    sendMessages(messages) {
      const _this = this;
      if (_this.liffData && messages) {
        liff
          .sendMessages([messages])
          .then(function() {
            _this.$message.success("Message sent");
          })
          .catch(function(error) {
            _this.$message.error("Error sending message: " + error);
          });
      }
    },
    async onSubmitDownload() {
      const item = await this.priceList.find(
        item => item.cust_quantity === this.attributes.cust_quantity
      );
      const isValid = await this.$refs.form.validate();
      if (!item) return;

      this.attributes = this.updateObject(this.attributes, {
        final_price: item.final_price,
        paper_detail_id: item.paper.paper_detail.paper_detail_id
      });
      const formData = new FormData();
      Object.keys(this.attributeQuotation).forEach(key =>
        formData.append(key, this.attributeQuotation[key])
      );
      Object.keys(this.attributes).forEach(key =>
        formData.append(
          key,
          this.isEmpty(this.attributes[key]) ? "" : this.attributes[key]
        )
      );
      // formData.append("final_price", this.attributes.cust_quantity);
      if (isValid) {
        const loading = this.$loading({
          lock: true,
          text: "Loading",
          spinner: "el-icon-loading",
          background: "rgba(0, 0, 0, 0.7)"
        });
        try {
          const { data } = await window.axios.post(
            `/app/product/download?p=${this.productId}`,
            formData
          );
          if (data.success) {
            await this.sendMessages(data.flexMessage);
            setTimeout(function() {
              window.location.href = data.url;
              loading.close();
            }, 1000);
          } else {
            loading.close();
            Swal({
              type: "error",
              title: "Oops!",
              text: "เกิดข้อผิดพลาด!"
            });
          }
          this.$refs.form.reset();
        } catch (error) {
          this.$refs.form.reset();
          loading.close();
          this.$message.error(this.getErrorMessage(error));
        }
      }
    },
    getErrorMessage(error, defaultMsg = "Network Error") {
      let message = "";
      if (error.response && error.response.hasOwnProperty("data")) {
        const { data } = error.response;
        if (data.hasOwnProperty("data")) {
          const data = error.response.data.data;
          if (data.message) {
            message = data.message;
          } else if (data.errors) {
            message = data.errors;
          } else if (data.statusText) {
            message = data.statusText;
          }
        } else if (data.message) {
          message = data.message;
        } else if (data.errors) {
          message = data.errors;
        } else if (data.statusText) {
          message = data.statusText;
        }
      } else if (error.message) {
        message = error.message;
      }
      return message || defaultMsg;
    },
    handleScroll: function(evt, el) {
      if (window.scrollY > 50) {
        el.setAttribute(
          "style",
          "opacity: 1; transform: translate3d(0, -10px, 0)"
        );
      }
      return window.scrollY > 100;
    },
    encodeQueryData(data) {
      const ret = [];
      for (let d in data)
        ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(data[d]));
      return ret.join("&");
    }
  },
  watch: {
    productId: function(value, oldValue) {
      this.attributes.product_id = value;
    },
    attributes: {
      handler: function(val, oldVal) {
        this.$nextTick(function() {
          if (val.product_id) {
            // this.storeData()
            // this.saveStorage();
          }
        });
      },
      deep: true
    }
  },
  directives: {
    focus: {
      // directive definition
      inserted: function(el) {
        el.focus();
      }
    },
    scroll: {
      inserted: function(el, binding) {
        let f = function(evt) {
          if (binding.value(evt, el)) {
            window.removeEventListener("scroll", f);
          }
        };
        window.addEventListener("scroll", f);
      }
    }
  }
};
</script>

<style>
.el-radio__input .el-radio__inner {
  width: 18px;
  height: 18px;
}
.kt-widget1 .el-checkbox {
  display: flex;
  margin-right: 0;
}
.kt-widget1 .el-checkbox__label {
  width: 100%;
}
.kt-widget1 label.el-checkbox:hover {
  -webkit-transition: background-color 0.3s ease;
  transition: background-color 0.3s ease;
  text-decoration: none;
  background-color: #f7f8fa;
}
.kt-widget1 .el-radio,
.kt-widget1 .el-radio__inner,
.kt-widget1 .el-radio__input {
  position: relative;
  display: flex;
  margin-left: 5px;
}
.kt-widget1 .el-radio__label,
.kt-widget1 .el-radio,
.kt-widget1 .el-radio-group {
  width: 100%;
}
.kt-widget1 label.el-radio:hover,
.kt-widget1 label.el-radio.is-checked {
  -webkit-transition: background-color 0.3s ease;
  transition: background-color 0.3s ease;
  text-decoration: none;
  background-color: #f7f8fa;
}
.kt-widget1 .el-radio__input .el-radio__inner {
  top: 30%;
}
.kt-widget1 .el-button.is-circle {
  border-radius: 50%;
  padding: 8px;
  width: 30px;
  height: 30px;
}
.kt-widget1
  label.el-radio.is-checked
  .kt-widget1__item
  .kt-widget1__info
  .kt-widget1__title,
.kt-widget1
  label.el-radio.is-checked
  .kt-widget1__item
  .kt-widget1__info
  .kt-widget1__desc {
  color: #22b9ff;
  -webkit-transition: color 0.3s ease;
  transition: color 0.3s ease;
}
h1,
h2,
h3,
h4,
h5,
p,
body {
  font-family: "Prompt", sans-serif !important;
}
.ant-message {
  z-index: 1200;
}
.bb-fixed-header {
  position: absolute;
}
</style>

<style scoped>
@import url("../assets/css/kt-portlet.css");
@import url("../assets/css/kt-widget4.css");
@import url("../assets/css/kt-widget1.css");
@import url("../assets/css/product_grid.css");
@import url("../assets/css/quotation.css");
@import url("../assets/css/index.css");
.select2-container--bootstrap .select2-selection,
.form-control {
  background-color: #fafafa;
}
hr {
  margin-top: 20px;
  margin-bottom: 10px;
}
.panel-info {
  -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
  -moz-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
}
.info-label {
  color: #b3b3b3;
}
.panel_scroll {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  padding: 0px 15px;
  -webkit-transition: all 0.2s linear;
  -moz-transition: all 0.2s linear;
  -ms-transition: all 0.2s linear;
}
@media (max-width: 767px) {
  .panel_scroll {
    position: initial !important;
  }
}
@media (min-width: 768px) and (max-width: 991px) {
  .panel_scroll {
    position: initial !important;
  }
}
.kt-portlet .kt-portlet__head .kt-portlet__head-label .kt-portlet__head-title {
  font-size: 16px;
}
.widget-item {
  border-bottom: 1px dashed #ebedf2;
}
.kt-font-info {
  color: #2786fb !important;
}
.kt-widget4 .kt-widget4__item .kt-widget4__title,
.kt-widget4 .kt-widget4__item .kt-widget4__number {
  font-size: 1.5rem;
}
.kt-font-brand {
  color: #22b9ff !important;
}
.kt-widget1 .kt-widget1__item {
  padding: 5px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  border-bottom: 0.07rem dashed #ebedf2 !important;
}
.kt-widget1 {
  padding: 0;
}
.kt-ribbon--success2 .kt-ribbon__target {
  background-color: rgb(181, 213, 106);
  color: #ffffff;
}
.box {
  transition: 1.5s all cubic-bezier(0.39, 0.575, 0.565, 1);
}
</style>