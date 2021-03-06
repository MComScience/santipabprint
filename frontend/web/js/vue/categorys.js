"use strict"

const urlParams = new URLSearchParams(window.location.search)
const p = urlParams.get("p")
const yiiLib = window.yii

// plugins
Vue.use(VeeValidate, {
  classes: true,
  classNames: {
    valid: "is-valid",
    invalid: "is-invalid"
  },
  locale: "th",
  dictionary: {
    /* en: {
      attributes: {
        _default: field => `${field} ต้องไม่ว่างเปล่า.`
      }
    }, */
    th: {
      attributes: {
        _default: field => `${field} ต้องไม่ว่างเปล่า.`,
        coating_id: "เคลือบ",
        paper_size_id: "ขนาด"
      },
      messages: {
        required: field => `${field} ต้องไม่ว่างเปล่า.`
      }
    }
  }
})

// select2
Vue.component("v-select2", {
  props: ["options", "value"],
  template: `
    <select class="form-control">
      <slot></slot>
    </select>
  `,
  mounted: function() {
    var vm = this
    $(this.$el)
      // init select2
      .select2(this.options)
      .val(this.value)
      .trigger("change")
      // emit event on change.
      .on("change", function(e) {
        vm.$emit("input", this.value)
        vm.$emit("change", e)
      })
  },
  watch: {
    value: function(value) {
      // update value
      // $(this.$el)
      //   .val(value)
      //   .trigger("change");
    },
    options: function(options) {
      // update options
      $(this.$el)
        .empty()
        .select2(options)
    }
  },
  destroyed: function() {
    $(this.$el)
      .off()
      .select2("destroy")
  }
})

// col dom
Vue.component("v-col", {
  props: ["xs", "sm", "md", "lg"],
  computed: {
    colClass: function() {
      let classNames = []
      if (this.xs) {
        const prefix = this.prefix("xs")
        classNames.push(prefix + this.xs)
      }
      if (this.sm) {
        const prefix = this.prefix("sm")
        classNames.push(prefix + this.sm)
      }
      if (this.md) {
        const prefix = this.prefix("md")
        classNames.push(prefix + this.md)
      }
      if (this.lg) {
        const prefix = this.prefix("lg")
        classNames.push(prefix + this.lg)
      }
      return classNames.join(" ")
    }
  },
  methods: {
    prefix: function(col) {
      let prefix = ""
      switch (col) {
        case "xs":
          prefix = "col-xs-"
          break
        case "sm":
          prefix = "col-sm-"
          break
        case "md":
          prefix = "col-md-"
          break
        case "lg":
          prefix = "col-lg-"
          break
        default:
          break
      }
      return prefix
    }
  },
  template: `<div :class="colClass"><slot></slot></div>`
})

// row
Vue.component("v-row", {
  template: `<div class="row"><slot></slot></div>`
})

Vue.component("v-land-orient", {
  props: ["landOrientOptions", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-land_orient" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in landOrientOptions" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-land_orient-' + key" 
          name="TblQuotationDetail[land_orient]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-coating-option", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-coating_option" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-coating_option-' + key" 
          name="TblQuotationDetail[coating_option]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-dicut", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-diecut" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-diecut-' + key" 
          name="TblQuotationDetail[diecut]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-foli-print", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-foil_print" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-foil_print-' + key" 
          name="TblQuotationDetail[foil_print]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-emboss-print", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-emboss_print" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-emboss_print-' + key" 
          name="TblQuotationDetail[emboss_print]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-glue", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-glue" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-glue-' + key" 
          name="TblQuotationDetail[glue]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-foil-status", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-foil-status" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-foil-status-' + key" 
          name="TblQuotationDetail[foil-status]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-emboss-status", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-emboss-status" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-emboss-status-' + key" 
          name="TblQuotationDetail[emboss-status]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

const vmCategorys = Vue.component("vm-categorys", {
  props: {
    categorys: {
      type: Array,
      required: true,
      default: function() {
        return []
      }
    }
  },
  template: `
    <div class="row row-product">
      <div v-for="(category, key) in categorys" :key="key" class="col">
        <div 
          class="media open-collapse" 
          data-toggle="collapse__35" 
          role="button" 
          aria-expanded="true" 
          aria-controls="collapse__35">
            <a 
              class="product-link product-cate-sub" 
              @click="$emit('select-category', category.product_category_id)" 
              :data-block-id="'block_coll_' + category.product_category_id" 
              :data-point-id="'point-active-' + category.product_category_id">
                <span class="icon">&nbsp;</span>
                <div class="product-sub">
                  <img 
                  class="img-fluid img-responsive center-block lazy blur" 
                  :src="category.image_url"
                  :data-src="category.image_url"
                  :data-srcset="category.image_url"
                  alt="image">
                </div>
                <div class="media-body">
                  <p class="product-sub-name">
                    {{ category.product_category_name }}
                  </p>
                </div>
            </a>
        </div>
      </div>
    </div>
  `
})

Vue.component("v-rope", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-rope" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-rope-' + key" 
          name="TblQuotationDetail[rope]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-perforated-ripped", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-perforated-ripped" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-perforated-ripped-' + key" 
          name="TblQuotationDetail[perforated-ripped]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-running-number", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-running-number" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-running-number-' + key" 
          name="TblQuotationDetail[running-number]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.component("v-window-box", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value
    }
  },
  data() {
    return {
      checked: ""
    }
  },
  mounted: function() {
    this.checked = this.value
  },
  template: `
  <div id="tblquotationdetail-window-box" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-window-box-' + key" 
          name="TblQuotationDetail[window-box]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
})

Vue.config.productionTip = false

function format(state) {
  if (!state.id) return state.text // optgroup
  return state.text
}

function updateObject(oldObject, updatedProperties) {
  return {
    ...oldObject,
    ...updatedProperties
  }
}

new Vue({
  el: "#app",
  data: {
    loading: false,
    categorys: [],
    products: [],
    catId: "",
    productId: "",
    liffData: null,

    selected: 2,
    productData: null,
    loadingQty: false,
    priceSelected: null,
    step: 1,
    select2Options: {
      data: [{ id: 1, text: "Hello" }, { id: 2, text: "World" }],
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกหน่วย",
      language: "th"
    },
    // ขนาด
    paperSizeIdOpts: {
      data: [],
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกขนาด",
      language: "th"
    },
    // จำนวนแผ่นต่อชุด
    billQtyOpts: {
      data: [],
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกจำนวนแผ่นต่อชุด",
      language: "th"
    },
    // หน่วยขนาด
    pageSizeUnitOpts: {
      data: [],
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกหน่วย",
      language: "th"
    },
    // เข้าเล่ม
    BookBindingOpts: {
      data: [],
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกรายการ...",
      language: "th"
    },
    // กระดาษ
    paperIdOpts: {
      data: [],
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกกระดาษ",
      language: "th"
    },
    // พิมพ์สองหน้าหรือหน้าเดียว
    printOptionOpts: {
      data: [],
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกรายการ...",
      language: "th"
    },
    // สีที่พิมพ์
    printColorOpts: {
      data: [],
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกรายการ...",
      language: "th"
    },
    // เคลือบ
    coatingIdOpts: {
      data: [],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกวิธีเคลือบ",
      language: "th"
    },
    // ไดคัท
    dicutOpts: {
      data: [],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกรูปแบบไดคัท",
      language: "th",
      data: []
    },
    dicutIdOpts: {
      data: [],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกไดคัท",
      language: "th"
    },
    // ตัดเป็นตัว/เจาะ
    perforateOpts: {
      data: [],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือก",
      language: "th"
    },
    // พับ
    foldIdOpts: {
      data: [],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      language: "th"
    },
    // หน่วยฟอยล์
    foilSizeUnitOpts: {
      data: [],
      placeholder: "เลือกหน่วย ...",
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกหน่วย",
      language: "th"
    },
    // สีฟอย์ล
    foilColorIdOpts: {
      data: [],
      placeholder: "เลือกสีฟอยล์ ...",
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกสีฟอยล์",
      language: "th"
    },
    // หน่วยปั๊มนูน
    embossSizeUnitOpts: {
      data: [],
      placeholder: "เลือกหน่วย ...",
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกหน่วย",
      language: "th"
    },
    // เจาะ
    perforateOptionOpts: {
      data: [],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกมุมเจาะ",
      language: "th"
    },
    // สถานะปั๊มฟอยล์
    foilStatusOpts: {
      data: [],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      language: "th"
    },
    // สถานะปั๊มนูน
    embossStatusOpts: {
      data: [],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      templateResult: format,
      templateSelection: format,
      escapeMarkup: function(m) {
        return m
      },
      theme: "bootstrap",
      width: "100%",
      language: "th"
    },
    //เข้าเล่ม
    bookBindingOptions: {
      data: [{ id: "0", text: "ไม่เข้าเล่ม" }, { id: "1", text: "เข้าเล่ม" }],
      placeholder: "เลือกรายการ ...",
      allowClear: true,
      theme: "bootstrap",
      width: "100%",
      language: "th"
    },
    dataOptions: [],
    formOptions: null,
    formAttributes: {
      "_csrf-frontend": yiiLib ? yiiLib.getCsrfToken() : null,
      book_binding_id: "",
      coating_id: "",
      coating_option: "",
      diecut_status: "",
      diecut: "",
      diecut_id: "",
      emboss_print: "",
      emboss_size_height: "",
      emboss_size_unit: "",
      emboss_size_width: "",
      foil_color_id: "",
      foil_size_height: "",
      foil_size_unit: "",
      foil_size_width: "",
      fold_id: "",
      foil_print: "",
      glue: "",
      land_orient: "",
      page_qty: "",
      paper_id: "",
      paper_size_height: "",
      paper_size_id: "",
      paper_size_lenght: "",
      paper_size_unit: "",
      paper_size_width: "",
      perforate: "",
      perforate_option_id: "",
      print_one_page: "",
      print_two_page: "",
      print_option: "",
      print_color: "",
      quotation_id: "",
      cust_quantity: "",
      bill_detail_qty: "",
      product_id: p,
      foil_status: "",
      emboss_status: "",
      rope: "",
      perforated_ripped: "",
      running_number: "",
      book_binding_status: "",
      book_binding_qty: "",
      window_box: "",
      window_box_width: "",
      window_box_lenght: "",
      window_box_unit: ""
    },
    landOrientOptions: [],
    perforatedRippedOptions: [],
    coatingOptionOptions: [],
    dicutOptions: [],
    foliPrintOptions: [],
    embossPrintOptions: [],
    glueOptions: [],
    priceList: [],
    foilStatusOptions: [],
    embossStatusOptions: [],
    ropeOptions: [],
    runningNumberOptions: [],
    windowBoxOptions: [],
    radioChecked: ""
  },
  computed: {
    isSelectedCategory() {
      return !this.isEmpty(this.catId)
    },
    isSelectedProduct() {
      return !this.isEmpty(this.productId)
    },
    sectionTitle() {
      if (!this.isSelectedCategory && !this.isSelectedProduct) return "หมวดหมู่"
      if (this.isSelectedCategory && !this.isSelectedProduct) return "สินค้า"
      if (this.isSelectedProduct && this.product) {
        return this.product.product_name
      }
      return "หมวดหมู่"
    },
    product() {
      if (!this.isSelectedProduct || !this.products) return null
      return this.products.find(item => item.product_id === this.productId)
    },
    category() {
      if (!this.isSelectedCategory) return null
      return this.categorys.find(
        item => item.product_category_id === this.catId
      )
    },
    landOrientDetail: function() {
      if (this.isEmptyValue("land_orient")) return "-"
      const data = this.landOrientOptions.find(
        item => item.value.toString() === this.formAttributes.land_orient
      )
      return this.getTextValue(data)
    },
    paperSizeDetail: function() {
      if (this.isEmptyValue("paper_size_id")) return "-"
      const data = this.findDataOption(
        this.paperSizeIdOpts.data,
        "id",
        "paper_size_id"
      )
      if (data && this.getFormValue("paper_size_id") === "custom") {
        if (this.paper_size_height) {
          return `${this.paper_size_width}x${this.paper_size_lenght}x${this.paper_size_height} ${this.paper_size_unit}`
        }
        return `${this.paper_size_width}x${this.paper_size_lenght} ${this.paper_size_unit}`
      }
      return this.getTextValue(data)
    },
    bookBindingDetail: function() {
      if (this.isEmptyValue("book_binding_id")) return "-"
      const data = this.findDataOption(
        this.BookBindingOpts.data,
        "id",
        "book_binding_id"
      )
      return this.getTextValue(data)
    },
    paperDetail: function() {
      if (this.isEmptyValue("paper_id")) return "-"
      const paper = this.findPaper(this.paperIdOpts.data)
      return this.getTextValue(paper)
    },
    printColorDetail: function() {
      if (this.isEmptyValue("print_option") || this.isEmptyValue("print_color"))
        return "-"
      const option = this.findDataOption(
        this.printOptionOpts.data,
        "id",
        "print_option"
      )
      const color = this.findDataOption(
        this.printColorOpts.data,
        "id",
        "print_color"
      )
      return this.getTextValue(option) + " " + this.getTextValue(color)
    },
    perforateDetail: function() {
      if (this.isEmptyValue("perforate")) return "-"
      const option = this.findDataOption(
        this.perforateOpts.data,
        "id",
        "perforate"
      )
      let perforate_option = null
      this.perforateOptionOpts.data.map(item => {
        if (item.id === this.formAttributes.perforate_option_id) {
          perforate_option = item
        } else if (item.children) {
          item.children.map(children => {
            if (children.id === this.formAttributes.perforate_option_id) {
              perforate_option = children
            }
          })
        }
      })
      return (
        this.getTextValue(option) + " " + this.getTextValue(perforate_option)
      )
    },
    foldDetail: function() {
      if (this.isEmptyValue("fold_id")) return "-"
      const fold = this.findDataOption(this.foldIdOpts.data, "id", "fold_id")
      return this.getTextValue(fold)
    },
    foilDetail: function() {
      if (!this.showFoilInput) return "ไม่ปั๊มฟอยล์"
      let foil_size_width = this.getFormValue("foil_size_width")
      let foil_size_height = this.getFormValue("foil_size_height")
      const uint = this.findDataOption(
        this.foilSizeUnitOpts.data,
        "id",
        "foil_size_unit"
      )
      const color = this.findDataOption(
        this.foilColorIdOpts.data,
        "id",
        "foil_color_id"
      )
      const foil_print = this.findDataOption(
        this.foliPrintOptions,
        "value",
        "foil_print"
      )
      foil_size_width = this.isEmpty(foil_size_width)
        ? ""
        : foil_size_width + "x"
      foil_size_height = this.isEmpty(foil_size_height) ? "" : foil_size_height
      const unitTxt =
        this.getTextValue(uint) === "-" ? "" : this.getTextValue(uint)

      const colorTxt =
        this.getTextValue(color) === "-" ? "" : this.getTextValue(color)
      const foil_print_txt =
        this.getTextValue(foil_print) === "-"
          ? ""
          : this.getTextValue(foil_print)
      return `${foil_size_width}${foil_size_height} ${unitTxt} ${colorTxt} ${foil_print_txt}`
    },
    embossDetail: function() {
      if (!this.showEmbossInput) return "ไม่ปั๊มนูน"
      let emboss_size_width = this.getFormValue("emboss_size_width")
      let emboss_size_height = this.getFormValue("emboss_size_height")
      const uint = this.findDataOption(
        this.embossSizeUnitOpts.data,
        "id",
        "emboss_size_unit"
      )
      const emboss_print = this.findDataOption(
        this.embossPrintOptions,
        "value",
        "emboss_print"
      )
      emboss_size_width = this.isEmpty(emboss_size_width)
        ? ""
        : emboss_size_width + "x"
      emboss_size_height = this.isEmpty(emboss_size_height)
        ? ""
        : emboss_size_height
      const unitTxt =
        this.getTextValue(uint) === "-" ? "" : this.getTextValue(uint)
      return `${emboss_size_width}${emboss_size_height} ${unitTxt} ${this.getTextValue(
        emboss_print
      )}`
    },
    glueDetail: function() {
      const glue = this.findDataOption(this.glueOptions, "value", "glue")
      return this.getTextValue(glue)
    },
    perforatedRippedDetail: function() {
      if (this.isEmptyValue("perforated_ripped")) return "-"
      const perforated_ripped = this.findDataOption(
        this.perforatedRippedOptions,
        "value",
        "perforated_ripped"
      )
      return this.getTextValue(perforated_ripped)
    },
    runningNumberDetail: function() {
      if (this.isEmptyValue("running_number")) return "-"
      const running_number = this.findDataOption(
        this.runningNumberOptions,
        "value",
        "running_number"
      )
      return this.getTextValue(running_number)
    },
    windowBoxDetail: function() {
      if (!this.showWindowBoxInput) return "ไม่ติดหน้าต่างกล่อง"
      let window_box_width = this.getFormValue("window_box_width")
      let window_box_lenght = this.getFormValue("window_box_lenght")
      const uint = this.findDataOption(
        this.windowBoxUnitOpts.data,
        "id",
        "window_box_unit"
      )
      window_box_width = this.isEmpty(window_box_width)
        ? ""
        : window_box_width + "x"
      window_box_lenght = this.isEmpty(window_box_lenght)
        ? ""
        : window_box_lenght
      const unitTxt =
        this.getTextValue(uint) === "-" ? "" : this.getTextValue(uint)
      return `${window_box_width}${window_box_lenght} ${unitTxt}`
    },
    coatingDetail: function() {
      if (this.isEmptyValue("coating_id")) return "-"
      const coating = this.coatingIdOpts.data.find(
        item => item.id === this.formAttributes.coating_id
      )
      const coating_option = this.coatingOptionOptions.find(
        item => item.value === this.formAttributes.coating_option
      )
      const coatingTxt =
        this.getTextValue(coating_option) === "-"
          ? ""
          : this.getTextValue(coating_option)
      return this.getTextValue(coating) + " " + coatingTxt
    },
    dicutDetail: function() {
      if (!this.isDicut && this.formAttributes.diecut_status === "not-dicut")
        return "ไม่ไดคัท"
      const diecut = this.dicutOpts.data.find(
        item => item.id === this.formAttributes.diecut
      )
      const diecut_id = this.findDataOption(
        this.dicutIdOpts.data,
        "id",
        "diecut_id"
      )
      const dicutTxt =
        this.getTextValue(diecut_id) === "-" ? "" : this.getTextValue(diecut_id)
      return this.getTextValue(diecut) + " " + dicutTxt
    },
    billDetail: function() {
      const bill_detail_qty = this.findDataOption(
        this.billQtyOpts.data,
        "id",
        "bill_detail_qty"
      )

      return this.getTextValue(bill_detail_qty)
    },
    paper_size_width: function() {
      if (!this.formAttributes.paper_size_width) return ""
      return this.formAttributes.paper_size_width
    },
    paper_size_lenght: function() {
      if (!this.formAttributes.paper_size_lenght) return ""
      return this.formAttributes.paper_size_lenght
    },
    paper_size_height: function() {
      if (!this.formAttributes.paper_size_height) return ""
      return this.formAttributes.paper_size_height
    },
    paper_size_unit: function() {
      if (!this.formAttributes.paper_size_unit) return ""
      const data = this.pageSizeUnitOpts.data.find(item => {
        return item.id === this.formAttributes.paper_size_unit
      })
      return data ? data.text : "-"
    },
    book_binding_qty: function() {
      if (!this.formAttributes.book_binding_qty) return "-"
      return this.formAttributes.book_binding_qty
    },
    page_qty: function() {
      if (!this.formAttributes.page_qty) return "-"
      return this.formAttributes.page_qty
    },
    showFoilInput: function() {
      return this.formAttributes.foil_status === "Y"
    },
    showEmbossInput: function() {
      return this.formAttributes.emboss_status === "Y"
    },
    isDicut() {
      return this.formAttributes.diecut_status === "dicut"
    },
    isPerforate() {
      return this.formAttributes.diecut_status === "perforate"
    },
    radioOptions() {
      const options = []
      if (!this.dataOptions) return []
      if (this.isvisibleInput("diecut")) {
        this.dataOptions.dicutStatusOptions.map(option => {
          if (
            this.isvisibleInput("perforate") &&
            option.value === "perforate"
          ) {
            options.push(option)
          } else if (option.value !== "perforate") {
            options.push(option)
          }
        })
        // options.push({
        //   value: "not-dicut",
        //   text: "ไม่ไดคัท"
        // })
        // options.push({
        //   value: "dicut",
        //   text: "ไดคัท"
        // })
      }
      // if (this.isvisibleInput("perforate")) {
      //   options.push({
      //     value: "perforate",
      //     text: "ตัดเป็นตัว/เจาะ"
      //   })
      // }
      return options
    },
    ropeDetail: function() {
      if (!this.formAttributes.rope) return "-"
      return this.formAttributes.rope === "1"
        ? "ร้อยเชือกหูถุง"
        : "ไม่ร้อยเชือกหูถุง"
    },
    isBookBinding() {
      return this.formAttributes.book_binding_status === "1"
    },
    showWindowBoxInput: function() {
      return this.formAttributes.window_box === "1"
    }
  },
  created() {
    $(".loading, .product-detail").removeClass("hidden")
  },
  updated() {
    this.$nextTick(function() {
      this.formAttributes.product_id = this.productId
      // this.storeData()
    })
  },
  mounted() {
    this.fetchData()
    // this.initializeApp()
  },
  components: {
    vmCategorys
  },
  methods: {
    async fetchData() {
      var vm = this
      const params = yiiLib.getQueryParams(window.location.search)
      try {
        const { data } = await axios.get("/app/api/product-category-list")
        // handle success
        this.categorys = await data
        if (!vm.isEmpty(params) && !vm.isEmpty(params.catId)) {
          this.catId = parseInt(params.catId)
          await vm.fetchDataProductCategory(params.catId)
          await vm.onSelectProduct(params.productId)
        }
        $("#loading").hide()
        setTimeout(function() {
          vm.lazyImages()
        })
      } catch (error) {
        $("#loading").hide()
        // handle error
        Swal.fire({
          type: "error",
          title: "Oops...",
          text: error.response
            ? error.response.statusText || "เกิดข้อผิดพลาด"
            : "เกิดข้อผิดพลาด",
          showConfirmButton: false,
          timer: 4000
        })
      }
    },
    fetchDataProductCategory(id) {
      var vm = this
      vm.loading = true
      axios
        .get("/app/api/get-product-category?id=" + id)
        .then(response => {
          // handle success
          vm.products = response.data.items
          vm.loading = false
        })
        .catch(error => {
          vm.loading = false
          // handle error
          Swal.fire({
            type: "error",
            title: "Oops...",
            text: error.response
              ? error.response.statusText || "เกิดข้อผิดพลาด"
              : "เกิดข้อผิดพลาด",
            showConfirmButton: false,
            timer: 4000
          })
        })
    },
    async fetchDataOptions() {
      var vm = this
      vm.loading = true
      try {
        const { data } = await axios.get("/app/api/quotation?p=" + vm.productId)
        const { dataOptions, formOptions, formAttributes, product } = data
        vm.dataOptions = dataOptions
        // ขนาด
        if (
          formOptions.paper_size_width.value === "1" &&
          formOptions.paper_size_lenght.value === "1" &&
          formOptions.paper_size_unit.value === "1"
        ) {
          this.paperSizeIdOpts = await updateObject(this.paperSizeIdOpts, {
            data: this.mapDataOptions(dataOptions.paperSizeOptions)
          })
        } else {
          const paperSizeOptions = {}
          for (const key in dataOptions.paperSizeOptions) {
            if (key !== "custom") {
              paperSizeOptions[key] = dataOptions.paperSizeOptions[key]
            }
          }
          this.paperSizeIdOpts = await updateObject(this.paperSizeIdOpts, {
            data: this.mapDataOptions(paperSizeOptions)
          })
        }

        // หน่วยขนาด
        this.pageSizeUnitOpts = await updateObject(this.pageSizeUnitOpts, {
          data: this.mapDataOptions(dataOptions.paperSizeUnitOptions)
        })
        // เข้าเล่ม
        this.BookBindingOpts = await updateObject(this.BookBindingOpts, {
          data: this.mapDataOptions(dataOptions.bookBindingOptions)
        })
        // กระดาษ
        this.paperIdOpts = await updateObject(this.paperIdOpts, {
          data: this.mapDataOptions(dataOptions.paperOptions)
        })
        // สีที่พิมพ์
        this.printColorOpts = await updateObject(this.printColorOpts, {
          data: this.mapDataOptions(dataOptions.printColorOptions)
        })
        // เคลือบ
        this.coatingIdOpts = await updateObject(this.coatingIdOpts, {
          data: this.mapDataOptions(dataOptions.coatingOptions)
        })
        // ไดคัทมุมมน
        this.dicutIdOpts = await updateObject(this.dicutIdOpts, {
          data: this.mapDataOptions(dataOptions.dicutRoundedOptions)
        })
        // ตัดเป็นตัว เจาะ
        this.perforateOpts = await updateObject(this.perforateOpts, {
          data: this.mapDataOptions(dataOptions.perforateOptions)
        })
        // วิธีพับ
        this.foldIdOpts = await updateObject(this.foldIdOpts, {
          data: this.mapDataOptions(dataOptions.foldOptions)
        })
        // หน่วยฟอยล์
        this.foilSizeUnitOpts = await updateObject(this.foilSizeUnitOpts, {
          data: this.mapDataOptions(dataOptions.foilUnitOptions)
        })
        // สีฟอยล์
        this.foilColorIdOpts = await updateObject(this.foilColorIdOpts, {
          data: this.mapDataOptions(dataOptions.foilColorOptions)
        })
        // หน่วยปั๊มนูน
        this.embossSizeUnitOpts = await updateObject(this.embossSizeUnitOpts, {
          data: this.mapDataOptions(dataOptions.embossUnitOptions)
        })
        // มุมที่เจาะ
        this.perforateOptionOpts = await updateObject(
          this.perforateOptionOpts,
          {
            data: this.mapDataOptions(dataOptions.perforateOptionOptions)
          }
        )
        // ปํ๊มฟอยล์หรือไม่
        this.foilStatusOpts = await updateObject(this.foilStatusOpts, {
          data: this.mapDataOptions(dataOptions.foilStatusOpts)
        })
        // ปํ๊มนูนหรือไม่
        this.embossStatusOpts = await updateObject(this.embossStatusOpts, {
          data: this.mapDataOptions(dataOptions.embossStatusOpts)
        })
        // พิมพ์สองหน้า หน้าเดียว
        this.printOptionOpts = await updateObject(this.printOptionOpts, {
          data: dataOptions.printOptions
        })
        // รูปแบบไดคัท
        this.dicutOpts = await updateObject(this.dicutOpts, {
          data: dataOptions.dicutOptions
        })
        // สถานะปั๊มฟอยล์
        this.foilStatusOptions = await dataOptions.foilStatusOptions
        // ปั๊มฟอยล์ ทั้งหน้าหลัง
        this.foliPrintOptions = await dataOptions.foilPrintOptions
        // สถานะปั๊มนูน
        this.embossStatusOptions = await dataOptions.embossStatusOptions
        // ปัีมนุน หน้าหลัง
        this.embossPrintOptions = await dataOptions.embossPrintOptions
        // ปะกาว
        this.glueOptions = await dataOptions.glueOptions
        // ร้อยเชือกหูถุง
        this.ropeOptions = await dataOptions.ropeOptions
        // แนวตั้ง แนวนอน
        this.landOrientOptions = await dataOptions.landOrientOptions
        //
        this.coatingOptionOptions = await dataOptions.coatingOptionOptions

        const formData = await JSON.parse(localStorage.getItem("formData"))
        if (formData && formData[this.productId]) {
          const formAttrs = await formData[this.productId]
          for (const field in formAttributes) {
            if (formAttrs[field]) {
              formAttributes[field] = formAttrs[field]
            }
          }
          this.formAttributes = await updateObject(
            this.formAttributes,
            formAttributes
          )
          // if (localStorage.getItem(`radioChecked[${this.productId}]`)) {
          //   this.radioChecked = await localStorage.getItem(
          //     `radioChecked[${this.productId}]`
          //   )
          // }
        } else {
          this.formAttributes = await updateObject(
            this.formAttributes,
            response.data.formAttributes
          )
        }

        await this.fetchDataBillFloorOptions()

        this.productData = await product
        this.formOptions = await formOptions

        vm.loading = false
        setTimeout(function() {
          $("#loading, #loading2, .desc").hide()
        }, 300)
      } catch (error) {
        $("#loading, #loading2").hide()
        vm.loading = false
        // handle error
        Swal.fire({
          type: "error",
          title: "Oops...",
          text: error.response
            ? error.response.statusText || "เกิดข้อผิดพลาด"
            : "เกิดข้อผิดพลาด",
          showConfirmButton: false,
          timer: 4000
        })
      }
    },
    // จำนวนแผ่นต่อชุด
    fetchDataBillFloorOptions() {
      let formAttributes = this.formAttributes
      if (this.isvisibleInput("bill_detail_qty")) {
        axios
          .get(
            `/app/api/bill-floor-options?paper_size_id=${formAttributes.paper_size_id}&paper_id=${formAttributes.paper_id}`
          )
          .then(response => {
            // handle success
            this.billQtyOpts = updateObject(this.billQtyOpts, {
              data: this.mapDataOptions(response.data)
            })
            this.$nextTick(function() {
              this.formAttributes["bill_detail_qty"] = null
            })
            setTimeout(() => {
              $("#bill_detail_qty")
                .val(null)
                .trigger("change")
            }, 500)
          })
          .catch(error => {
            // handle error
            Swal.fire({
              type: "error",
              title: "Oops...",
              text: error.response
                ? error.response.statusText || "เกิดข้อผิดพลาด"
                : "เกิดข้อผิดพลาด",
              showConfirmButton: false,
              timer: 4000
            })
          })
      }
    },
    lazyImages: function() {
      var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"))

      if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function(
          entries,
          observer
        ) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              let lazyImage = entry.target
              lazyImage.src = lazyImage.dataset.src
              lazyImage.srcset = lazyImage.dataset.srcset
              lazyImage.classList.remove("lazy")
              setTimeout(function() {
                lazyImage.classList.remove("blur")
              }, 1000)
              lazyImageObserver.unobserve(lazyImage)
            }
          })
        })

        lazyImages.forEach(function(lazyImage) {
          lazyImageObserver.observe(lazyImage)
        })
      } else {
        // Possibly fall back to a more compatible method here
      }
    },
    onSelectCategory(catId) {
      this.catId = catId
      this.fetchDataProductCategory(catId)
    },
    onSelectProduct(productId) {
      this.productId = productId
      this.formOptions = null
      this.productData = null
      this.fetchDataOptions()
    },
    onSelectGroup() {
      this.catId = ""
      this.productId = ""
    },
    onSelectCat(catId) {
      this.catId = catId
      this.productId = ""
    },
    isEmpty: function(value, trim) {
      return (
        value === null ||
        value === undefined ||
        value.length === 0 ||
        (trim && $.trim(value) === "")
      )
    },
    mapDataOptions: function(options) {
      let dataOptions = []
      for (const key in options) {
        if (typeof options[key] === "object") {
          dataOptions.push({
            id: key,
            text: key,
            children: this.mapDataOptions(options[key])
          })
        } else {
          dataOptions.push({ id: key, text: options[key] })
        }
      }
      return dataOptions
    },
    isvisibleInput: function(attribute) {
      if (!this.formOptions) return false
      if (!this.formOptions[attribute]) return false
      return (
        this.formOptions[attribute] && this.formOptions[attribute].value === "1"
      )
    },
    onSubmit: function() {
      console.log("onSubmit")
    },
    inputLabel: function(attr, defaultLabel = "") {
      if (!this.formOptions[attr]) return defaultLabel
      return this.formOptions[attr].label
    },
    onChangeLandOrient: function(e) {
      console.log(e.target.value)
    },
    onChangePaperSizeId: function(e) {
      if (e.target.value !== "custom") {
        this.formAttributes.paper_size_width = ""
        this.formAttributes.paper_size_lenght = ""
        this.formAttributes.paper_size_height = ""
        this.formAttributes.paper_size_unit = ""
        $("#paper_size_unit")
          .val(null)
          .trigger("change")
        this.$validator.reset()
      }
      this.storeData()
      // จำนวนแผ่นต่อชุด
      if (this.isvisibleInput("bill_detail_qty")) {
        this.fetchDataBillFloorOptions()
      }
    },
    onChangePrintOption: function(e) {
      console.log(e.target.value)
    },
    onChangePrintColor: function(e) {
      console.log(e.target.value)
    },
    onChangeBookBinding: function(e) {
      console.log(e.target.value)
    },
    onChangeCoatingId: function(e) {
      if (e.target.value === "N" || this.isEmpty(e.target.value)) {
        this.formAttributes.coating_option = null
        $("#tblquotationdetail-coating_option-0").prop("checked", false)
        $("#tblquotationdetail-coating_option-1").prop("checked", false)
        this.$validator.reset()
      }
    },
    onChangeCoatingOption: function(e) {},
    onChangeDidut: function(e) {
      if (
        e.target.value === "N" ||
        e.target.value === "Default" ||
        this.isEmpty(e.target.value)
      ) {
        this.formAttributes.diecut_id = ""
        $("#diecut_id")
          .val("")
          .trigger("change")
        this.$validator.reset()
      }
      // if (this.formAttributes.product_id === 'P-2019073000001') { //ป้าย Tag สินค้า/ที่คั่นหนังสือ+
      //   if(!this.isEmpty(this.formAttributes.perforate)){
      //     Swal.fire({
      //       title: '',
      //       text: "กรุณาเลือกอย่างใดอย่างนึงเท่านั้น?",
      //       type: 'warning',
      //       showCancelButton: true,
      //       confirmButtonText: 'ไดคัท',
      //       cancelButtonText: 'ตัด/เจาะ',
      //       allowOutsideClick: false,
      //       cancelButtonColor: '#3085d6'
      //     }).then((result) => {
      //       if (result.value) {
      //         this.formAttributes.perforate = "";
      //         this.formAttributes.perforate_option_id = "";
      //         $("#perforate, #perforate_option_id")
      //           .val(null)
      //           .trigger("change");
      //       } else {
      //         vm.formAttributes.diecut = "";
      //         vm.formAttributes.diecut_id = "";
      //         $("#diecut_id")
      //           .val(null)
      //           .trigger("change");
      //         $('input[name="TblQuotationDetail[diecut]"]').prop("checked", false);
      //       }
      //     })
      //   }
      //   // $("#perforate, #perforate_option_id").prop("disabled", true);
      // }
    },
    onChangeDidutId: function(e) {
      console.log(e.target.value)
    },
    onChangePageSizeUnit: function(e) {
      console.log(e.target.value)
    },
    onChangePerforate: function(e) {
      const vm = this
      // if (e.target.value && this.formAttributes.product_id === 'P-2019073000001') { //ป้าย Tag สินค้า/ที่คั่นหนังสือ
      //   if(!this.isEmpty(vm.formAttributes.diecut)){
      //     Swal.fire({
      //       title: '',
      //       text: "กรุณาเลือกอย่างใดอย่างนึงเท่านั้น?",
      //       type: 'warning',
      //       showCancelButton: true,
      //       confirmButtonText: 'ตัด/เจาะ',
      //       cancelButtonText: 'ไดคัท',
      //       allowOutsideClick: false,
      //       cancelButtonColor: '#3085d6'
      //     }).then((result) => {
      //       if (result.value) {
      //         vm.formAttributes.diecut = "";
      //         vm.formAttributes.diecut_id = "";
      //         $("#diecut_id")
      //           .val(null)
      //           .trigger("change");
      //         $('input[name="TblQuotationDetail[diecut]"]').prop("checked", false);
      //       } else {
      //         vm.formAttributes.perforate = "";
      //         $("#perforate")
      //           .val(null)
      //           .trigger("change");
      //       }
      //     })
      //   }
      // }
      if (e.target.value !== "1") {
        this.formAttributes.perforate_option_id = ""
        $("#perforate_option_id")
          .val("")
          .trigger("change")
        this.$validator.reset()
      }
    },
    onChangePerforateOption: function(e) {
      console.log(e.target.value)
    },
    onChangeFoldId: function(e) {
      console.log(e.target.value)
    },
    onChangeFoilSizeUnit: function(e) {
      console.log(e.target.value)
    },
    onChangeFoilColorId: function(e) {
      console.log(e.target.value)
    },
    onChangeFoliPrint: function(e) {
      console.log(e.target.value)
    },
    onChangeEmbossSizeUnit: function(e) {
      console.log(e.target.value)
    },
    onChangeEmbossPrint: function(e) {
      console.log(e.target.value)
    },
    onChangeGlue: function(e) {
      console.log(e.target.value)
    },
    onChangePaperId: function(e) {
      console.log(e.target.value)
      // จำนวนแผ่นต่อชุด
      if (this.isvisibleInput("bill_detail_qty")) {
        this.fetchDataBillFloorOptions()
      }
    },
    onChangeBillQty: function(e) {
      console.log(e.target.value)
    },
    onChangeFoilStatus: function(e) {
      this.formAttributes.foil_status = e.target.value
      if (e.target.value === "Y") {
        // this.showFoilInput = true;
      } else {
        this.formAttributes.foil_color_id = null
        this.formAttributes.foil_size_height = ""
        this.formAttributes.foil_size_unit = null
        this.formAttributes.foil_size_width = ""
        this.formAttributes.foil_print = ""
        // this.showFoilInput = false;
      }
    },
    onChangeEmbossStatus: function(e) {
      this.formAttributes.emboss_status = e.target.value
      if (e.target.value === "Y") {
        // this.showEmbossInput = true;
      } else {
        this.formAttributes.emboss_size_height = ""
        this.formAttributes.emboss_size_unit = null
        this.formAttributes.emboss_size_width = ""
        this.formAttributes.emboss_print = ""
        // this.showEmbossInput = false;
      }
    },
    onChangeDiecutStatus: function(e) {
      const vm = this
      const value = e.target.value
      if (value === "not-dicut" || value === "perforate") {
        vm.formAttributes.diecut = "N"
        vm.formAttributes.diecut_id = ""
        setTimeout(function() {
          $("#diecut, #diecut_id, #perforate")
            .val(null)
            .trigger("change")
        }, 300)
        $('input[name="TblQuotationDetail[diecut]"]').prop("checked", false)
      } else if (value === "dicut") {
        vm.formAttributes.diecut = ""
        this.formAttributes.perforate = ""
        this.formAttributes.perforate_option_id = ""
        setTimeout(function() {
          $("#perforate, #perforate_option_id")
            .val(null)
            .trigger("change")
        }, 300)
      }
    },
    onChangeBookBindingStatus: function(e) {
      if (e.target.value === "0" || !e.target.value) {
        this.formAttributes.book_binding_id = ""
        this.formAttributes.book_binding_qty = ""
      }
    },
    onChangePerforatedRipped: function(e) {
      console.log(e.target.value)
    },
    onChangeRunningNumber: function(e) {
      console.log(e.target.value)
    },
    onChangewindowBox: function(e) {
      console.log(e.target.value)
    },
    findPaper: function(options) {
      let paper = null

      options.map(item => {
        if (item.id === this.formAttributes.paper_id) {
          paper = item
        } else if (item.children.length > 0) {
          return item.children.map(children => {
            if (children.id === this.formAttributes.paper_id) {
              paper = children
            }
          })
        }
      })
      return paper
    },
    isEmptyValue: function(attr) {
      const formAttributes = this.formAttributes
      return this.isEmpty(formAttributes[attr])
    },
    getFormValue: function(attr) {
      const formAttributes = this.formAttributes
      return !this.isEmpty(formAttributes[attr]) ? formAttributes[attr] : ""
    },
    getTextValue: function(data) {
      return this.isEmpty(data) || this.isEmpty(data.text)
        ? ""
        : this.replaceHtml(data.text)
    },
    replaceHtml: function(value) {
      return value.replace(/<p>(.*)<\/p>/g, "")
    },
    findDataOption: function(options, attr1, attr2) {
      return options.find(item => {
        return (
          !this.isEmpty(item[attr1]) && item[attr1] === this.getFormValue(attr2)
        )
      })
    },
    storeData: async function() {
      let formData = {}
      const cacheData = await JSON.parse(localStorage.getItem("formData"))
      if (cacheData && cacheData[this.productId]) {
        const formAttributes = await this.formAttributes
        const cacheAttributes = await cacheData[this.productId]
        for (let i in this.formAttributes) {
          if (
            this.isEmpty(formAttributes[i]) &&
            !this.isEmpty(cacheAttributes[i])
          ) {
            formAttributes[i] = cacheAttributes[i]
          }
        }
        formData[this.productId] = await formAttributes
      } else if (cacheData) {
        formData[this.productId] = await this.formAttributes
        formData = await updateObject(formData, cacheData)
      }
      // formData[this.productId] = this.formAttributes
      localStorage.setItem(
        "formData",
        JSON.stringify(Object.assign(cacheData, formData))
      )
    },
    reStoreData: function() {
      if (localStorage.getItem("formData")) {
        const formData = JSON.parse(localStorage.getItem("formData"))
        this.formAttributes = formData[this.productId]
      }
    },
    nextStepOne: function() {
      this.$validator.validateAll().then(valid => {
        if (valid) {
          // Swal.fire({
          //   type: "warning",
          //   title: "รอสักครู่...",
          //   allowOutsideClick: false,
          //   allowEscapeKey: false,
          //   showConfirmButton: false,
          //   showCancelButton: false,
          //   animation: false,
          //   onBeforeOpen: () => {
          //     Swal.showLoading();
          //   }
          // });
          this.onBackStep(2)
          this.calculatePrice()
        }
      })
    },
    onBackStep: function(step) {
      this.step = step
      this.priceSelected = null
      if (step === 1) {
        $("#preview-detail")
          .html("")
          .show()
        $("html, body").animate(
          { scrollTop: $("#form-quotation").offset().top },
          "slow"
        )
      }
    },
    calculatePrice(cust_quantity = null) {
      this.loadingQty = true
      const formData = new FormData()
      for (const key in this.formAttributes) {
        formData.append(
          key,
          this.isEmpty(this.formAttributes[key]) ? "" : this.formAttributes[key]
        )
      }
      if (cust_quantity) {
        let qty = []
        this.priceList.map(item => {
          if (parseInt(cust_quantity) !== parseInt(item.cust_quantity)) {
            qty.push(parseInt(item.cust_quantity))
          }
        })

        if (qty.length > 0) {
          qty.push(parseInt(cust_quantity))
          formData.append("qty", qty)
        } else {
          formData.append("qty", parseInt(cust_quantity))
        }
      }
      axios
        .post("/app/api/calculate-price", formData)
        .then(response => {
          this.priceList = response.data.price_list
          if (!cust_quantity) {
            this.step = 2
            $("#preview-detail")
              .html($(".product-panel").clone())
              .show()
            $("html, body").animate(
              { scrollTop: $(".preview-detail").offset().top + 150 },
              "slow"
            )
          }
          this.loadingQty = false
          Swal.close()
        })
        .catch(error => {
          this.loadingQty = false
          const message =
            error.response && error.response.data && error.response.data.message
              ? error.response.data.message
              : error.response.statusText || "เกิดข้อผิดพลาด"
          Swal.fire({
            type: "error",
            title: "Oops...",
            text: message,
            showConfirmButton: false,
            timer: 4000
          })
        })
    },
    onAddQty() {
      this.priceSelected = null
      const cust_quantity = this.formAttributes.cust_quantity
      if (!this.isEmpty(cust_quantity)) {
        this.calculatePrice(cust_quantity)
      }
    },
    onSelectedPriceItem(e, price) {
      $(".list-group")
        .find("li.active")
        .removeClass("active")
      $(e.target).toggleClass("active")
      this.priceSelected = price
    },
    onRemovePriceItem(item) {
      if (
        this.priceSelected &&
        this.priceSelected.cust_quantity === item.cust_quantity
      ) {
        this.priceSelected = null
      }
      this.priceSelected = null

      this.priceList = this.priceList.filter(
        p => p.cust_quantity !== item.cust_quantity
      )
    },
    onDownloadQO() {
      if (this.priceSelected && this.priceList.length) {
        Swal.fire({
          type: "warning",
          title: "รอสักครู่...",
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          showCancelButton: false,
          animation: false,
          onBeforeOpen: () => {
            Swal.showLoading()
          }
        })
        $.ajax({
          method: "GET",
          url: "/app/product/download",
          data: {
            p: this.formAttributes.product_id
          },
          dataType: "json",
          success: function(response) {
            const modal = $("#ajaxCrudModal")
            modal.find(".modal-header").html(response.title)
            modal.find(".modal-body").html(response.content)
            modal.modal("show")
            Swal.close()
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              type: "error",
              title: "Oops...",
              text: errorThrown,
              showConfirmButton: false,
              timer: 4000
            })
          }
        })
      } else {
        Swal.fire({
          type: "warning",
          title: "กรุณาเลือกจำนวนที่ต้องการ!",
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          showCancelButton: false,
          timer: 3000
        })
      }
    },
    initializeApp() {
      const _this = this
      liff.init(
        data => {
          // Now you can call LIFF API
          _this.liffData = data
        },
        err => {
          // LIFF initialization failed
          console.log(err)
        }
      )
    }
  },
  watch: {
    formAttributes: {
      handler: function(val, oldVal) {
        this.$nextTick(function() {
          if (val.product_id) {
            this.storeData()
          }
        })
      },
      deep: true
    },
    step: function(value) {
      if (value === 1) {
        $("#preview-detail")
          .html("")
          .show()
        $("html, body").animate(
          { scrollTop: $("#form-quotation").offset().top },
          "slow"
        )
      }
    },
    priceSelected: function(price) {
      if (price) {
        this.formAttributes.cust_quantity = price.cust_quantity
        this.formAttributes.final_price = price.final_price
        this.formAttributes.paper_detail_id =
          price.paper.paper_detail.paper_detail_id
      } else {
        this.formAttributes.cust_quantity = ""
        this.formAttributes.final_price = ""
        this.formAttributes.paper_detail_id = ""
      }
    },
    radioChecked(value) {
      const vm = this
      if (value === "not-dicut" || value === "perforate") {
        vm.formAttributes.diecut = "N"
        vm.formAttributes.diecut_id = ""
        // $("#diecut_id")
        //     .val('')
        //     .trigger("change");
        $('input[name="TblQuotationDetail[diecut]"]').prop("checked", false)
      } else if (value === "dicut") {
        vm.formAttributes.diecut = ""
        this.formAttributes.perforate = ""
        this.formAttributes.perforate_option_id = ""
        // $("#perforate, #perforate_option_id")
        //     .val('')
        //     .trigger("change");
      }
      localStorage.setItem(`radioChecked[${p}]`, value)
    }
  }
})
