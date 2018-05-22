<template>
  <div>
    <module v-on:table_filter="tableFilter" :no_create="true" :module_name="'Daily Sales Report'" :api="api" :api_setting="api_setting" :table_setting="table_setting" :form_setting="form_setting">
      <div slot="beforeTable">
        <line-chart :data_set="dataSet"></line-chart>
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
      start_date_filter: {
        db_name: 'created_at',
        input_type: 'date',
        clause: '>=',
        label: 'Start Date',
        input_setting: {
          with_time: true
        }
      },
      end_date_filter: {
        db_name: 'created_at',
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
      date: {
      },
      total_price: {
        data_type: 'decimal'
      }
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
      api: 'order',
      api_setting: {
        retrieve: 'order/dailySalesReport'
      },
      table_setting: tableSetting,
      form_setting: formSetting,
      dataSet: []
    }
  },
  props: {
  },
  methods: {
    tableFilter: function(requestOption){
      while(this.dataSet.length > 0) { this.dataSet.pop() }
      this.APIRequest('order/dailySalesReport', requestOption, (response) => {
        if(response['data']){
          let tableEntries = response['data']
          for(let x = 0; x < tableEntries.length; x++){
            this.dataSet.push([this.formatDBDate(tableEntries[x]['date'], 'yyyy/mm/dd'), tableEntries[x]['total_price']])
          }
        }
        console.log(this.dataSet)
      })
    }
  }

}
</script>
<style scoped>
</style>
