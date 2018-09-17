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
        group_by: ['route', 'date'],
        collect_result: 'route_id',
        condition: [{
          column: 'bus_trips.created_at',
          clause: '>=',
          value: this.DBDateFormat(new Date((new Date()).getFullYear(), 0, 1, 0, 0, 0))
        }]
      }
      this.APIRequest('bus_trip/saleSummary', param, (response) => {
        console.log('route_performance', response['data'])
        if(response['data']){
          let tableEntries = response['data']
          for(let x in tableEntries){
            let routeEntries = []
            for(let y = 0; y < tableEntries[x].length; y++){
              routeEntries.push([this.formatDBDate(tableEntries[x][y]['date'], 'yyyy/mm/dd'), tableEntries[x][y]['total_total_amount']])
            }
            let routeDescription = tableEntries[x][0]['route_description'] ? tableEntries[x][0]['route_description'] : 'Others'
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
