<template>
  <div>
    <h2>Yearly Sales</h2>
    <line-chart :data_set="dataSet" :chart_type="'stacked'"></line-chart>
  </div>
</template>
<script>
export default {
  components: {
    'line-chart': require('components/chart/LineChart.vue')
  },
  mounted() {
    setTimeout(() => {
      this.initGraph()
    }, 500)
  },
  data() {
    return {
      dataSet: []
    }
  },
  methods: {
    initGraph() {
      while(this.dataSet.length > 0) { this.dataSet.pop() }
      this.APIRequest('bus_trip/routeDailySales', {}, (response) => {
        if(response['data']){
          let tableEntries = response['data']
          for(let x in tableEntries){
            let routeEntries = []
            for(let y = 0; y < tableEntries[x].length; y++){
              routeEntries.push([this.formatDBDate(tableEntries[x][y]['date'], 'yyyy/mm/dd'), tableEntries[x][y]['total_payment']])
            }
            this.dataSet.push({
              name: tableEntries[x][0]['route']['description'],
              stack: tableEntries[x][0]['route']['description'],
              data: routeEntries
            })
          }
        }
      })
    }
  }
}
</script>
<style scoped>
</style>
