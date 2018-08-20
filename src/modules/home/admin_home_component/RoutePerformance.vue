<template>
  <div>
    <div class="card border-primary">
      <div class="card-header bg-primary text-white font-weight-bold">ROUTE PERFORMANCE <span v-if="isLoading" class="float-right"><i class="fas fa-circle-notch fa-spin"></i> Loading Data...</span> <small v-if="dataSet.length === 0 && !isLoading" class="float-right"><i class="fas fa-exclamation-circle"></i> No Data Retrieved</small></div>
      <div class="card-body">
        <line-chart :data_set="dataSet" :chart_type="'stacked'"></line-chart>
      </div>
    </div>
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
      dataSet: [],
      isLoading: true
    }
  },
  methods: {
    initGraph() {
      this.isLoading = true
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
        this.isLoading = false
      })
    }
  }
}
</script>
<style scoped>
</style>
