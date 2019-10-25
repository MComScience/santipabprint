<template>
  <div class="sectionTitle text-center">
    <h2 class="wow">
      <span class="shape shape-left bg-color-4"></span>
      <span>{{ title }}</span>
      <span class="shape shape-right bg-color-4"></span>
    </h2>
    <ol class="breadcrumb">
      <li v-if="isSelectedCategory || isSelectedProduct">
        <a @click="$emit('select-group')" href="javascript:void(0)">
          <i class="fa fa-th"></i> หมวดหมู่
        </a>
      </li>
      <li v-if="isSelectedCategory" class="active">
        <a
          @click="$emit('select-cat', category.product_category_id)"
          href="javascript:void(0)"
          >{{ category.product_category_name }}</a
        >
      </li>
      <li v-if="isSelectedProduct && product" class="active">
        {{ product.product_name }}
      </li>
    </ol>
  </div>
</template>

<script>
export default {
  name: 'SectionTitle',
  props: {
    title: {
      type: String,
      default: 'หมวดหมู่'
    },
    isSelectedCategory: {
      type: Boolean,
      default: false
    },
    isSelectedProduct: {
      type: Boolean,
      default: false
    },
    category: {
      type: Object,
      default: function() {
        return {}
      }
    },
    product: {
      type: Object,
      default: function() {
        return {}
      }
    }
  }
}
</script>

<style scoped></style>
