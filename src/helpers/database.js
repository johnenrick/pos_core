import quickHelper from './quick_helper.js'
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
      switch(format){
        case 'yyyy/mm/dd':
          let dateObject = new Date(dbDate)

          return dateObject.getFullYear() + '/' + quickHelper.padNumber(dateObject.getMonth() + 1, 2) + '/' + quickHelper.padNumber(dateObject.getDate(), 2)
      }
    }
  },
  filters: {
    getFormDataFilter(formData, dbName, defaultValue){
      let explodedDBName = dbName.split('.')
      if(explodedDBName.length === 1){
        return formData[dbName] ? formData[dbName] : defaultValue
      }else{ // nested form data
        let currentForm = formData
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
