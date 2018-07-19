<template>
  <div>
    <bar-chart :name="'Route Sales Summary'" :data_set="dataSet":chart_type="'multiple'"></bar-chart>
  </div>
</template>
<script>
export default {
  components: {
    'bar-chart': require('../../../components/chart/BarChart.vue')
  },
  mounted() {
    this.generateTable()
  },
  data() {
    return {
      dataSet: [[], []]
    }
  },
  props: {
    is_top: Boolean
  },
  methods: {
    generateTable: function(){
      let requestOption = {
        sort: {
          total_net_amount: this.is_top ? 'ASC' : 'DESC'
        },
        limit: '5'
      }
      while(this.dataSet.length > 0) { this.dataSet.pop() }
      this.APIRequest('bus_trip/routeSalesSummary', requestOption, (response) => {
        if(response['data']){
          let tableEntries = response['data']
          let amountSet = []
          let passengerCountSet = []
          for(let x = 0; x < tableEntries.length; x++){
            let description = tableEntries[x]['route'] ? (tableEntries[x]['route']['description']).replace('via', '\nvia') : 'Others'
            amountSet.push([description, tableEntries[x]['total_net_amount']])
            passengerCountSet.push([description, tableEntries[x]['total_passenger_quantity']])
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
