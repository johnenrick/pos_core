import Vue from 'vue'

Vue.mixin({
  methods: {
    commonModuleOptionizeArray(array, defaultValue, defaultLabel){
      let option = []
      option.push({
        value: defaultValue,
        label: defaultLabel
      })
      for(let x = 0; x < array.length; x++){
        option.push({
          value: x + 1,
          label: array[x]
        })
      }
      return option
    }
  }
})
