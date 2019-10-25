<template>
  <div>
    <hr v-show="line" />
    <h4 class="box-title kt-font-brand">{{ title }} :</h4>
  </div>
</template>

<script>
export default {
  name: 'BoxTitle',
  props: {
    title: {
      type: String,
      default: ''
    },
    line: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<style scoped>
.box-title {
  font-size: 16px;
  color: #25b3da;
  text-transform: unset;
}
hr {
  margin-top: 20px;
  margin-bottom: 10px;
}
.kt-font-brand {
  color: #22b9ff !important;
}
</style>
