<template>
  <div class="row row-product animated zoomIn faster">
    <div v-for="(category, key) in categories" :key="key" class="col">
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
</template>

<script>
  export default {
    name: "ProductCategory",
    props: {
      categories: {
        type: Array,
        required: true,
        default: function() {
          return []
        }
      }
    },
  }
</script>

<style scoped>

</style>