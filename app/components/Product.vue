<template>
  <div class="row animated zoomIn faster">
    <div v-for="(product, key) in products" :key="key" class="col">
      <div class="media open-collapse">
        <a
          @click="$emit('select-product', product.product_id)"
          href="javascript:void(0)"
          class="product-link product-cate-sub"
        >
          <div class="product-sub">
            <img
              :src="product.image_url"
              :data-src="product.image_url"
              :data-srcset="product.image_url"
              alt="image"
              class="img-fluid img-responsive center-block lazy"
            />
          </div>
          <div class="media-body">
            <p class="product-sub-name">{{ product.product_name }}</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Product',
  props: {
    products: {
      type: Array,
      required: true,
      default: function() {
        return []
      }
    }
  }
}
</script>

<style scoped></style>
