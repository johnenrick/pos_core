// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import Helpers from './helpers'
import router from './router'
// import JWTAUTH from './services/auth/jwt-auth'
import 'assets/style/scss/index.scss'
require('services/jwt-auth')
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: {
    App
  }
})
