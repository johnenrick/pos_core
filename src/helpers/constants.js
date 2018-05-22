import Vue from 'vue'
import global from './global'
import config from '../config'
Vue.mixin({
  methods: {
    APIUrl(url){
      return config.API_URL + url
    },
    listDatabaseConstants(apiLink, key, resultContainer, callbackFn){
      let requestOption = {
        with_soft_delete: true
      }
      if(resultContainer['datetime_updated']){
        requestOption.condition = [
          {
            column: 'updated_at',
            clause: '>',
            value: resultContainer['datetime_updated']
          }
        ]
      }
      this.APIRequest(apiLink, requestOption, (response) => {
        let result = response
        Vue.set(resultContainer['options'], 0, {
          text: 'Select',
          value: null
        })
        if(result.data){
          for(let x in result.data){
            Vue.set(resultContainer['options'], +result.data[x]['id'], {
              text: result.data[x]['description'],
              value: result.data[x]['id']
            })
            if(new Date(result.data[x]['updated_at']) > new Date(resultContainer['datetime_updated'])){
              resultContainer['datetime_updated'] = result.data[x]['updated_at']
            }
          }
        }
        callbackFn(response)

      })
    }
  }
})
