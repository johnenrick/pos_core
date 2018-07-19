import Router from 'vue-router'
let CONFIG = require('config.js')
let beforeEnter = (to, from, next) => {
  next()
}
var devRoutes = []
let plenos = require('./dev_routes/plenos.js')
devRoutes = devRoutes.concat(plenos.default.routes)
for(let x = 0; x < devRoutes.length; x++){
  devRoutes[x]['beforeEnter'] = beforeEnter
}
let routes = [
  {
    path: '/',
    name: 'root',
    component: resolve => require(['modules/home/LogIn.vue'], resolve)
  },
  {
    path: '/home',
    name: 'home',
    component: resolve => require(['modules/home/Home.vue'], resolve)
  },
  {
    path: '/login',
    name: 'login',
    component: resolve => require(['modules/home/LogIn.vue'], resolve),
    meta: {
      auth: false
    }
  },
  {
    path: '/404',
    name: '404',
    component: resolve => require(['modules/home/NotFound.vue'], resolve),
    meta: {
      auth: false
    }

  }
]
// if(CONFIG.default.IS_DEV){
routes = routes.concat(devRoutes)
// }
export default{
  routes: routes
}
