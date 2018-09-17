<template>
  <div>
    <module ref="moduleComponent" v-on:table_filter="tableFilter" :module_name="'Daily Sales Report'" :api="api" :api_setting="api_setting" :table_setting="table_setting" :form_setting="form_setting" :no_create="true">
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
    this.addDiscountColumn()
  },
  data(){
    console.log(new Date((new Date().getTime() - 2592000000)).toString())
    let filterSetting = {
      start_date_filter: {
        db_name: 'date',
        input_type: 'date',
        clause: '>=',
        label: 'Start Date',
        default_value: new Date((new Date().getTime() - 2592000000)).toString(),
        input_setting: {
          with_time: true
        }
      },
      end_date_filter: {
        db_name: 'date',
        input_type: 'date',
        clause: '<=',
        label: 'End Date',
        input_setting: {
          time: '23:59:59'
        }
      }
    }
    let columnSetting = {
      date: {
        footer: {
          value: 'TOTAL'
        }
      },
      total_total_amount: {
        name: 'Total Amount',
        data_type: 'decimal',
        footer: {
          total_total_total_amount: {}
        }
      },
      total_payment_adjustment: {
        name: 'Payment Adjustment',
        data_type: 'decimal',
        footer: {
          total_total_payment_adjustment: {}
        }
      },
      total_discount_amount: {
        name: 'Discount Amount',
        data_type: 'decimal',
        footer: {
          total_total_discount_amount: {}
        }
      }
    }
    let tableSetting = {
      filterSetting: filterSetting,
      columnSetting: columnSetting,
      retrieveParameter: {
        calculated_column: {
          total_total_total_amount: 'sum(total_amount)'
        },
        group_by: 'date'
      },
      entryPerPage: null,
      noClick: true
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
      api: 'bus_trip_ticket',
      api_setting: {
        retrieve: 'bus_trip/saleSummary'
      },
      table_setting: tableSetting,
      form_setting: formSetting,
      dataSet: []
    }
  },
  props: {
  },
  methods: {
    addDiscountColumn(){
      this.APIRequest('discount/retrieve', {}, (response) => {

        if(response['data']){
          for(let x = 0; x < response['data'].length; x++){
            // console.log('total_' + this.StringPhraseToUnderscoreCase(response['data'][x]['description']) + '_discount_amount')
            Vue.set(this.table_setting.columnSetting, 'total_' + this.StringPhraseToUnderscoreCase(response['data'][x]['description']) + '_discount_amount', {
              name: response['data'][x]['description'],
              data_type: 'decimal'
            })
          }
          this.$refs.moduleComponent.redrawTable()
        }
      })
    },
    tableFilter: function(requestOption, trigger, filterResponse){
      if(typeof trigger !== undefined && trigger === 'sort'){
        return false
      }
      while(this.dataSet.length > 0) { this.dataSet.pop() }
      if(filterResponse){
        let tableEntries = filterResponse
        for(let x = 0; x < tableEntries.length; x++){
          this.dataSet.push([this.formatDBDate(tableEntries[x]['date'], 'yyyy/mm/dd'), tableEntries[x]['total_total_amount']])
        }

      }
    }
  }

}
</script>
<style scoped>
</style>
