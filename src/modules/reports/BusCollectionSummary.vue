<template>
  <div>
    <module :module_name="'Bus Collection Summary'" :api="api" :api_setting="api_setting" :table_setting="table_setting" :form_setting="form_setting">
    </module>
  </div>
</template>
<script>
  export default{
    name: '',
    components: {
      'module': require('components/common_module/CommonModule.vue'),
      'horizontal-bar-chart': require('components/chart/HorizontalBarChart.vue')
    },
    create(){

    },
    mounted(){

    },
    data(){
      let filterSetting = {
        description: {
          db_name: 'bus.description',
          col: 4,
          label_colspan: 5,
          clause: 'like',
          input_type: 'select',
          input_setting: {
            api: 'bus/retrieve',
            default_text: 'All'
          }
        },
        start_date_filter: {
          db_name: 'bus_trip_ticket.created_at',
          input_type: 'date',
          clause: '>=',
          label: 'Start Date',
          input_setting: {
            with_time: true
          }
        },
        end_date_filter: {
          db_name: 'bus_trip_ticket.created_at',
          input_type: 'date',
          clause: '<',
          label: 'End Date',
          input_setting: {
            time_setting: {
              default_time: '23:59:59'
            }
          }
        }
      }
      let columnSetting = {
        description: {
          name: 'Bus',
          db_name: 'bus.description'
        },
        total_amount: {
          data_type: 'decimal'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        entryPerPage: 0
      }
      let formSetting = {
        inputs: {
          description: {},
          short_name: {},
          price: {
            input_type: 'number',
            placeholder: '0.00'
          }
        }
      }
      return {
        api: 'bus_trip',
        api_setting: {
          retrieve: 'bus_trip/busColectionSummary'
        },
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
