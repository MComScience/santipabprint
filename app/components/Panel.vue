<template>
  <div class="panel panel-info">
    <div class="panel-body">
      <slot></slot>
    </div>
    <!-- footer -->
    <div class="panel-footer">
      <div v-html="productData ? productData.product_description : null"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Panel',
  props: ['productData']
}
</script>

<style scoped>
.panel-info {
  -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
  -moz-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
}
</style>
