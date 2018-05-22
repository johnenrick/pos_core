import Vue from 'vue'
import AUTH from '../services/auth'
Vue.mixin({
  methods: {
    profileSetting(){
    },
    logOut(){
      AUTH.deaunthenticate()
      this.$router.push({
        path: '/'
      })
    },
    logoClicked(){
      this.$router.push('/')
    },
    modal(ref, action){
      $(ref).modal(action)
    }
  }
})
