<template>
  <div>
    <module ref="moduleComponent" v-on:table_filter="tableFilter" :module_name="'Route Sales Summary'" :api="api" :api_setting="api_setting" :table_setting="table_setting" :form_setting="form_setting" :no_create="true">
      <div slot="beforeTable">
        <horizontal-bar-chart :name="'Route Sales Summary'" :data_set="dataSet"></horizontal-bar-chart>
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
      'horizontal-bar-chart': require('components/chart/HorizontalBarChart.vue')
    },
    create(){

    },
    mounted(){
      this.addDiscountColumn()
    },
    data(){
      let filterSetting = {
        'route.description': {
          db_name: 'route.description',
          col: 4,
          label_colspan: 5,
          clause: 'like'
        },
        start_date_filter: {
          db_name: 'bus_trip_ticket.created_at',
          input_type: 'datetime',
          clause: '>=',
          label: 'Start Date',
          default_value: new Date(this.setDateTime((new Date().getTime() - 2592000000), 0, 0, 0)).toString(),
          input_setting: {
            with_time: true
          }
        },
        end_date_filter: {
          db_name: 'bus_trip_ticket.created_at',
          input_type: 'datetime',
          clause: '<=',
          label: 'End Date',
          input_setting: {
            time: '23:59:59'
          }
        }
      }
      let columnSetting = {
        route_description: {
          name: 'route'
        },
        total_total_amount: {
          name: 'Total Amount',
          data_type: 'decimal'
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
          group_by: 'route'
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
        api: 'bus_trip',
        api_setting: {
          retrieve: 'bus_trip/saleSummary'
        },
        table_setting: tableSetting,
        form_setting: formSetting,
        dataSet: [[]]
      }
    },
    props: {
    },
    methods: {
      addDiscountColumn(){
        this.APIRequest('discount/retrieve', {}, (response) => {
          if(response['data']){
            for(let x = 0; x < response['data'].length; x++){
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
        while(this.dataSet.length > 0) { this.dataSet.pop() }
        if(filterResponse){
          let tableEntries = filterResponse
          let amountSet = []
          let passengerCountSet = []
          for(let x = 0; x < tableEntries.length; x++){
            let description = tableEntries[x]['route_description'] ? tableEntries[x]['route_description'] : 'Others'
            description = (description.replace('via', '\nvia')).replace('Via', '\n via')
            amountSet.push([tableEntries[x]['total_total_amount'], description])
            passengerCountSet.push([tableEntries[x]['total_passenger_quantity'], description])
          }
          this.dataSet.push(amountSet)
          this.dataSet.push(passengerCountSet)
        }
      }
    }

  }
</script>
<style scoped>

</style>
