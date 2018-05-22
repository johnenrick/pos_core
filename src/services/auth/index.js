// src/auth/index.js
import {router} from '../../router/index'
import ROUTER from '../../router'
import Vue from 'vue'
export default {
  user: {
    userID: 0,
    username: '',
    type: 0,
    company_id: 0,
    company_branch_id: 0
  },
  tokenData: {
    token: null,
    tokenTimer: 1000 * 60 * 1,
    verifyingToken: false,
    isRefreshing: false
  },
  currentPath: false,
  setUser(userID, username, type){
    if(userID === null){
      username = null
      type = null
    }
    this.user.userID = userID * 1
    this.user.username = username
    this.user.type = type * 1
  },
  setCompany(companyID, companyBranch){
    if(companyID === null){
      companyID = null
      companyBranch = null
    }
    this.user.company_id = companyID * 1
    this.user.company_branch_id = companyBranch
    localStorage.setItem('company_id', companyID)
    localStorage.setItem('company_branch_id', companyBranch)
  },
  setToken(token){
    this.tokenData.token = token
    localStorage.setItem('usertoken', token)
    localStorage.setItem('last_token_update', new Date())
    token = token === 'null' ? null : token
    if((token !== null) && !this.tokenData.isRefreshing){
      /**
        TODO
          Multiple authenticate/refresh request has been sent. Comment the isRefreshing to see the error
      */
      this.tokenData.isRefreshing = true
      // setInterval()
      setTimeout(() => {
        let vue = new Vue()
        vue.APIRequest('authenticate/refresh', {}, (response) => {
          if(token){
            this.setToken(response['token'])
          }
          this.tokenData.isRefreshing = false
        }, (response) => {
          this.tokenData.isRefreshing = false
          alert('failed to refresh token')
          ROUTER.go('/')
        })
      }, this.tokenData.tokenTimer) // 50min
    }
  },
  authenticate(username, password, callback, errorCallback){
    let vue = new Vue()
    let credentials = {
      username: username,
      password: password
    }

    vue.APIRequest('authenticate', credentials, (response) => {
      this.setToken(response.token)
      vue.APIRequest('authenticate/user', {}, (userInfo) => {
        this.setUser(userInfo.id, userInfo.username, userInfo.account_type_id)
        console.log(userInfo)
        if(callback){
          callback(userInfo)
        }
      })

    }, (response, status) => {
      if(errorCallback){
        errorCallback(response, status)
      }
    })
  },
  checkAuthentication(callback){
    if(this.tokenData.verifyingToken){
      return
    }
    this.tokenData.verifyingToken = true
    let token = localStorage.getItem('usertoken')
    this.user.company_id = localStorage.getItem('company_id')
    this.user.company_branch_id = localStorage.getItem('company_branch_id')
    if(token && token !== 'null'){
      this.setToken(token)
      let vue = new Vue()
      vue.APIRequest('authenticate/user', {}, (userInfo) => {
        this.setUser(userInfo.id, userInfo.username, userInfo.account_type_id)
        this.tokenData.verifyingToken = false
        if(typeof callback !== 'undefined'){
          callback()
        }
      }, (response) => {
        alert(token)
        alert('failed')
        this.setToken(null)
        this.tokenData.verifyingToken = false
        ROUTER.push({
          path: this.currentPath
        })

      })
    }else{
      this.tokenData.verifyingToken = false
      this.setUser(null)
      if(typeof callback !== 'undefined'){
        callback()
      }
    }
  },
  deaunthenticate(){
    localStorage.removeItem('usertoken')
    localStorage.removeItem('company_id')
    localStorage.removeItem('company_branch_id')
    let vue = new Vue()
    vue.APIRequest('authenticate/invalidate')
    this.setUser(null)
  }
}
