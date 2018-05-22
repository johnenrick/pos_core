
import Vue from 'vue'
import Router from 'vue-router'
import CONFIG from '../config'
import Helpers from './helpers'
import AUTH from 'services/auth/index'
import ModuleRoutes from './module_routes'

import Services from './services'
import Vuex from 'vuex'

global.jQuery = require('jquery')
global.$ = global.jQuery
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'

require('assets/style/fontawesome.min.css')
require('assets/style/fontawesome-all.min.css')
require('assets/style/jquery-confirm.min.css')
require('assets/style/theme.css')
require('assets/style/select2.min.css')
require('assets/js/min/select2.full.min.js')
require('assets/js/min/jquery-confirm.min.js')
// require('assets/js/min/bootstrap-datetimepicker.min.js')
// require('assets/style/bootstrap-datetimepicker.min.css')
// AUTH.checkAuthentication()
Vue.use(Router)
Vue.use(Vuex)
export default new Router({
  routes: ModuleRoutes.routes
})
