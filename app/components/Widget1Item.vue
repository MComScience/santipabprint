<template>
  <div class="kt-widget1__item" style="display: -webkit-box;">
    <div class="kt-widget1__info">
      <h3 class="kt-widget1__title">
        <slot name="title"></slot>
        {{ title }}
      </h3>
      <span class="kt-widget1__desc">
        <slot name="desc"></slot>
        {{ desc }}
      </span>
    </div>
    <span class="kt-widget1__number kt-font-brand">
      <slot name="number"></slot>
      {{ number }}
    </span>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'Widget1Item',
  props: {
    title: {
      type: String,
      default: ''
    },
    desc: {
      type: String,
      default: ''
    },
    number: {
      type: String,
      default: ''
    }
  }
}
</script>

<style scoped>
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
</style>
