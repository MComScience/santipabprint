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
      <div v-for="(category, key) in categorys" :key="key" class="col">
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
      var vm = this;
      axios
        .get("/app/api/product-category-list")
        .then(response => {
          // handle success
          this.categorys = response.data;
          $("#loading").hide();
          setTimeout(function(){
              vm.lazyImages()
          })
        })
        .catch(error => {
          $("#loading").hide();
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
    },
    lazyImages: function() {
      var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

        if ("IntersectionObserver" in window) {
          let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
              if (entry.isIntersecting) {
                let lazyImage = entry.target;
                lazyImage.src = lazyImage.dataset.src;
                lazyImage.srcset = lazyImage.dataset.srcset;
                lazyImage.classList.remove("lazy");
                setTimeout(function(){
                    lazyImage.classList.remove("blur");
                },1000)
                lazyImageObserver.unobserve(lazyImage);
              }
            });
          });

          lazyImages.forEach(function(lazyImage) {
            lazyImageObserver.observe(lazyImage);
          });
        } else {
          // Possibly fall back to a more compatible method here
        }
    }
  }
});
