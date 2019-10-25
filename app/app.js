import Antd from 'ant-design-vue'
import 'ant-design-vue/dist/antd.css'
import ElementUI from 'element-ui'
// import "element-ui/lib/theme-chalk/index.css"
import { extend, localize, ValidationProvider } from 'vee-validate'
import * as rules from 'vee-validate/dist/rules'
import Vue from 'vue'
import VueMeta from 'vue-meta'
import router from './routes.js'

require('./bootstrap')

Vue.config.productionTip = false

window.Vue = require('vue')

Vue.use(VueMeta, {
  keyName: 'head'
})
Vue.use(ElementUI)
Vue.use(Antd)

// Register it globally
localize('th')
// loop over all rules
for (let rule in rules) {
  // add the rule
  extend(rule, rules[rule])
}
Vue.component('ValidationProvider', ValidationProvider)

window.app = new Vue({
  el: '#myApp',
  router,
  data: {
    loadingPage: true
  },
  mounted: function() {
    this.$nextTick(function() {
      this.loadingPage = false
    })
  },
  methods: {
    isActiveMenu(path) {
      return window.location.pathname === path
    }
  }
})
