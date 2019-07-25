const vmCategorys = Vue.component("vm-categorys", {
  props: {
    categorys: {
      type: Array,
      required: true,
      default: function() {
        return [];
      }
    }
  },
  template: `
    <div class="row row-product">
      <div v-for="(category, key) in categorys" :key="key" class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
        <div 
          class="media open-collapse" 
          data-toggle="collapse__35" 
          role="button" 
          aria-expanded="true" 
          aria-controls="collapse__35">
            <a 
              class="product-link product-cate-sub" 
              :href="'/app/product/category?id=' + category.product_category_id" 
              :data-block-id="'block_coll_' + category.product_category_id" 
              :data-point-id="'point-active-' + category.product_category_id">
                <span class="icon">&nbsp;</span>
                <div class="product-sub">
                  <img 
                  class="img-fluid img-responsive center-block" 
                  :src="category.image_url" 
                  alt="">
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
  `
});

Vue.config.productionTip = false;

new Vue({
  el: "#app",
  data: {
    categorys: []
  },
  mounted() {
    this.fetchData();
  },
  components: {
    vmCategorys
  },
  methods: {
    fetchData: function() {
      axios
        .get("/app/api/product-category-list")
        .then(response => {
          // handle success
          this.categorys = response.data;
        })
        .catch(error => {
          // handle error
          Swal.fire({
            type: "error",
            title: "Oops...",
            text: error.response
              ? error.response.statusText || "เกิดข้อผิดพลาด"
              : "เกิดข้อผิดพลาด",
            showConfirmButton: false,
            timer: 4000
          });
        });
    }
  }
});
