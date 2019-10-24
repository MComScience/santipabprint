<template>
  <div class="form-group">
    <label v-show="label" class="control-label">{{ inputLabel }}</label>
    <slot name="input"></slot>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'InputFormGroup',
  props: {
    label: {
      type: Boolean,
      default: true
    },
    inputLabel: {
      type: String,
      default: ''
    }
  }
}
</script>

<style scoped>
label {
  font-weight: 400;
}
</style>
