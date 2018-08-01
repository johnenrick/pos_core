<template>
  <div>
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
      let param = {
        condition: [{
          column: 'date',
          clause: '>=',
          value: this.DBDateFormat(new Date((new Date()).getFullYear(), 0, 1, 0, 0, 0))
        }]
      }
      console.log(param)
      this.APIRequest('bus_trip/routeDailySales', param, (response) => {
        if(response['data']){
          let tableEntries = response['data']
          for(let x in tableEntries){
            let routeEntries = []
            for(let y = 0; y < tableEntries[x].length; y++){
              routeEntries.push([this.formatDBDate(tableEntries[x][y]['date'], 'yyyy/mm/dd'), tableEntries[x][y]['total_payment']])
            }
            let routeDescription = tableEntries[x][0]['description'] ? tableEntries[x][0]['description'] : 'Others'
            this.dataSet.push({
              name: routeDescription,
              stack: routeDescription,
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
