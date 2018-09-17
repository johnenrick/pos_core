<template>
  <div>
    <input type="hidden"
      ref="dateInput"
      v-bind:name="db_name"
      v-model="dateValue"
    >
    <datetimepicker v-if="form_status !== 'view'"
      v-model="datetimeValue"
      @changed="alert()"
      :placeholder="(defaultFormat).toLowerCase()"
      :format="defaultFormat"
      :config="options"
      :bootstrap-styling="true"
      :clear-button="true"
      :clear-button-icon="'fas fa-trash'"
      @selected="valueChanged"
    ></datetimepicker>
    <span v-else class="form-control"> {{formatDBDate(form_data[db_name] ? form_data[db_name] : defaultValue, defaultFormat)}} &nbsp;</span>

  </div>
</template>
<script>
  // import Datepicker from 'vuejs-datepicker'
  import Vue from 'vue'
  import Datepicker from 'vue-bootstrap-datetimepicker'
  import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css'
  jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
    icons: {
      time: 'far fa-clock',
      date: 'far fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'fas fa-calendar-check',
      clear: 'far fa-trash-alt',
      close: 'far fa-times-circle'
    }
  })
  export default{
    name: '',
    components: {
      'datetimepicker': Datepicker
    },
    create(){

    },
    mounted(){
      this.initInputSetting()
    },
    data(){
      let defaultFormat = 'MM/DD/YYYY H:mm:ss'
      return {
        option_lookup: {},
        datetimeValue: null,
        defaultValue: null,
        defaultFormat: defaultFormat,
        defaultTimeValue: '',
        dateInputTrueValue: null,
        changeTriggered: false,
        dateValue: null,
        options: {
          format: defaultFormat,
          useCurrent: false,
          showClear: true,
          showClose: true
        }
      }
    },
    props: {
      input_setting: Object,
      default_value: [String, Number, Date],
      db_name: String,
      form_data: Object,
      form_status: String,
      field_name: String
    },
    watch: {
      form_status(value){
        if(value === 'create' || value === 'editing' || value === 'view'){
        }
      },
      datetimeValue(newData){
        // console.log('hello', this.DBDateFormat())
        this.valueChanged(newData)
        // this.form_data[db_name] ? this.form_data[this.db_name] : this.defaultValue
      }
    },
    methods: {
      initInputSetting(){
        if(this.default_value){
          this.defaultValue = this.DBDateFormat(new Date(this.default_value))
          Vue.set(this.options, 'defaultDate', new Date(this.default_value))
          this.valueChanged(this.defaultValue)
        }
        if(this.input_setting){
          if(this.input_setting['time_setting']){
            typeof this.input_setting['time_setting']['default_time'] !== 'undefined' ? this.defaultTimeValue = this.input_setting['time_setting']['default_time'] : ''
          }
        }
      },
      valueChanged(date){
        let selectedDate = new Date(date)
        this.dateValue = (selectedDate.getTime()) > 0 ? this.DBDateFormat(selectedDate.toString()) : null
        this.$emit('change', this.field_name, this.dateValue)
      }
    }

  }
</script>
<style scoped>

</style>
