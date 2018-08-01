<template>
  <div>
    <input type="hidden"
      ref="dateInput"
      v-bind:name="db_name"
      v-model="dateValue"
    >
    <datepicker v-if="form_status !== 'view'"
      :value="form_data[db_name] ? form_data[db_name] : defaultValue"
      :placeholder="(defaultFormat).toLowerCase()"
      :format="defaultFormat"
      :bootstrap-styling="true"
      :clear-button="true"
      :clear-button-icon="'fas fa-trash'"
      @selected="valueChanged"
    ></datepicker>
    <span v-else class="form-control"> {{formatDBDate(form_data[db_name] ? form_data[db_name] : defaultValue, defaultFormat)}} &nbsp;</span>

  </div>
</template>
<script>
  import Datepicker from 'vuejs-datepicker'

  export default{
    name: '',
    components: {
      'datepicker': Datepicker
    },
    create(){

    },
    mounted(){
      this.initInputSetting()
    },
    data(){
      return {
        options: [],
        option_lookup: {},
        defaultValue: null,
        defaultFormat: 'MM/dd/yyyy',
        defaultTimeValue: '',
        dateInputTrueValue: null,
        changeTriggered: false,
        dateValue: null
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
      options(value){
      }
    },
    methods: {
      initInputSetting(){
        if(this.default_value){
          this.defaultValue = this.DBDateFormat(new Date(this.default_value))
          this.valueChanged(this.defaultValue)
        }
        // $(this.$refs.datePickerInput).datetimepicker({
        //   format: 'MM/DD/YYYY',
        //   enabledHours: false,
        //   defaultDate: false,
        //   useCurrent: false,
        //   showClear: true,
        //   showClose: true
        // })
        // .on('dp.change', (e) => {
        //   this.changeTriggered = true
        //   if(e.date){
        //     $(this.$refs.dateInput).val(this.dateInputTrueValue = e.date.year() + '-' + this.padNumber(e.date.month() + 1, 2) + '-' + this.padNumber(e.date.date(), 2) + ' ' + this.defaultTimeValue)
        //   }else{
        //     $(this.$refs.dateInput).val(null)
        //   }
        //   $(this.$refs.dateInput).change()
        //
        // })
        // .on('dp.show', (e) => {
        //   this.changeTriggered = false
        // })
        // .on('dp.hide', (e) => {
        //   if(this.changeTriggered === false && $(this.$refs.datePickerInput).val() === ''){
        //     $(this.$refs.dateInput).val(null)
        //     $(this.$refs.dateInput).change()
        //   }
        // })
        // $(this.$refs.dateInput).on('change', (e) => {
        //   this.valueChanged(e)
        // })
        if(this.input_setting){
          if(this.input_setting['time_setting']){
            typeof this.input_setting['time_setting']['default_time'] !== 'undefined' ? this.defaultTimeValue = this.input_setting['time_setting']['default_time'] : ''
          }
        }
      },
      valueChanged(date){
        let selectedDate = new Date(date)
        if(typeof this.input_setting !== 'undefined' && typeof this.input_setting['time'] !== 'undefined'){
          let timeSegment = this.input_setting['time'].split(':')
          selectedDate.setHours(timeSegment[0])
          selectedDate.setMinutes(timeSegment[1])
          selectedDate.setSeconds(timeSegment[2])
        }else{
          selectedDate.setHours(0)
          selectedDate.setMinutes(0)
          selectedDate.setSeconds(0)
        }
        this.dateValue = (selectedDate.getTime()) > 0 ? this.DBDateFormat(selectedDate.toString()) : null
        this.$emit('change', this.field_name, this.dateValue)
      }
    }

  }
</script>
<style scoped>

</style>
