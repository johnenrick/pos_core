<template>
  <div>
    <div class="card border-info">
      <div class="card-header bg-info text-white  font-weight-bold">YEARLY SALES <span v-if="isLoading" class="float-right"><i class="fas fa-circle-notch fa-spin"></i> Loading Data...</span></div>
      <div class="card-body">
        <line-chart :data_set="dataSet" :chart_type="'stacked'" :x_data_type="'category'"></line-chart>
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
        group_by: ['monthly', 'yearly'],
        collect_result: 'date_year',
        condition: [{
          column: 'date_year',
          clause: '<=',
          value: (new Date()).getFullYear()
        }]
      }
      this.APIRequest('bus_trip/saleSummary', param, (response) => {
        console.log('yearly summary', response['data'])
        if(response['data']){
          let tableEntries = response['data']
          for(let x in tableEntries){
            let yearlyEntries = []
            for(let y = 0; y < tableEntries[x].length; y++){
              yearlyEntries.push([this.monthWord(tableEntries[x][y]['date_month'] - 1, true), tableEntries[x][y]['total_total_amount'] * 1])
            }

            this.dataSet.push({
              name: x,
              stack: x,
              data: yearlyEntries
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
