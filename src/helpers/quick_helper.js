import Vue from 'vue'
import global from './global'
import config from '../config'
/***
  Be sure to name the helper properly inroder to avoid conflicting on methods in Vue Modules and Components
*/
Vue.mixin({
  data(){
    return {
      IMAGE_URL: config.IMAGE_URL
    }
  },
  methods: {
    modal: function(action){
      if(action === 'show'){
        global.hasShownModal = true
      }else if(action === 'close'){
        global.hasShownModal = false
      }
    },
    isset(objectVariable, name){
      return typeof objectVariable[name] !== 'undefined'
    },
    sampleHelper(){
      return 'hello world'
    },
    monthWord(monthIndex, isThreeLetter){
      let month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
      return isThreeLetter ? (month[monthIndex]).substring(0, 3) : month[monthIndex]
    },
    formatTime(datetimeObject){
      var hours = datetimeObject.getHours()
      var minutes = datetimeObject.getMinutes()
      var ampm = hours >= 12 ? 'pm' : 'am'
      hours = hours % 12
      hours = hours || 12 // the hour '0' should be '12'
      minutes = minutes < 10 ? '0' + minutes : minutes
      var strTime = hours + ':' + minutes + ' ' + ampm
      return strTime
    },
    setDateTime(date, hour, minute, second){ // set the time of the javascript Date object

      var dateObject = new Date(date)
      dateObject.setHours(hour)
      dateObject.setMinutes(minute)
      dateObject.setSeconds(second)
      return dateObject
    },
    cloneObject(obj){
      var copy
      if(obj === null || typeof obj !== 'object') return obj
      // Handle Date
      if(obj instanceof Date) {
        copy = new Date()
        copy.setTime(obj.getTime())
        return copy
      }
      // Handle Array
      if(obj instanceof Array) {
        copy = []
        for (var i = 0, len = obj.length; i < len; i++) {
          copy[i] = this.cloneObject(obj[i])
        }
        return copy
      }
      // Handle Object
      if(obj instanceof Object) {
        copy = {}
        for (var attr in obj) {
          if(obj.hasOwnProperty(attr)) copy[attr] = this.cloneObject(obj[attr])
        }
        return copy
      }
      throw new Error('Unable to copy obj! Its type is not supported.')
    },
    setDefaultValue(defaultValue, ifNoDefaultValue){
      return typeof defaultValue === 'undefined' ? ifNoDefaultValue : defaultValue
    },
    moveArray(array, pos1, pos2) {
      let i, tmp
      pos1 = parseInt(pos1, 10)
      pos2 = parseInt(pos2, 10)
      if(pos1 !== pos2 && pos1 <= 0 && pos1 <= array.length && pos2 <= 0 && pos2 <= array.length) {
        tmp = array[pos1]
        if(pos1 < pos2) {
          for(i = pos1; i < pos2; i++) {
            array[i] = array[i + 1]
          }
        }else {
          for(i = pos1; i > pos2; i--) {
            array[i] = array[i - 1]
          }
        }
        array[pos2] = tmp
        return array
      }
    }
  }
})
