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
        bus_trip_ticket_id: {
          label_colspan: 5
        }
      }
      let columnSetting = {
        bus_trip_ticket_id: {
        },
        account_id: {
          value_function: (entry) => {
            return (entry['account_information']) ? entry['account_information']['first_name'] + ' ' + entry['account_information']['last_name'] : 'None'
          }
        },
        remarks: {},
        is_approved: {
          data_type: 'boolean'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        retrieveParameter: {
          with_foreign_table: ['account_information']
        }
      }
      let formSetting = {
        inputs: {
          bus_trip_ticket_id: {
            input_type: 'select',
            input_setting: {
              api: 'bus_trip_ticket/retrieve',
              api_parameter: {
                with_soft_delete: true
              },
              api_option_text_column: 'id',
              default_text: 'Select Bus Trip'
            }
          },
          remarks: {},
          is_approved: {
            input_type: 'select',
            default_value: 0,
            input_setting: {
              options: [{
                id: '0',
                text: 'Pending'
              }, {
                id: '1',
                text: 'Approved'
              }, {
                id: '2',
                text: 'Disapproved'
              }]
            }
          }
        }
      }
      return {
        api: 'void_bus_trip_ticket',
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
