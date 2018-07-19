import Vue from 'vue'
import VueResource from 'vue-resource'
import CONFIG from '../config'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Router from '../router'
import SystemFrame from '../helpers/system_frame'

Vue.router = Router

// Vue.use(VueResource)
axios.interceptors.response.use((response) => {
  return response
}, function(error){
  // Do something with response error
  switch(error.response.status){
    case 401:
      SystemFrame.logOut()
      break
    case 400:
      SystemFrame.logOut()
      break
  }
  return Promise.reject(error.response)
})

Vue.use(VueAxios, axios)
Vue.axios.defaults.baseURL = CONFIG.API_URL
// Vue.http.options.root = CONFIG.API_URL
Vue.use(require('@websanova/vue-auth'), {
  auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
  loginData: {
    url: 'authentication/create',
    fetchUser: true,
    redirect: false
  },
  rolesVar: 'account_type_id',
  refreshData: {
    url: 'authentication/refresh',
    method: 'POST',
    interval: 30
  },
  fetchData: {
    url: 'authentication/user',
    method: 'POST'
  },
  // authRedirect: {
  //   path: '/login'
  // },
  notFoundRedirect: {
    path: '/404'
  },
  forbiddenRedirect: {
    path: '/404'
  }
})
let currentDate = new Date()
export default{
  currentDate: currentDate
}
