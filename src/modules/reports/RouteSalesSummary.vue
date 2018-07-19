<template>
  <div>
    <module v-on:table_filter="tableFilter" :module_name="'Route Sales Summary'" :api="api" :api_setting="api_setting" :table_setting="table_setting" :form_setting="form_setting">
      <div slot="beforeTable">
        <horizontal-bar-chart :name="'Route Sales Summary'" :data_set="dataSet"></horizontal-bar-chart>
      </div>
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
          db_name: 'route.description',
          col: 4,
          label_colspan: 5,
          clause: 'like'
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
          name: 'Description',
          db_name: 'route.description'
        },
        total_net_amount: {
          data_type: 'decimal'
        },
        'created_at': {}
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting
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
          retrieve: 'bus_trip/routeSalesSummary'
        },
        table_setting: tableSetting,
        form_setting: formSetting,
        dataSet: [[]]
      }
    },
    props: {
    },
    methods: {
      tableFilter: function(requestOption){
        while(this.dataSet.length > 0) { this.dataSet.pop() }
        this.APIRequest('bus_trip/routeSalesSummary', requestOption, (response) => {
          if(response['data']){
            let tableEntries = response['data']
            let amountSet = []
            let passengerCountSet = []
            for(let x = 0; x < tableEntries.length; x++){
              let description = tableEntries[x]['route'] ? tableEntries[x]['route']['description'] : 'Others'
              amountSet.push([tableEntries[x]['total_net_amount'], description])
              passengerCountSet.push([tableEntries[x]['total_passenger_quantity'], description])
            }
            this.dataSet.push(amountSet)
            this.dataSet.push(passengerCountSet)
          }
        })
      }
    }

  }
</script>
<style scoped>

</style>
