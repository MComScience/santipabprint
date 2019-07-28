"use strict";

const urlParams = new URLSearchParams(window.location.search);
const p = urlParams.get("p");
const yiiLib = window.yii;

console.log(p);

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
});

// select2
Vue.component("v-select2", {
  props: ["options", "value"],
  template: `
    <select class="form-control">
      <slot></slot>
    </select>
  `,
  mounted: function() {
    var vm = this;
    $(this.$el)
      // init select2
      .select2(this.options)
      .val(this.value)
      .trigger("change")
      // emit event on change.
      .on("change", function(e) {
        vm.$emit("input", this.value);
        vm.$emit("change", e);
      });
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
        .select2(options);
    }
  },
  destroyed: function() {
    $(this.$el)
      .off()
      .select2("destroy");
  }
});

// col dom
Vue.component("v-col", {
  props: ["xs", "sm", "md", "lg"],
  computed: {
    colClass: function() {
      let classNames = [];
      if (this.xs) {
        const prefix = this.prefix("xs");
        classNames.push(prefix + this.xs);
      }
      if (this.sm) {
        const prefix = this.prefix("sm");
        classNames.push(prefix + this.sm);
      }
      if (this.md) {
        const prefix = this.prefix("md");
        classNames.push(prefix + this.md);
      }
      if (this.lg) {
        const prefix = this.prefix("lg");
        classNames.push(prefix + this.lg);
      }
      return classNames.join(" ");
    }
  },
  methods: {
    prefix: function(col) {
      let prefix = "";
      switch (col) {
        case "xs":
          prefix = "col-xs-";
          break;
        case "sm":
          prefix = "col-sm-";
          break;
        case "md":
          prefix = "col-md-";
          break;
        case "lg":
          prefix = "col-lg-";
          break;
        default:
          break;
      }
      return prefix;
    }
  },
  template: `<div :class="colClass"><slot></slot></div>`
});

// row
Vue.component("v-row", {
  template: `<div class="row"><slot></slot></div>`
});

Vue.component("v-land-orient", {
  props: ["landOrientOptions", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value;
    }
  },
  data() {
    return {
      checked: ""
    };
  },
  mounted: function() {
    this.checked = this.value;
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
});

Vue.component("v-coating-option", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value;
    }
  },
  data() {
    return {
      checked: ""
    };
  },
  mounted: function() {
    this.checked = this.value;
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
});

Vue.component("v-dicut", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value;
    }
  },
  data() {
    return {
      checked: ""
    };
  },
  mounted: function() {
    this.checked = this.value;
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
});

Vue.component("v-foli-print", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value;
    }
  },
  data() {
    return {
      checked: ""
    };
  },
  mounted: function() {
    this.checked = this.value;
  },
  template: `
  <div id="tblquotationdetail-foli_print" role="radiogroup" aria-invalid="false">
    <div v-for="(option, key) in options" :key="key" class="radio inline-block">
      <label class="radio-inline">
        <input type="radio" 
          :id="'tblquotationdetail-foli_print-' + key" 
          name="TblQuotationDetail[foli_print]" 
          :value="option.value"
          v-model="checked"
          v-on:input="$emit('input', $event.target.value)"
          v-on:change="$emit('change', $event)">
        <span class="cr"><i class="cr-icon fa fa-circle"></i></span> {{ option.text }}
      </label>
    </div>
  </div>
  `
});

Vue.component("v-emboss-print", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value;
    }
  },
  data() {
    return {
      checked: ""
    };
  },
  mounted: function() {
    this.checked = this.value;
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
});

Vue.component("v-glue", {
  props: ["options", "value"],
  $_veeValidate: {
    value() {
      return this.$el.value;
    }
  },
  data() {
    return {
      checked: ""
    };
  },
  mounted: function() {
    this.checked = this.value;
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
});

function format(state) {
  if (!state.id) return state.text; // optgroup
  return state.text;
}

function updateObject(oldObject, updatedProperties) {
  return {
    ...oldObject,
    ...updatedProperties
  };
}

const vm = new Vue({
  el: "#app",
  data: {
    selected: 2,
    product: null,
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
        return m;
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกขนาด",
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
        return m;
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
      data: [
        { id: "one_page", text: "พิมพ์สองหน้า" },
        { id: "two_page", text: "พิมพ์หน้าเดียว" }
      ],
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
        return m;
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
        return m;
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกวิธีเคลือบ",
      language: "th"
    },
    // ไดคัท
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
        return m;
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
        return m;
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
        return m;
      },
      theme: "bootstrap",
      width: "100%",
      placeholder: "เลือกมุมเจาะ",
      language: "th"
    },
    formOptions: null,
    formAttributes: {
      "_csrf-frontend": yiiLib ? yiiLib.getCsrfToken() : null,
      book_binding_id: "",
      coating_id: "",
      coating_option: "",
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
      foli_print: "",
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
      product_id: p
    },
    landOrientOptions: [
      {
        value: "1",
        text: "แนวตั้ง"
      },
      {
        value: "2",
        text: "แนวนอน"
      }
    ],
    coatingOptionOptions: [
      {
        value: "one_page",
        text: "ด้านเดียว"
      },
      {
        value: "two_page",
        text: "สองด้าน"
      }
    ],
    dicutOptions: [
      {
        value: "N",
        text: "ไม่ไดคัท"
      },
      {
        value: "Default",
        text: "ไดคัทตามรูปแบบ"
      },
      {
        value: "Curve",
        text: "ไดคัทมุมมน"
      }
    ],
    foliPrintOptions: [
      {
        value: "two_page",
        text: "ทั้งหน้า/หลัง"
      },
      {
        value: "one_page",
        text: "หน้าเดียว"
      }
    ],
    embossPrintOptions: [
      {
        value: "two_page",
        text: "ทั้งหน้า/หลัง"
      },
      {
        value: "one_page",
        text: "หน้าเดียว"
      }
    ],
    glueOptions: [
      {
        value: "0",
        text: "No"
      },
      {
        value: "1",
        text: "Yes"
      }
    ],
    priceList: []
  },
  created() {
    $(".loading, .product-detail").removeClass("hidden");
  },
  updated: function() {
    this.$nextTick(function() {
      this.formAttributes.product_id = p;
      this.storeData();
    });
  },
  computed: {
    landOrientDetail: function() {
      if (this.isEmptyValue("land_orient")) return "-";
      const data = this.findDataOption(
        this.landOrientOptions,
        "value",
        "land_orient"
      );
      return this.getTextValue(data);
    },
    paperSizeDetail: function() {
      if (this.isEmptyValue("paper_size_id")) return "-";
      const data = this.findDataOption(
        this.paperSizeIdOpts.data,
        "id",
        "paper_size_id"
      );
      if (data && this.getFormValue("paper_size_id") === "custom") {
        if (this.paper_size_height) {
          return `${this.paper_size_width}x${this.paper_size_lenght}x${
            this.paper_size_height
          } ${this.paper_size_unit}`;
        }
        return `${this.paper_size_width}x${this.paper_size_lenght} ${
          this.paper_size_unit
        }`;
      }
      return this.getTextValue(data);
    },
    bookBindingDetail: function() {
      if (this.isEmptyValue("book_binding_id")) return "-";
      const data = this.findDataOption(
        this.BookBindingOpts.data,
        "id",
        "book_binding_id"
      );
      return this.getTextValue(data);
    },
    paperDetail: function() {
      if (this.isEmptyValue("paper_id")) return "-";
      const paper = this.findPaper(this.paperIdOpts.data);
      return this.getTextValue(paper);
    },
    printColorDetail: function() {
      if (this.isEmptyValue("print_option") || this.isEmptyValue("print_color"))
        return "-";
      const option = this.findDataOption(
        this.printOptionOpts.data,
        "id",
        "print_option"
      );
      const color = this.findDataOption(
        this.printColorOpts.data,
        "id",
        "print_color"
      );
      return this.getTextValue(option) + " " + this.getTextValue(color);
    },
    perforateDetail: function() {
      if (this.isEmptyValue("perforate")) return "-";
      const option = this.findDataOption(
        this.perforateOpts.data,
        "id",
        "perforate"
      );
      let perforate_option = null;
      this.perforateOptionOpts.data.map(item => {
        if (item.id === this.formAttributes.perforate_option_id) {
          perforate_option = item;
        } else if (item.children) {
          item.children.map(children => {
            if (children.id === this.formAttributes.perforate_option_id) {
              perforate_option = children;
            }
          });
        }
      });
      return (
        this.getTextValue(option) + " " + this.getTextValue(perforate_option)
      );
    },
    foldDetail: function() {
      if (this.isEmptyValue("fold_id")) return "-";
      const fold = this.findDataOption(this.foldIdOpts.data, "id", "fold_id");
      return this.getTextValue(fold);
    },
    foilDetail: function() {
      let foil_size_width = this.getFormValue("foil_size_width");
      let foil_size_height = this.getFormValue("foil_size_height");
      const uint = this.findDataOption(
        this.foilSizeUnitOpts.data,
        "id",
        "foil_size_unit"
      );
      const color = this.findDataOption(
        this.foilColorIdOpts.data,
        "id",
        "foil_color_id"
      );
      const foli_print = this.findDataOption(
        this.foliPrintOptions,
        "value",
        "foli_print"
      );
      foil_size_width = this.isEmpty(foil_size_width)
        ? ""
        : foil_size_width + "x";
      foil_size_height = this.isEmpty(foil_size_height) ? "" : foil_size_height;
      const unitTxt =
        this.getTextValue(uint) === "-" ? "" : this.getTextValue(uint);

      const colorTxt =
        this.getTextValue(color) === "-" ? "" : this.getTextValue(color);
      const foli_print_txt =
        this.getTextValue(foli_print) === "-"
          ? ""
          : this.getTextValue(foli_print);
      return `${foil_size_width}${foil_size_height} ${unitTxt} ${colorTxt} ${foli_print_txt}`;
    },
    embossDetail: function() {
      let emboss_size_width = this.getFormValue("emboss_size_width");
      let emboss_size_height = this.getFormValue("emboss_size_height");
      const uint = this.findDataOption(
        this.embossSizeUnitOpts.data,
        "id",
        "emboss_size_unit"
      );
      const emboss_print = this.findDataOption(
        this.embossPrintOptions,
        "value",
        "emboss_print"
      );
      emboss_size_width = this.isEmpty(emboss_size_width)
        ? ""
        : emboss_size_width + "x";
      emboss_size_height = this.isEmpty(emboss_size_height)
        ? ""
        : emboss_size_height;
      const unitTxt =
        this.getTextValue(uint) === "-" ? "" : this.getTextValue(uint);
      return `${emboss_size_width}${emboss_size_height} ${unitTxt} ${this.getTextValue(
        emboss_print
      )}`;
    },
    glueDetail: function() {
      const glue = this.findDataOption(this.glueOptions, "value", "glue");
      return this.getTextValue(glue);
    },
    coatingDetail: function() {
      if (this.isEmptyValue("coating_id")) return "-";
      const coating = this.findDataOption(
        this.coatingIdOpts.data,
        "id",
        "coating_id"
      );
      const coating_option = this.findDataOption(
        this.coatingOptionOptions,
        "value",
        "coating_option"
      );
      const coatingTxt =
        this.getTextValue(coating_option) === "-"
          ? ""
          : this.getTextValue(coating_option);
      return this.getTextValue(coating) + " " + coatingTxt;
    },
    dicutDetail: function() {
      const diecut = this.findDataOption(this.dicutOptions, "value", "diecut");
      const diecut_id = this.findDataOption(
        this.dicutIdOpts.data,
        "id",
        "diecut_id"
      );
      const dicutTxt =
        this.getTextValue(diecut_id) === "-"
          ? ""
          : this.getTextValue(diecut_id);
      return this.getTextValue(diecut) + " " + dicutTxt;
    },
    paper_size_width: function() {
      if (!this.formAttributes.paper_size_width) return "";
      return this.formAttributes.paper_size_width;
    },
    paper_size_lenght: function() {
      if (!this.formAttributes.paper_size_lenght) return "";
      return this.formAttributes.paper_size_lenght;
    },
    paper_size_height: function() {
      if (!this.formAttributes.paper_size_height) return "";
      return this.formAttributes.paper_size_height;
    },
    paper_size_unit: function() {
      if (!this.formAttributes.paper_size_unit) return "";
      const data = this.pageSizeUnitOpts.data.find(item => {
        return item.id === this.formAttributes.paper_size_unit;
      });
      return data ? data.text : "-";
    },
    page_qty: function() {
      if (!this.formAttributes.page_qty) return "-";
      return this.formAttributes.page_qty;
    }
  },
  mounted() {
    this.fetchDataOptions();
  },
  methods: {
    fetchDataOptions: function() {
      axios
        .get("/app/api/quotation?p=" + p)
        .then(response => {
          // handle success
          const { dataOptions, formOptions, formAttributes } = response.data;

          // ขนาด
          if (
            formOptions.paper_size_width.value === "1" &&
            formOptions.paper_size_lenght.value === "1" &&
            formOptions.paper_size_unit.value === "1"
          ) {
            this.paperSizeIdOpts = updateObject(this.paperSizeIdOpts, {
              data: this.mapDataOptions(dataOptions.paperSizeOptions)
            });
          } else {
            const paperSizeOptions = {};
            for (const key in dataOptions.paperSizeOptions) {
              if (key !== "custom") {
                paperSizeOptions[key] = dataOptions.paperSizeOptions[key];
              }
            }
            this.paperSizeIdOpts = updateObject(this.paperSizeIdOpts, {
              data: this.mapDataOptions(paperSizeOptions)
            });
          }

          // หน่วยขนาด
          this.pageSizeUnitOpts = updateObject(this.pageSizeUnitOpts, {
            data: this.mapDataOptions(dataOptions.paperSizeUnitOptions)
          });
          // เข้าเล่ม
          this.BookBindingOpts = updateObject(this.BookBindingOpts, {
            data: this.mapDataOptions(dataOptions.bookBindingOptions)
          });
          // กระดาษ
          this.paperIdOpts = updateObject(this.paperIdOpts, {
            data: this.mapDataOptions(dataOptions.paperOptions)
          });
          // สีที่พิมพ์
          this.printColorOpts = updateObject(this.printColorOpts, {
            data: this.mapDataOptions(dataOptions.printColorOptions)
          });
          // เคลือบ
          this.coatingIdOpts = updateObject(this.coatingIdOpts, {
            data: this.mapDataOptions(dataOptions.coatingOptions)
          });
          // ไดคัท
          this.dicutIdOpts = updateObject(this.dicutIdOpts, {
            data: this.mapDataOptions(dataOptions.dicutOptions)
          });
          // ตัดเป็นตัว เจาะ
          this.perforateOpts = updateObject(this.perforateOpts, {
            data: this.mapDataOptions(dataOptions.perforateOptions)
          });
          // วิธีพับ
          this.foldIdOpts = updateObject(this.foldIdOpts, {
            data: this.mapDataOptions(dataOptions.foldOptions)
          });
          // หน่วยฟอยล์
          this.foilSizeUnitOpts = updateObject(this.foilSizeUnitOpts, {
            data: this.mapDataOptions(dataOptions.foilUnitOptions)
          });
          // สีฟอยล์
          this.foilColorIdOpts = updateObject(this.foilColorIdOpts, {
            data: this.mapDataOptions(dataOptions.foilColorOptions)
          });
          // หน่วยปั๊มนูน
          this.embossSizeUnitOpts = updateObject(this.embossSizeUnitOpts, {
            data: this.mapDataOptions(dataOptions.embossUnitOptions)
          });
          // มุมที่เจาะ
          this.perforateOptionOpts = updateObject(this.perforateOptionOpts, {
            data: this.mapDataOptions(dataOptions.perforateOptionOptions)
          });

          this.product = response.data.product;
          this.formOptions = response.data.formOptions;

          const formData = JSON.parse(localStorage.getItem("formData"));
          if (formData && formData[p]) {
            const formAttrs = formData[p];
            for (const field in formAttributes) {
              if (formAttrs[field]) {
                formAttributes[field] = formAttrs[field];
              }
            }
            this.formAttributes = Object.assign(
              this.formAttributes,
              formAttributes
            );
          } else {
            this.formAttributes = Object.assign(
              this.formAttributes,
              response.data.formAttributes
            );
          }

          $("#loading, #loading2").hide();
        })
        .catch(error => {
          $("#loading, #loading2").hide();
          // handle error
          Swal.fire({
            type: "error",
            title: "Oops...",
            text: error.response
              ? error.response.statusText || "เกิดข้อผิดพลาด"
              : "เกิดข้อผิดพลาด",
            showConfirmButton: false,
            timer: 4000
          });
        });
    },
    onSubmit: function() {
      console.log("onSubmit");
    },
    isvisibleInput: function(attribute) {
      if (!this.formOptions[attribute]) return false;
      return (
        this.formOptions[attribute] && this.formOptions[attribute].value === "1"
      );
    },
    inputLabel: function(attr, defaultLabel = "") {
      if (!this.formOptions[attr]) return defaultLabel;
      return this.formOptions[attr].label;
    },
    onChangeLandOrient: function(e) {
      console.log(e.target.value);
    },
    onChangePaperSizeId: function(e) {
      if (e.target.value !== "custom") {
        this.formAttributes.paper_size_width = "";
        this.formAttributes.paper_size_lenght = "";
        this.formAttributes.paper_size_height = "";
        this.formAttributes.paper_size_unit = "";
        $("#paper_size_unit")
          .val(null)
          .trigger("change");
        this.$validator.reset();
      }
      this.storeData();
    },
    onChangePrintOption: function(e) {
      console.log(e.target.value);
    },
    onChangePrintColor: function(e) {
      console.log(e.target.value);
    },
    onChangeBookBinding: function(e) {
      console.log(e.target.value);
    },
    onChangeCoatingId: function(e) {
      if (e.target.value === "N" || this.isEmpty(e.target.value)) {
        this.formAttributes.coating_option = null;
        $("#tblquotationdetail-coating_option-0").attr("checked", false);
        $("#tblquotationdetail-coating_option-1").attr("checked", false);
        this.$validator.reset();
      }
    },
    onChangeCoatingOption: function(e) {},
    onChangeDidut: function(e) {
      if (
        e.target.value === "N" ||
        e.target.value === "Default" ||
        this.isEmpty(e.target.value)
      ) {
        this.formAttributes.diecut_id = "";
        $("#diecut_id")
          .val(null)
          .trigger("change");
        this.$validator.reset();
      }
    },
    onChangeDidutId: function(e) {
      console.log(e.target.value);
    },
    onChangePageSizeUnit: function(e) {
      console.log(e.target.value);
    },
    onChangePerforate: function(e) {
      if (e.target.value !== "1") {
        this.formAttributes.perforate_option_id = "";
        $("#perforate_option_id")
          .val(null)
          .trigger("change");
        this.$validator.reset();
      }
    },
    onChangePerforateOption: function(e) {
      console.log(e.target.value);
    },
    onChangeFoldId: function(e) {
      console.log(e.target.value);
    },
    onChangeFoilSizeUnit: function(e) {
      console.log(e.target.value);
    },
    onChangeFoilColorId: function(e) {
      console.log(e.target.value);
    },
    onChangeFoliPrint: function(e) {
      console.log(e.target.value);
    },
    onChangeEmbossSizeUnit: function(e) {
      console.log(e.target.value);
    },
    onChangeEmbossPrint: function(e) {
      console.log(e.target.value);
    },
    onChangeGlue: function(e) {
      console.log(e.target.value);
    },
    onChangePaperId: function(e) {
      console.log(e.target.value);
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
    findPaper: function(options) {
      let paper = null;

      options.map(item => {
        if (item.id === this.formAttributes.paper_id) {
          paper = item;
        } else if (item.children.length > 0) {
          return item.children.map(children => {
            if (children.id === this.formAttributes.paper_id) {
              paper = children;
            }
          });
        }
      });
      return paper;
    },
    isEmptyValue: function(attr) {
      const formAttributes = this.formAttributes;
      return this.isEmpty(formAttributes[attr]);
    },
    getFormValue: function(attr) {
      const formAttributes = this.formAttributes;
      return !this.isEmpty(formAttributes[attr]) ? formAttributes[attr] : "";
    },
    getTextValue: function(data) {
      return this.isEmpty(data) || this.isEmpty(data.text)
        ? ""
        : this.replaceHtml(data.text);
    },
    replaceHtml: function(value) {
      return value.replace(/<p>(.*)<\/p>/g, "");
    },
    isEmpty: function(value, trim) {
      return (
        value === null ||
        value === undefined ||
        value.length === 0 ||
        (trim && $.trim(value) === "")
      );
    },
    findDataOption: function(options, attr1, attr2) {
      return options.find(item => {
        return (
          !this.isEmpty(item[attr1]) && item[attr1] === this.getFormValue(attr2)
        );
      });
    },
    storeData: function() {
      const formData = {};
      formData[p] = this.formAttributes;
      localStorage.setItem("formData", JSON.stringify(formData));
    },
    reStoreData: function() {
      if (localStorage.getItem("formData")) {
        const formData = JSON.parse(localStorage.getItem("formData"));
        const formAttrs = formData[p];
        this.formAttributes = formAttrs;
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
          this.calculatePrice();
        }
      });
    },
    calculatePrice(cust_quantity = null) {
      this.loadingQty = true;
      const formData = new FormData();
      for (const key in this.formAttributes) {
        formData.append(
          key,
          this.isEmpty(this.formAttributes[key]) ? "" : this.formAttributes[key]
        );
      }
      if (cust_quantity) {
        let qty = [];
        this.priceList.map(item => {
          if (parseInt(cust_quantity) !== parseInt(item.cust_quantity)) {
            qty.push(parseInt(item.cust_quantity));
          }
        });

        if (qty.length > 0) {
          qty.push(parseInt(cust_quantity));
          formData.append("qty", qty);
        } else {
          formData.append("qty", parseInt(cust_quantity));
        }
      }
      axios
        .post("/app/api/calculate-price", formData)
        .then(response => {
          this.priceList = response.data.price_list;
          if (!cust_quantity) {
            this.step = 2;
            $("#preview-detail")
              .html($(".product-panel").clone())
              .show();
            $("html, body").animate(
              { scrollTop: $(".preview-detail").offset().top + 150 },
              "slow"
            );
          }
          this.loadingQty = false;
          Swal.close();
        })
        .catch(error => {
          this.loadingQty = false;
          const message =
            error.response && error.response.data && error.response.data.message
              ? error.response.data.message
              : error.response.statusText || "เกิดข้อผิดพลาด";
          Swal.fire({
            type: "error",
            title: "Oops...",
            text: message,
            showConfirmButton: false,
            timer: 4000
          });
        });
    },
    onAddQty() {
      this.priceSelected = null;
      const cust_quantity = this.formAttributes.cust_quantity;
      if (!this.isEmpty(cust_quantity)) {
        this.calculatePrice(cust_quantity);
      }
    },
    onSelectedPriceItem(e, price) {
      $(".list-group")
        .find("li.active")
        .removeClass("active");
      $(e.target).toggleClass("active");
      if ($(e.target).hasClass("active")) {
        this.priceSelected = price;
      } else {
        this.priceSelected = null;
      }
    },
    onRemovePriceItem(item) {
      if (
        this.priceSelected &&
        this.priceSelected.cust_quantity === item.cust_quantity
      ) {
        this.priceSelected = null;
      }

      this.priceList = this.priceList.filter(
        p => p.cust_quantity !== item.cust_quantity
      );
    },
    onDownloadQO() {
      if (this.priceSelected) {
        Swal.fire({
          type: "warning",
          title: "รอสักครู่...",
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          showCancelButton: false,
          animation: false,
          onBeforeOpen: () => {
            Swal.showLoading();
          }
        });
        $.ajax({
          method: "GET",
          url: "/app/product/download",
          data: {
            p: this.formAttributes.product_id
          },
          dataType: "json",
          success: function(response) {
            const modal = $("#ajaxCrudModal");
            modal.find(".modal-header").html(response.title);
            modal.find(".modal-body").html(response.content);
            modal.modal("show");
            Swal.close();
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              type: "error",
              title: "Oops...",
              text: errorThrown,
              showConfirmButton: false,
              timer: 4000
            });
          }
        });
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
    }
  },
  watch: {
    formAttributes: function(val, oldVal) {},
    step: function(value) {
      if (value === 1) {
        $("#preview-detail")
          .html("")
          .show();
        $("html, body").animate(
          { scrollTop: $("#form-quotation").offset().top },
          "slow"
        );
      }
    },
    priceSelected: function(price) {
      if (price) {
        this.formAttributes.cust_quantity = price.cust_quantity;
        this.formAttributes.final_price = price.final_price;
        this.formAttributes.paper_detail_id =
          price.paper.paper_detail.paper_detail_id;
      } else {
        this.formAttributes.cust_quantity = "";
        this.formAttributes.final_price = "";
        this.formAttributes.paper_detail_id = "";
      }
    }
  }
});

$(window).on("load", function() {
  $("span.desc").hide();
});
