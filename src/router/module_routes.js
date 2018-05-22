import AUTH from 'services/auth'
let CONFIG = require('config.js')
let hasAccess = (to) => {
  if(AUTH.user.type === 1){ // admin
    if([1, 2, 3].includes(to.meta.module_id)){
      return true
    }
  }else if(AUTH.user.type === 2){
    if([3].includes(to.meta.module_id)){
      return true
    }
  }else if(AUTH.user.type === 3){
    if([4].includes(to.meta.module_id)){
      return true
    }
  }
  return false
}
let beforeEnter = (to, from, next) => {
  // TODO Redirect if no token when token is required in meta.tokenRequired
  AUTH.checkAuthentication(() => {
    AUTH.currentPath = to.path
    let isTokenRequired = typeof to.meta.tokenRequired === 'undefined' ? true : to.meta.tokenRequired
    if(AUTH.user.userID || isTokenRequired === false){
      if(isTokenRequired === false){
        next()
      }else if(hasAccess(to)){
        next()
      }else{
        next({
          path: '/login'
        })
      }
    }else{
      if(!AUTH.tokenData.verifyingToken){
        next({
          path: '/login'
        })
      }
    }
  })
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
    component: resolve => require(['modules/home/Home.vue'], resolve),
    beforeEnter: (to, from, next) => {
      AUTH.checkAuthentication(() => {
        if(AUTH.user.type === 1){
          next({
            path: '/admin'
          })
        }else if(AUTH.user.type === 2){
          next({
            path: '/cashier'
          })
        }else if(AUTH.user.type === 3){
          next({
            path: '/server'
          })
        }else{
          next({
            path: '/login'
          })
        }
      })
    }
  },
  {
    path: '/login',
    name: 'login',
    component: resolve => require(['modules/home/LogIn.vue'], resolve),
    beforeEnter: (to, from, next) => {
      if(AUTH.user.userID){
        next({
          path: '/'
        })
      }else{
        next()
      }
    }

  }
]
// if(CONFIG.default.IS_DEV){
routes = routes.concat(devRoutes)
// }
export default{
  routes: routes
}
