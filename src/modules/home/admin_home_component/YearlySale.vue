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
      this.APIRequest('bus_trip/saleSummary', {group_by: ['monthly', 'yearly'], collect_result: 'date_year'}, (response) => {
        if(response['data']){
          let tableEntries = response['data']
          for(let x in tableEntries){
            let yearlyEntries = []
            for(let y = 0; y < tableEntries[x].length; y++){
              yearlyEntries.push([tableEntries[x][y]['date_month'], tableEntries[x][y]['total_total_amount'] * 1])
            }

            this.dataSet.push({
              name: x,
              stack: x,
              data: yearlyEntries
            })
          }
          console.log(this.dataSet)
        }
      })
    }
  }
}
</script>
<style scoped>
</style>
