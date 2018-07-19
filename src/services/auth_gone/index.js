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
    tokenTimer: 1000 * 60 * 2, // 2min
    tokenLife: 1000 * 60 * 2, // 2min
    verifyingToken: false
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
    console.log('token set')
    this.tokenData.token = token
    localStorage.setItem('user_token', token)
    localStorage.setItem('token_datetime_updated', new Date())
  },
  keepTokenAlive(){
    let tokenDatetimeUpdated = (new Date(localStorage.getItem('token_datetime_updated'))).getTime()
    let tokenDatetimeKiled = (new Date(localStorage.getItem('token_datetime_killed'))).getTime()
    let tokenUpdating = (new Date(localStorage.getItem('token_updating'))).getTime() // the time the token is starts updating
    let currentDatetime = (new Date()).getTime()
    let tokenAge = (currentDatetime - tokenDatetimeUpdated)
    if(tokenDatetimeKiled >= tokenDatetimeUpdated || tokenAge > this.tokenData.tokenLife){ // token has been killed or expired
      console.info('Token killed or Expired')
      return false
    }else if(tokenUpdating && (currentDatetime - tokenUpdating <= 15000)){ // token is updating in less than 15 seconds
      console.info('Refreshing is ongoing, recheck after 15 seconds')
      setTimeout(() => {
        this.keepTokenAlive()
      }, 15500 - (currentDatetime - tokenUpdating)) // Recheck after 15.5 seconds
      return false
    }else if(localStorage.getItem('user_token') && tokenAge >= (this.tokenData.tokenLife - 60000)){ // refreshToken, refresh if 1minute only is remaining
      console.info('Refresh Token')
      let vue = new Vue()
      let token = localStorage.getItem('user_token')
      localStorage.setItem('token_updating', new Date())
      vue.APIRequest('authentication/refresh', {}, (response) => {
        tokenDatetimeKiled = (new Date(localStorage.getItem('token_datetime_killed'))).getTime()
        currentDatetime = (new Date()).getTime()
        if(localStorage.getItem('token_datetime_killed') === null){
          this.setToken(response['token'])
          this.addTokenHistory('refreshToken', token)
          setTimeout(() => {
            this.keepTokenAlive()
          }, this.tokenData.tokenLife - 60500)
        }
        localStorage.removeItem('token_updating')
      }, (response) => { // failed to refresh token
        console.error(JSON.parse(localStorage.getItem('token_history')))
        this.deaunthenticate()
        alert('failed to refresh token')
      })
      return true
    }else{ // recheck later
      // console.log('token age', tokenAge, 'token life', this.tokenData.tokenLife - 60000, 'need to refresh', (tokenAge >= (this.tokenData.tokenLife - 60000)), localStorage.getItem('user_token'))
      let recheckTimer = this.tokenData.tokenLife - tokenAge - 60500
      // console.log('Rechecking later', recheckTimer, tokenAge - 60500)
      setTimeout(() => {
        this.keepTokenAlive()
      }, recheckTimer)
    }
  },
  login(username, password, callback, errorCallback){
    let vue = new Vue()
    let credentials = {
      username: username,
      password: password
    }
    localStorage.removeItem('token_history')
    vue.APIRequest('authentication/create', credentials, (response) => {
      this.setToken(response.token)
      this.addTokenHistory('authentication', response.token)
      vue.APIRequest('authentication/user', {}, (userInfo) => {
        alert()
        this.setUser(userInfo.data.id, userInfo.data.username, userInfo.data.account_type_id)
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
  checkAuthentication(callback, text){
    console.info('checking authentication')
    // TODO if still verifying
    let token = localStorage.getItem('user_token')
    this.user.company_id = localStorage.getItem('company_id')
    this.user.company_branch_id = localStorage.getItem('company_branch_id')
    if(token && token !== 'null'){
      this.setToken(token)
      let vue = new Vue()
      this.tokenData.verifyingToken = true
      vue.APIRequest('authentication/user', {}, (userInfo) => {
        localStorage.removeItem('token_datetime_killed')
        this.setUser(userInfo.data.id, userInfo.data.username, userInfo.data.account_type_id)
        this.addTokenHistory('checkAuthentication', token, text)
        console.info('keeping token alive')
        this.keepTokenAlive()
        if(typeof callback !== 'undefined'){
          callback()
        }
        if(localStorage.getItem('current_page')){
          console.info(localStorage.getItem('current_page'))
          ROUTER.push({
            path: localStorage.getItem('current_page')
          })
        }
        this.tokenData.verifyingToken = false
      }, (response) => {
        this.setToken(null)
        alert('checkAuth authentication user failed')
        this.deaunthenticate()
        if(typeof callback !== 'undefined'){
          callback()
        }
        this.tokenData.verifyingToken = false
      })
    }else{
      this.setUser(null)
      if(typeof callback !== 'undefined'){
        callback()
      }
    }
  },
  deaunthenticate(){
    let vue = new Vue()
    vue.APIRequest('authentication/destroy')
    localStorage.removeItem('user_token')
    localStorage.removeItem('company_id')
    localStorage.removeItem('company_branch_id')
    localStorage.removeItem('token_history')
    localStorage.removeItem('token_updating')
    localStorage.removeItem('current_page')
    localStorage.getItem('token_datetime_killed', new Date())
    this.setUser(null)
  },
  addTokenHistory(source, token, text){
    let tokenHistory = localStorage.getItem('token_history') ? JSON.parse(localStorage.getItem('token_history')) : []
    let date = new Date()
    tokenHistory.push({
      token: token,
      time_added: date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes(),
      source: source,
      text: text
    })
    localStorage.setItem('token_history', JSON.stringify(tokenHistory))
  }
}
