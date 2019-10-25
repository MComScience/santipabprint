<template>
  <div class="kt-portlet">
    <div
      class="kt-portlet__head kt-portlet__head--noborder kt-ribbon kt-ribbon--success2 kt-ribbon--shadow"
    >
      <div class="kt-ribbon__target" style="top: 12px; right: -2px;">
        {{ ribbonTitle }}
      </div>
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">{{ title }}</h3>
      </div>
    </div>
    <div class="kt-portlet__body kt-portlet__body--fit-top">
      <slot name="body"></slot>
    </div>
    <div v-if="footer" class="kt-portlet__foot">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'KtPortlet',
  props: {
    ribbonTitle: {
      type: String,
      default: ''
    },
    title: {
      type: String,
      default: ''
    },
    footer: {
      type: Boolean,
      default: true
    }
  }
}
</script>

<style scoped>
.kt-ribbon--success2 .kt-ribbon__target {
  background-color: rgb(181, 213, 106);
  color: #ffffff;
}
</style>
