import VueRouter from 'vue-router'

// const LandingPage = require('./pages/LandingPage.vue').default;
const AboutPage = require('./pages/AboutPage.vue').default
const LoginPage = require('./pages/LoginPage.vue').default
const ProductPage = require('./pages/ProductPage.vue').default

let routes = [
  { path: '/', component: ProductPage, name: 'landing' },
  { path: '/about', component: AboutPage, name: 'about' },
  { path: '/login', component: LoginPage, name: 'login' },
  { path: '/product', component: ProductPage, name: 'product' }
]

let router = new VueRouter({
  mode: 'history',
  routes
})

export default router
