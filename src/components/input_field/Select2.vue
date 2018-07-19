<template>
  <div>
    <div v-bind:class="form_status === 'view' ? 'hide' :''">
      <select ref="select" style="width:100%"

        v-bind:name="db_name"
      >
      </select>
    </div>
    <span v-if="form_status === 'view'" class="form-control">hey</span>
  </div>
</template>
<script>
  export default{
    name: '',
    create(){

    },
    mounted(){
      this.initInput()
    },
    data(){
      return {
        value: null,
        options: {
          results: []
        }
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
        let vm = this
        // let placeholder = (this.placeholder) ? this.placeholder : 'Select ' +
        $(this.$refs.select).select2({
          minimumInputLength: 3,
          placeholder: 'Select',
          ajax: {
            method: 'POST',
            url: this.input_setting['url'],
            // dataType: 'json',
            data: (query) => {
              return {
                condition: [
                  {
                    column: this.input_setting['query_column'],
                    clause: 'like',
                    value: '%' + query.term + '%'
                  }
                ]
              }
            },
            processResults: (response) => {
              let results = []
              if(response['data']){
                results = this.input_setting['query_callback'](response['data'])
              }
              return {
                results: results
              }
            }
          }
        })
        .on('change', function(event){
          vm.value = this.value
          vm.$emit('change', this.field_name, this.value)
        })
      }
    }

  }
</script>
<style scoped>
  .hide{
    display: none
  }
</style>
