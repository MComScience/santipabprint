import Vue from "vue"
import VueRouter from "vue-router"

Vue.use(VueRouter)

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
try {
  window.Popper = require("popper.js").default
  window.$ = window.jQuery = require("jquery")

  require("bootstrap")
} catch (e) {}

window.axios = require("axios")

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content
  window.csrf = token
} else {
  console.error("CSRF token not found")
}
