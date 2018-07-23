
import Vue from 'vue'
import Router from 'vue-router'
import CONFIG from '../config'
import ModuleRoutes from './module_routes'
import Vuex from 'vuex'

global.jQuery = require('jquery')
global.$ = global.jQuery
// import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
// require('assets/style/_main.scss')
require('@fortawesome/fontawesome-free/sprites/solid.svg')
require('@fortawesome/fontawesome-free/css/all.css')
// require('@fortawesome/fontawesome-free/js/all.js')

// THEME
require('assets/style/sb-admin.min.css')
require('assets/js/min/sb-admin.min.js')
// PLUG INS
require('assets/style/jquery-confirm.min.css')
// require('assets/style/jquery-ui.css')
// require('assets/style/jquery-ui.theme.min.css')
require('assets/style/theme.css')
require('assets/style/select2.min.css')
require('assets/js/min/select2.full.min.js')
require('assets/js/min/jquery-confirm.min.js')
// require('assets/js/min/jquery-ui.min.js')
// require('assets/js/min/bootstrap-datetimepicker.min.js')
// require('assets/style/bootstrap-datetimepicker.min.css')

require('assets/style/frame.css')
Vue.use(Router)
Vue.use(Vuex)

export default new Router({
  routes: ModuleRoutes.routes
})
