import Vue from 'vue'

Vue.mixin({
  components: {
    'loading-indicator': require('../components/common_module/LoadingIndicator.vue')
  },
  methods: {
    commonModuleOptionizeArray(array, defaultValue, defaultLabel){
      let option = []
      option.push({
        id: defaultValue,
        text: defaultLabel
      })
      for(let x = 0; x < array.length; x++){
        option.push({
          id: x + 1,
          text: array[x]
        })
      }
      return option
    },
    /* Trigger the notifyChildDataChange of a ref */
    refNotifyChildDataChange(ref, field, value){
      if(ref){
        if(ref.length > 1){
          for(let x = 0; x < ref.length; x++){
            try{
              ref[x].notifyChildDataChange(field, value)
            }catch(error){
              // console.warn('Add a notifyChildDataChange method to the input')
            }
          }
        }else{
          try{
            ref.notifyChildDataChange(field, value)
          }catch(error){
            // console.warn('Add a notifyChildDataChange method to the input')
          }
        }
      }
    }
  }
})
