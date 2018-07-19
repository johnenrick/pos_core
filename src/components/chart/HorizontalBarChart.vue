<template>
<chart ref="chart" :options="options" style="width:100%;height:400px" :auto-resize="true"></chart>
</template>
<script>
import ECharts from 'vue-echarts/components/ECharts'
import 'echarts/lib/chart/bar'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/polar'
import Vue from 'vue'
export default {
  name: 'BarChart',
  components: {
    'chart': ECharts
  },
  mounted(){
    setTimeout(() => {
      $(this.$refs.chart).resize()
    }, 1500)
  },
  props: {
    data_set: Array,
    name: String
  },
  data: function () {
    return {
      options: {
        grid: {
          show: true,
          borderWidth: 3,
          left: '20%'
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross'
          }
        },
        yAxis: {
          type: 'category',
          axisTick: {
            alignWithLabel: true
          }
        },
        xAxis: {
          name: this.name,
          nameLocation: 'center',
          nameTextStyle: {
            fontStyle: 'bold'
          },
          nameGap: 40,
          type: 'value'
        },
        series: []
      }
    }
  },
  watch: {
    data_set(newValue){
      let seriesData = []
      for(let x = 0; x < this.data_set.length; x++){
        let dataSet = {
          type: 'bar',
          lineStyle: {
            width: 2
          },
          data: this.data_set[x]
        }
        seriesData.push(dataSet)
      }
      Vue.set(this.options, 'series', seriesData)
    }
  }
}
</script>
<style>
.echarts {
  height: 300px;
}
</style>
