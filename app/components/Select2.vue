<template>
  <select class="form-control select2">
    <slot></slot>
  </select>
</template>

<script>
import 'select2'

export default {
  name: 'Select2',
  props: ['options', 'value'],
  mounted: function() {
    var _this = this
    // init select2
    $(_this.$el)
      .select2(this.options)
      .val(this.value)
      .trigger('change')
      // emit event on change.
      .on('change', function(e) {
        _this.$emit('input', this.value)
        _this.$emit('change', e)
      })
      .on('select2:clear', function(e) {
        _this.$emit('input', this.value)
        _this.$emit('clear', e)
      })
  },
  watch: {
    value: function() {
      // console.log('watch[select2][value]: ', value)
      // update value
      /* if (value) {
        $(this.$el)
          .val(value)
          .trigger("change");
      } */
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
      .select2('destroy')
  }
}
</script>

<style>
.select2-container--bootstrap .select2-selection,
.form-control {
  background-color: #fafafa !important;
}
.select2-container--bootstrap .select2-selection:hover,
.select2-container--bootstrap .select2-selection:hover,
.select2-container--bootstrap .select2-dropdown:hover {
  border: 1px solid #5fccff !important;
}
</style>

<style scoped>
@import url('../assets/css/select2.min.css');
@import url('../assets/css/select2-bootstrap.min.css');
</style>
