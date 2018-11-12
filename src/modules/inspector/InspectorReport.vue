<template>
  <div>
    <module :api="api" :table_setting="table_setting" :form_setting="form_setting" :no_create="true"></module>
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
        'bus_trip.buses.description': {
          clause: 'like',
          label_colspan: 5
        },
        'account_id': {
          label: 'Inspector',
          label_colspan: 5,
          input_type: 'select',
          input_setting: {
            default_text: 'Any',
            api: 'account/retrieve',
            api_option_text_function: (data) => {
              return data['account_information']['first_name'] + ' ' + data['account_information']['last_name']
            },
            api_parameter: {
              with_foreign_table: ['account_information'],
              sort_by: {'account_information.first_name': 'ASC'},
              condition: [{
                column: 'account_type_id',
                value: 8
              }]
            }
          }
        },
        created_at: {
          input_type: 'date'
        }
      }
      let columnSetting = {
        'bus_trip.bus.description': {
          name: 'Bus Description'
        },
        'inspector': {
          sort: null,
          value_function: (entry) => {
            console.log(entry)
            return entry['account'] ? entry['account']['account_information']['first_name'] + ' ' + entry['account']['account_information']['last_name'] : 'None'
          }
        },
        'conductor_name': {

          value_function: (entry) => {
            return entry['bus_trip']['conductor'] ? entry['bus_trip']['conductor']['account_information']['first_name'] + ' ' + entry['bus_trip']['conductor']['account_information']['last_name'] : 'None'
          }
        },
        'passenger_count': {
          data_type: 'number',
          column_name: 'Manual Count'
        },
        system_passenger_count: {
          sort: null,
          data_type: 'html',
          value_function: (entry) => {
            console.log(entry)
            var systemCount = entry['system_passenger_count'].length ? entry['system_passenger_count'][0]['count'] * 1 : 0
            var passengerCount = entry['passenger_count'] * 1
            console.log(systemCount)
            var textClass = ''
            if(systemCount > passengerCount){
              textClass = 'text-danger'
            }else if(systemCount < passengerCount){
              textClass = 'text-warning'
            }
            return '<span class="' + textClass + ' float-right">' + systemCount + '</span>'
          }
        },
        created_at: {
          name: 'Time Started'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        retrieveParameter: {
          with_foreign_table: ['bus_trip', 'account', 'driver', 'system_passenger_count'],
          sort: {
            arrival_datetime: 'DESC'
          }
        }
      }
      let formSetting = {
        inputs: {
          bus_id: {
            input_name: 'Bus'
          }
          // driver_account_id: {
          //   input_name: 'Driver',
          //   input_type: 'select',
          //   input_setting: {
          //     api: 'account_information/retrieve',
          //     api_parameter: {
          //       with_foreign_table: ['account'],
          //       condition: [{
          //         column: 'account.account_type_id',
          //         value: 3
          //       }]
          //     },
          //     api_option_text_function: (entry) => {
          //       return entry['first_name'] + ' ' + entry['last_name']
          //     },
          //     default_value: null,
          //     default_text: 'Select Driver'
          //   }
          // },
          // inspector_id: {
          //   input_name: 'Route',
          //   input_type: 'select',
          //   input_setting: {
          //     api: 'inspector/retrieve',
          //     default_value: null,
          //     default_text: 'Select Route'
          //   }
          // },
          // arrival_datetime: {
          //   input_type: 'date'
          // }
        }
      }
      return {
        api: 'inspector_report',
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
