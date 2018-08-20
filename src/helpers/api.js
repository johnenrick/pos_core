import CONFIG from '../config'
import Vue from 'vue'
import ROUTER from '../router'
Vue.mixin({
  mounted(){

  },
  methods: {
    getURLParameter(){
      let tokenStringParam = (localStorage.getItem('default_auth_token')) ? '?token=' + localStorage.getItem('default_auth_token') + '&selected_company_id=' + 1 + '&selected_company_branch_id=' + 1 : ''
      return tokenStringParam
    },
    APIRequest(link, parameter, callback, errorCallback){

      let request = jQuery.post(CONFIG.API_URL + link + this.getURLParameter(), parameter, (response) => {
        this.APISuccessRequestHandler(response, callback)
      }).fail((jqXHR) => {
        this.APIFailRequestHandler(link, jqXHR, errorCallback)
      })
      return request
    },
    APIGetRequest(link, parameter, callback, errorCallback){
      let request = jQuery.get(link + this.getURLParameter(), parameter, (response) => {
        this.APISuccessRequestHandler(response, callback)
      }).fail((jqXHR) => {
        this.APIFailRequestHandler(link, jqXHR, errorCallback)
      })
      return request
    },
    APIFormRequest(link, formRef, callback, errorCallback){
      let formData = new FormData($(formRef)[0])
      $.ajax({
        url: CONFIG.API_URL + link + this.getURLParameter(),
        type: 'POST',
        data: formData,
        success: (response) => {
          this.APISuccessRequestHandler(response, callback)
        },
        error: (jqXHR) => {
          this.APIFailRequestHandler(link, jqXHR, errorCallback)
        },
        cache: false,
        contentType: false,
        processData: false
      })
    },
    APISuccessRequestHandler(response, callback){
      if(callback){
        callback(response)
      }
    },
    APIFailRequestHandler(link, jqXHR, errorCallback){
      switch(jqXHR.status){
        case 401: // Unauthorized
          if(link === 'authenticate' || 'authenticate/user'){ // if error occured during authentication request
            console.log('Failed Request', new Date())
            console.log('link: ' + link + ' date: ' + localStorage.getItem('last_token_update') + ' ---- ' + (new Date()))
            console.log(JSON.parse(localStorage.getItem('token_history')))
            if(errorCallback){
              alert(link)
              errorCallback(jqXHR.responseJSON, jqXHR.status * 1)
            }
          }else{
            alert('unauthorized request: ' + link)
            ROUTER.push('login')
          }
          break
        default:
          console.log(errorCallback)
          alert('There is an error: ' + link)
          if(errorCallback){
            errorCallback(jqXHR.responseJSON, jqXHR.status * 1)
          }
      }
    }
  }
})
