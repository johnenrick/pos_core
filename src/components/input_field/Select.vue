<template>
  <div>
    <select class="form-control"
      ref="input"
      v-if="form_status !== 'view'"
      v-bind:name="input_name"
      v-bind:field_name="field_name"
      v-bind:value="form_data[db_name] ? form_data[db_name] : defaultValue"
      v-bind:class="feedback_status_class"
      @change="valueChanged"
    >
      <option v-for="option in options" v-bind:value="option['id']"
        v-bind:selected="option['id'] == form_data[db_name] ? 'selected' : false"
      >{{option['text']}}</option>
    </select>
    <span v-else class="form-control">{{this.option_lookup[form_data[db_name]]}} &nbsp;</span>

  </div>
</template>
<script>
  import vue from 'vue'
  export default{
    name: '',
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
        updateOnDataChange: false,
        optionFunction: (instance) => {}
      }
    },
    props: {
      input_setting: Object,
      default_value: [String, Number],
      db_name: String,
      input_name: String,
      field_name: String,
      form_data: Object,
      form_status: String,
      feedback_status_class: String,
      form_data_updated: Boolean
    },
    watch: {
      form_status(value){
        if(value === 'create' || value === 'editing' || value === 'view'){
          this.optionFunction(this)
        }
      },
      options(value){
      },
      form_data_updated(newValue){
        // if(typeof this.input_setting['on_change'] !== 'undefined'){
        //   this.input_setting['on_change'](this.form_data[this.db_name] ? this.form_data[this.db_name] : this.defaultValue)
        // }
      }
    },
    methods: {
      initInputSetting(){
        typeof this.input_setting['options'] !== 'undefined' ? this.setOption(this.input_setting['options']) : null
        this.defaultValue = this.default_value
        if(typeof this.input_setting['option_function'] !== 'undefined'){
          this.optionFunction = this.input_setting['option_function']
          this.optionFunction(this)
        }else if(typeof this.input_setting['api'] !== 'undefined'){
          this.optionFunction = this.generateAPIOption
          this.optionFunction(this)
        }
        if(typeof this.input_setting['update_on_data_change'] !== 'undefined'){
          this.updateOnDataChange = this.input_setting['update_on_data_change']
        }
      },
      /* Automatically generate the select option base on the api */
      generateAPIOption(){
        let apiParameter = typeof this.input_setting['api_parameter'] !== 'undefined' ? this.input_setting['api_parameter'] : (typeof this.input_setting['api_parameter_function'] !== 'undefined' ? this.input_setting['api_parameter_function'](this.form_data) : {})
        this.APIRequest(this.input_setting['api'], apiParameter, (response) => {
          if(response['data']){
            let options = []
            let columnKey = this.input_setting['api_option_text_column'] ? this.input_setting['api_option_text_column'] : 'description'
            for(let x = 0; x < response['data'].length; x++){
              options.push({
                id: response['data'][x]['id'],
                text: this.input_setting['api_option_text_function'] ? this.input_setting['api_option_text_function'](response['data'][x]) : response['data'][x][columnKey]
              })
            }
            this.setOption(options)
          }
        })
      },
      setOption(options){
        this.options = options.slice(0)
        if(typeof this.input_setting['default_text'] !== 'undefined'){ // add default value in select if default text is defined
          this.options.unshift({
            id: typeof this.input_setting['default_value'] !== 'undefined' ? this.input_setting['default_value'] : null,
            text: this.input_setting['default_text']
          })
        }
        this.option_lookup = {}
        for(let x in this.options){
          vue.set(this.option_lookup, this.options[x]['id'], this.options[x]['text'])
        }

      },
      valueChanged(e){
        if(typeof this.input_setting['on_change'] !== 'undefined'){
          this.input_setting['on_change'](this.form_data[this.db_name])
        }
        this.$emit('change', this.field_name, $(this.$refs.input).val())
      },
      notifyChildDataChange(field, value){
        if(field === this.db_name && typeof this.input_setting['on_change'] !== 'undefined'){
          this.input_setting['on_change'](value)
        }
        if(this.updateOnDataChange(field, this.form_data)){
          this.optionFunction(this)
        }

      }
    }

  }
</script>
<style scoped>

</style>
