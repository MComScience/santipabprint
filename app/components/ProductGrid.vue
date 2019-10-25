<template>
  <div class="product-grid container-fluid">
    <div class="padding-v-sm">
      <div class="line line-dashed"></div>
      <div class="tab-content product-grid-tab" id="pills-tabContent">
        <div
          class="tab-pane fade active in"
          id="pills-all"
          role="tabpanel"
          aria-labelledby="pills-home-tab"
        >
          <div v-if="loading" class="loading">
            <div class="lds-dual-ring" id="loading"></div>
          </div>
          <!--category-->
          <product-category
            v-show="!showCategory"
            :categories="categories"
            @select-category="onSelectCategory"
          />
          <!-- product -->
          <product
            v-show="showCategory && !showProduct"
            :products="products"
            @select-product="onSelectProduct"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCategory from './ProductCategory'
import Product from './Product.vue'

export default {
  name: 'ProductGrid',
  components: {
    ProductCategory,
    Product
  },
  props: {
    categories: {
      type: Array,
      required: true,
      default: function() {
        return []
      }
    },
    products: {
      type: Array,
      required: true,
      default: function() {
        return []
      }
    },
    loading: {
      type: Boolean,
      default: false,
      required: true
    },
    showCategory: {
      type: Boolean,
      default: false,
      required: true
    },
    showProduct: {
      type: Boolean,
      default: false,
      required: true
    }
  },
  methods: {
    onSelectCategory(id) {
      this.$emit('select-category', id)
    },
    onSelectProduct(id) {
      this.$emit('select-product', id)
    }
  }
}
</script>

<style scoped></style>
