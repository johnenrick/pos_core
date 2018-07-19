import Vue from 'vue'
import Router from '../router'
let methods = {
  profileSetting(){
  },
  logOut(){
    if(typeof this.$auth !== 'undefined'){
      this.$auth.logout()
      this.$router.push('/')
    }else{ // calling log out even if the $auth is not ready yet
      localStorage.removeItem('default_auth_token')
      Router.push('/')
    }

  },
  logoClicked(){
    this.$router.push('/')
  },
  modal(ref, action){
    $(ref).modal(action)
  }
}
Vue.mixin({
  methods: methods
})

export default methods
