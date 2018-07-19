<template>
  <div>
    <module :api="api" :table_setting="table_setting" :form_setting="form_setting"></module>
  </div>
</template>
<script>
  export default{
    name: '',
    components: {
      'module': require('components/common_module/CommonModule.vue')
    },
    create(){

    },
    mounted(){

    },
    data(){
      let filterSetting = {
        description: {
          label_colspan: 5,
          clause: 'like'
        },
        bus_type_id: {
          input_name: 'Bus Type',
          label_colspan: 5,
          clause: 'like',
          input_type: 'select',
          input_setting: {
            api: 'bus_type/retrieve',
            api_text: 'description',
            default_text: 'All'
          }
        },
        plate_number: {
          label_colspan: 5,
          clause: 'like'
        }
      }
      let columnSetting = {
        description: {},
        'bus_type.description': {
          name: 'Bus Type'
        },
        plate_number: {},
        remarks: {}
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        retrieveParameter: {
          with_foreign_table: ['bus_type']
        }
      }
      let formSetting = {
        inputs: {
          description: {},
          bus_type_id: {
            input_name: 'Bus Type',
            clause: 'like',
            input_type: 'select',
            input_setting: {
              api: 'bus_type/retrieve',
              api_text: 'description',
              default_text: 'Select'
            }
          },
          plate_number: {},
          passenger_capacity: {},
          weight_capacity: {},
          remarks: {}
        }
      }
      return {
        api: 'bus',
        table_setting: tableSetting,
        form_setting: formSetting
      }
    },
    props: {
    },
    methods: {
    }

  }
</script>
<style scoped>

</style>
