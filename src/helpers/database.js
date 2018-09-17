import quickHelper from './quick_helper.js'
import numberHelper from './number_helper.js'
import Vue from 'vue'
import global from './global'
import config from '../config'
/***
  Be sure to name the helper properly inroder to avoid conflicting on methods in Vue Modules and Components
*/
Vue.mixin({
  methods: {
    latestData: function(apiLink, latestData){
      this.APIRequest(apiLink, {}, (response) => {
        latestData['data'] = response['data']
        latestData['request_timestamp'] = response['request_timestamp']
      })
    },
    formatDBDate: (dbDate, format) => {
      if(dbDate === null){
        return null
      }
      switch(format){
        case 'yyyy/mm/dd':
          let dateObject = new Date(dbDate)
          return dateObject.getFullYear() + '/' + numberHelper.padNumber(dateObject.getMonth() + 1, 2) + '/' + numberHelper.padNumber(dateObject.getDate(), 2)
        case 'MM/dd/yyyy':
          dateObject = new Date(dbDate)
          return numberHelper.padNumber(dateObject.getMonth() + 1, 2) + '/' + numberHelper.padNumber(dateObject.getDate(), 2) + '/' + dateObject.getFullYear()
        default: // 'MM/dd/yyyy H:i:s'
          dateObject = new Date(dbDate)
          return numberHelper.padNumber(dateObject.getMonth() + 1, 2) + '/' + numberHelper.padNumber(dateObject.getDate(), 2) + '/' + dateObject.getFullYear() + ' ' + numberHelper.padNumber(dateObject.getHours()) + ':' + numberHelper.padNumber(dateObject.getMinutes()) + ':' + numberHelper.padNumber(dateObject.getSeconds())
      }
    },
    DBDateFormat: (date, currentFormat) => { // convert Display date to DB Date
      if(date === null){
        return null
      }
      switch(currentFormat){
        default: // 2018-07-16 00:46:38
          let dateObject = new Date(date)
          return dateObject.getFullYear() + '-' + numberHelper.padNumber(dateObject.getMonth() + 1) + '-' + numberHelper.padNumber(dateObject.getDate()) + ' ' + numberHelper.padNumber(dateObject.getHours()) + ':' + numberHelper.padNumber(dateObject.getMinutes()) + ':' + numberHelper.padNumber(dateObject.getSeconds())

      }
    }
  },
  filters: {
    getFormDataFilter(formData, dbName, defaultValue){ // get the value in a formData
      if(dbName === null){
        return null
      }
      let explodedDBName = dbName.split('.')
      if(explodedDBName.length === 1){
        return formData[dbName] ? formData[dbName] : defaultValue
      }else{ // nested form data
        let currentForm = formData
        console.log(formData, explodedDBName)
        for(let dbNameIndex = 0; dbNameIndex < explodedDBName.length; dbNameIndex++){
          if(typeof currentForm[explodedDBName[dbNameIndex]] === 'undefined'){
            return defaultValue
          }else{
            currentForm = currentForm[explodedDBName[dbNameIndex]]
          }
        }
        return currentForm
      }
    }
  }
})
