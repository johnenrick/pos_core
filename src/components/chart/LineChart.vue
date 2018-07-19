<template>
  <div>
    <chart ref="chart" :options="options" style="width:100%;height:400px" :auto-resize="true"></chart>
  </div>
</template>
<script>
import ECharts from 'vue-echarts/components/ECharts'
import 'echarts/lib/chart/line'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/polar'
import 'echarts/lib/component/legend'

import Vue from 'vue'
export default {
  name: 'linearChart',
  components: {
    'chart': ECharts
  },
  props: {
    data_set: Array,
    chart_type: {
      type: String,
      default: 'normal' // normal, multiple
    },
    name: String
  },
  data: function () {
    return {
      options: {
        symbol: 'circle',
        title: {
          text: 'Test'
        },
        grid: {
          show: true,
          borderWidth: 3,
          containLabel: true,
          bottom: '3%'
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross'
          }
        },
        legend: {
        },
        xAxis: {
          name: 'Date',
          nameLocation: 'center',
          nameTextStyle: {
            fontStyle: 'bold'
          },
          nameGap: 40,
          type: 'time'
        },
        yAxis: {
          name: this.name,
          nameLocation: 'middle',
          nameTextStyle: {
            fontStyle: 'bold'
          },
          nameGap: 40,
          axisLabel: {
            show: true
          },
          type: 'value'
        },
        series: []
      }
    }
  },
  mounted(){
    setTimeout(() => {
      $(this.$refs.chart).resize()
    }, 1500)
  },
  watch: {
    data_set(newValue){
      let seriesData = []
      if(this.chart_type === 'normal'){
        let dataSet = {
          type: 'line',
          lineStyle: {
            width: 4
          },
          data: this.data_set
        }
        seriesData.push(dataSet)
      }else if(this.chart_type === 'stacked'){
        let legends = []
        for(let x = 0; x < this.data_set.length; x++){
          let dataSet = this.data_set[x]
          dataSet['type'] = 'line'
          dataSet['lineStyle'] = {
            width: 4
          }
          seriesData.push(dataSet)
          legends.push(this.data_set[x]['name'])
        }
        // Vue.set(this.options, 'legend', legends)
      }
      Vue.set(this.options, 'series', seriesData)
    }
  }

}
</script>
<style>
.echarts {
  height: 3000px;
}
</style>
