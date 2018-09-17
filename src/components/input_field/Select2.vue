<template>
  <div>
    <div v-bind:class="form_status === 'view' ? 'hide' :''">
      <vue-select ref="select" style="width:100%"
        :onSearch="onSearch"
        :options='options'
        v-bind:name="db_name"
      >
    </vue-select>
    </div>
    <span v-if="form_status === 'view'" class="form-control">hey</span>
  </div>
</template>
<script>
  import select2 from 'vue-select'
  export default{
    name: '',
    components: {
      'vue-select': select2
    },
    create(){

    },
    mounted(){
      this.initInput()
    },
    data(){
      return {
        value: null,
        options: [],
        apiUrl: null,
        apiParameter: {},
        apiSearchColumn: null,
        apiSearchClause: '='
      }
    },
    props: {
      input_setting: Object,
      default_value: String,
      db_name: String,
      form_data: Object,
      form_status: String,
      placeholder: String
    },
    methods: {
      initInput(){
        if(typeof this.input_setting === 'undefined'){
          return false
        }
        this.apiUrl = this.setDefaultValue(this.input_setting['api_url'], null)
        this.apiParameter = this.setDefaultValue(this.input_setting['api_parameter'], { condition: [] })
        if(this.apiParameter && typeof this.apiParameter['condition'] === 'undefined'){
          this.apiParameter['condition'] = {}
        }
        this.apiSearchColumn = this.setDefaultValue(this.input_setting['api_search_column'], null)
        this.apiSearchClause = this.setDefaultValue(this.input_setting['api_search_clause'], 'like')

      },
      onSearch(search, loading){

        if(this.apiUrl){
          loading(true)
          console.log(this.apiParameter)
          let apiParameter = this.cloneObject(this.apiParameter)
          if(this.apiSearchColumn){
            if(this.apiSearchClause === 'like'){
              search = '%' + search + '%'
            }
            apiParameter.condition.push({
              column: this.apiSearchColumn,
              clause: this.apiSearchClause,
              value: search
            })
          }

          this.APIRequest(this.apiUrl, apiParameter, (response) => {
            if(response['data']){
              let options = []
              let columnKey = this.input_setting['api_option_text_column'] ? this.input_setting['api_option_text_column'] : 'description'
              for(let x = 0; x < response['data'].length; x++){
                this.options.push({
                  id: response['data'][x]['id'],
                  label: this.input_setting['api_option_text_function'] ? this.input_setting['api_option_text_function'](response['data'][x]) : response['data'][x][columnKey]
                })
              }
              // this.setOption(options)
            }
            loading(false)
          })
        }else{

        }

      }
    }

  }
</script>
<style scoped>
  .hide{
    display: none
  }
</style>
