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
        'bus.description': {
          label_colspan: 5
        },
        'route_id': {
          label_colspan: 5
        },
        'driver_account_id': {
          label_colspan: 5,
          input_type: 'select',
          input_setting: {
            default_text: 'Any',
            api: 'account/retrieve',
            api_option_text_function: (data) => {
              console.log(data)
              return data['account_information']['first_name'] + ' ' + data['account_information']['last_name']
            },
            api_parameter: {
              with_foreign_table: ['account_information'],
              condition: [{
                column: 'account_type_id',
                value: 3
              }]
            }
          }
        },
        'active': {
          db_name: 'arrival_datetime',
          label_colspan: 5,
          input_type: 'select',
          default: null,
          input_setting: {
            options: [
              {id: null, text: 'All'},
              {id: 'NULL', text: 'Active'}
            ]
          }
        }
      }
      let columnSetting = {
        'bus.description': {
          name: 'Bus Description'
        },
        'bus.plate_number': {
          name: 'Plate Number'
        },
        'route.description': {
          name: 'Route'
        },
        'driver_name': {
          sort: null,
          value_function: (entry) => {
            console.log(entry['driver'])
            return entry['driver'] ? entry['driver']['account_information']['first_name'] + ' ' + entry['driver']['account_information']['last_name'] : 'None'
          }
        },
        created_at: {
          name: 'Time Started'
        },
        'arrival_datetime': {
          name: 'Time Arrived'
        },
        travel_time: {
          data_type: 'html',
          tool_tip: 'heelo',
          sort: false,
          value_function: (row) => {
            let baseTime = row['arrival_datetime'] ? (new Date(row['arrival_datetime'])).getTime() : (new Date()).getTime()
            let duration = Math.floor((baseTime - (new Date(row['created_at'])).getTime()) / 1000 / 60) // Subtract current time with create at then convert it to minutes
            return '<span class="' + ((duration > row['route']['estimated_travel_duration'] * 1) ? 'text-danger' : '') + '">' + duration + ' minutes ' + '</span>'
          }
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        retrieveParameter: {
          with_foreign_table: ['bus', 'route', 'driver'],
          sort: {
            arrival_datetime: 'DESC'
          }
        }
      }
      let formSetting = {
        inputs: {
          bus_id: {
            input_name: 'Bus',
            input_type: 'select',
            input_setting: {
              api: 'bus/retrieve',
              default_value: null,
              default_text: 'Select Bus'
            }
          },
          driver_account_id: {
            input_name: 'Driver',
            input_type: 'select',
            input_setting: {
              api: 'account_information/retrieve',
              api_parameter: {
                with_foreign_table: ['account'],
                condition: [{
                  column: 'account.account_type_id',
                  value: 3
                }]
              },
              api_option_text_function: (entry) => {
                return entry['first_name'] + ' ' + entry['last_name']
              },
              default_value: null,
              default_text: 'Select Driver'
            }
          },
          route_id: {
            input_name: 'Route',
            input_type: 'select',
            input_setting: {
              api: 'route/retrieve',
              default_value: null,
              default_text: 'Select Route'
            }
          },
          arrival_datetime: {
            input_type: 'date'
          }
        }
      }
      return {
        api: 'bus_trip',
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
