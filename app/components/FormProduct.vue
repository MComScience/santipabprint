<template>
  <form>
    <!--begin: ขนาด -->
    <v-row>
      <v-col xs="12" sm="6" md="6">
        <div class="form-group">
          <label class="control-label">ขนาด</label>
          <select2
            v-if="isvisibleInput('paper_size_id')"
            :options="paperSizeIdOption"
            v-model="attributes.paper_size_id"
            @change="onChangePaperSizeId"
          >
            <option disabled value>เลือกขนาด</option>
          </select2>
          <span class="help-block"></span>
        </div>
      </v-col>
    </v-row>
    <!--end: ขนาด -->
  </form>
</template>

<script>
import VRow from './Row'
import VCol from './Col'
import Select2 from './Select2'
import Swal from 'sweetalert2'
import * as $ from 'jquery'

function format(state) {
  if (!state.id) return state.text // optgroup
  return state.text
}

export default {
  name: 'FormProduct',
  props: {
    attributes: {
      type: Object,
      required: true,
      default: function() {
        return {}
      }
    },
    dataOptions: {
      type: Object,
      required: true,
      default: function() {
        return {}
      }
    },
    formOptions: {
      type: Object,
      required: true,
      default: function() {
        return {}
      }
    },
    productId: {
      type: String,
      default: ''
    }
  },
  components: {
    VRow,
    VCol,
    Select2
  },
  data() {
    return {
      select2Options: {
        data: [{ id: 1, text: 'Hello' }, { id: 2, text: 'World' }],
        allowClear: true,
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'เลือกรายการ',
        language: 'th'
      },
      // ขนาด
      paperSizeIdOption: {
        data: [],
        allowClear: true,
        templateResult: format,
        templateSelection: format,
        escapeMarkup: function(m) {
          return m
        },
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'เลือกขนาด',
        language: 'th'
      },
      // จำนวนแผ่นต่อชุด
      billQtyOption: {
        data: [],
        allowClear: true,
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'เลือกจำนวนแผ่นต่อชุด',
        language: 'th'
      },
      selected: ''
    }
  },
  methods: {
    isvisibleInput: function(attribute) {
      if (this.isEmpty(this.formOptions)) return false
      if (this.isEmpty(this.formOptions[attribute])) return false
      return (
        this.formOptions[attribute] && this.formOptions[attribute].value === '1'
      )
    },
    isEmpty: function(value, trim) {
      return (
        value === null ||
        value === undefined ||
        value.length === 0 ||
        (trim && $.trim(value) === '')
      )
    },
    onChangePaperSizeId: function(e) {
      const _this = this
      if (e.target.value !== 'custom') {
        // กำหนดเอง
        _this.attributes = _this.updateObject(_this.attributes, {
          paper_size_width: '',
          paper_size_lenght: '',
          paper_size_height: '',
          paper_size_unit: ''
        })
        $('#paper_size_unit')
          .val(null)
          .trigger('change')
      }
      this.storeData()
      // จำนวนแผ่นต่อชุด
      if (this.isvisibleInput('bill_detail_qty')) {
        this.fetchDataBillFloorOptions()
      }
    },
    updateObject(oldObject, updatedProperties) {
      return {
        ...oldObject,
        ...updatedProperties
      }
    },
    storeData: async function() {
      let formData = {}
      const cacheData = await JSON.parse(localStorage.getItem('formData'))
      if (cacheData && cacheData[this.productId]) {
        const attributes = await this.attributes
        const cacheAttributes = await cacheData[this.productId]
        for (let i in this.attributes) {
          if (
            this.isEmpty(attributes[i]) &&
            !this.isEmpty(cacheAttributes[i])
          ) {
            attributes[i] = cacheAttributes[i]
          }
        }
        formData[this.productId] = await attributes
      } else if (cacheData) {
        formData[this.productId] = await this.attributes
        formData = await this.updateObject(formData, cacheData)
      }
      localStorage.setItem(
        'formData',
        JSON.stringify(Object.assign(cacheData, formData))
      )
    },
    // จำนวนแผ่นต่อชุด
    fetchDataBillFloorOptions() {
      let attributes = this.attributes
      if (this.isvisibleInput('bill_detail_qty')) {
        window.axios
          .get(
            `/app/api/bill-floor-options?paper_size_id=${attributes.paper_size_id}&paper_id=${attributes.paper_id}`
          )
          .then(response => {
            // handle success
            this.billQtyOption = this.updateObject(this.billQtyOption, {
              data: this.mapDataOptions(response.data)
            })
            this.$nextTick(function() {
              this.attributes['bill_detail_qty'] = null
            })
            setTimeout(() => {
              $('#bill_detail_qty')
                .val(null)
                .trigger('change')
            }, 500)
          })
          .catch(error => {
            // handle error
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: error.response
                ? error.response.statusText || 'เกิดข้อผิดพลาด'
                : 'เกิดข้อผิดพลาด',
              showConfirmButton: false,
              timer: 4000
            })
          })
      }
    },
    mapDataOptions: function(options) {
      let dataOptions = []
      for (const key in options) {
        if (typeof options[key] === 'object') {
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
    async setInputDataOptions() {
      const _this = this
      const { dataOptions, formOptions } = _this
      if (!_this.isEmpty(dataOptions) && !_this.isEmpty(formOptions)) {
        // ขนาด
        if (
          _this.isvisibleInput('paper_size_width') &&
          _this.isvisibleInput('paper_size_lenght') &&
          _this.isvisibleInput('paper_size_unit')
        ) {
          _this.paperSizeIdOption = await _this.updateObject(
            _this.paperSizeIdOption,
            {
              data: _this.mapDataOptions(dataOptions.paperSizeOptions)
            }
          )
        } else {
          const paperSizeOptions = {}
          for (const key in dataOptions.paperSizeOptions) {
            if (key !== 'custom') {
              paperSizeOptions[key] = dataOptions.paperSizeOptions[key]
            }
          }
          _this.paperSizeIdOption = await _this.updateObject(
            _this.paperSizeIdOption,
            {
              data: _this.mapDataOptions(paperSizeOptions)
            }
          )
        }
      }
    }
  },
  watch: {
    dataOptions: function(options) {
      console.log('options', options)
      this.setInputDataOptions()
    }
  }
}
</script>

<style scoped></style>
