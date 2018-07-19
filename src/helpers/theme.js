import Vue from 'vue'

let data = {
  theme_color_palette_list: [
    '#1781c2', // primary
    '#f2a11d', // warning
    '#63cce9', // info
    '#dc3545', // danger
    '#e16389',
    '#3f417f',
    '#d9c7f3',
    '#7a76ff',
    '#fffa90',
    '#ff8383',
    '#fbe50f',
    '#039a80',
    '#75aa68',
    '#8366ac',
    '#e4be6c'
  ]
}
let methods = {
  get_theme_color_palette_list(){
    return data.theme_color_palette_list
  }
}
Vue.mixin({
  methods: methods,
  data(){
    return data
  }
})
export default methods
