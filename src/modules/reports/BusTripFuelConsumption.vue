<template>
  <div>
    <module ref="moduleComponent" v-on:table_filter="tableFilter" :module_name="'Bus Trip Fuel Consumption'" :api="api" :table_setting="table_setting" :form_setting="form_setting" :no_create="true">
      <div slot="beforeTable">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="bus-tab" data-toggle="tab" href="#bus" role="tab" aria-controls="bus" aria-selected="true">Bus Fuel Consumption</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="route-tab" data-toggle="tab" href="#route" role="tab" aria-controls="route" aria-selected="false">Route Fuel Consumption</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="bus" role="tabpanel" aria-labelledby="bus-tab">
            <line-chart :name="'Bus Trip Fuel Consumption'" :data_set="dataSet" :chart_type="'stacked'" :x_data_type="'category'"></line-chart>
          </div>
          <div class="tab-pane" id="route" role="tabpanel" aria-labelledby="route-tab">
            <line-chart :name="'Fuel Consumption per Route'" :data_set="routeDataset" :chart_type="'stacked'" :x_data_type="'category'"></line-chart>
          </div>
        </div>


      </div>
    </module>
  </div>
</template>
<script>
  import Vue from 'vue'
  export default{
    name: '',
    components: {
      'module': require('components/common_module/CommonModule.vue'),
      'line-chart': require('components/chart/LineChart.vue')
    },
    create(){

    },
    mounted(){
    },
    data(){
      let filterSetting = {
        'bus_trip.buses.description': {
          label: 'Bus',
          col: 4,
          label_colspan: 5,
          clause: 'like'
        },
        // 'bus_trip.routes.description': {
        //   label: 'Route',
        //   col: 4,
        //   label_colspan: 5,
        //   clause: 'like'
        // },
        start_date_filter: {
          db_name: 'created_at',
          input_type: 'datetime',
          clause: '>=',
          label: 'Start Date',
          default_value: new Date(this.setDateTime((new Date().getTime() - 2592000000), 0, 0, 0)).toString(),
          input_setting: {
            with_time: true
          }
        },
        end_date_filter: {
          db_name: 'created_at',
          input_type: 'datetime',
          clause: '<=',
          label: 'End Date',
          input_setting: {
            time: '23:59:59'
          }
        }
      }
      let columnSetting = {
        'bus_trip.bus.description': {
          name: 'Bus'
        },
        'bus_trip.route_only.description': {
          name: 'Route',
          sort: null
        },
        total_reading: {
          name: 'Total Reading',
          data_type: 'decimal'
        },
        start_reading: {
          data_type: 'decimal'
        },
        end_reading: {
          data_type: 'decimal'
        }
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting,
        retrieveParameter: {
          with_foreign_table: ['bus_trip'],
          calculated_column: {
            total_total_reading: 'sum(start_reading - end_reading)'
          }
        },
        noClick: true,
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
        api: 'bus_trip_fuel_consumption',
        api_setting: {
        },
        table_setting: tableSetting,
        form_setting: formSetting,
        dataSet: [],
        routeDataset: []
      }
    },
    props: {
    },
    methods: {
      tableFilter: function(requestOption, trigger, filterResponse){
        while(this.dataSet.length > 0) { this.dataSet.pop() }
        if(filterResponse){
          this.dataSet = []
          this.routeDataset = []
          let tableEntries = filterResponse
          let buses = {}
          let routes = {}
          console.log('table', tableEntries)
          for(let x = 0; x < tableEntries.length; x++){
            var busDesciption = tableEntries[x]['bus_trip']['bus']['description']
            var routeDesciption = tableEntries[x]['bus_trip']['route_only']['description']
            if(typeof buses[busDesciption] === 'undefined'){
              buses[busDesciption] = []
            }
            if(typeof routes[routeDesciption] === 'undefined'){
              routes[routeDesciption] = []
            }
            buses[busDesciption].push([tableEntries[x]['created_at'], tableEntries[x]['total_reading']])
            routes[routeDesciption].push([tableEntries[x]['created_at'], tableEntries[x]['total_reading']])
          }
          for(var bus in buses){
            this.dataSet.push({
              name: bus,
              stack: bus,
              data: buses[bus]
            })
          }
          for(var route in routes){
            this.routeDataset.push({
              name: route,
              stack: route,
              data: routes[route]
            })
          }
          console.log(buses)
        }
      }
    }

  }
</script>
<style scoped>

</style>
