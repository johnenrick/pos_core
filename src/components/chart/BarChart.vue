<template>
  <div>
  <chart :options="options" style="width:100%" :auto-resize="true"></chart>

  </div>
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
    name: String,
    chart_type: {
      type: String,
      default: 'normal' // normal, multiple
    }
  },
  data: function () {
    console.log(this.get_theme_color_palette_list())
    return {
      options: {
        grid: {
          show: true,
          borderWidth: 3
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross'
          }
        },
        xAxis: {
          type: 'category',
          axisTick: {
            alignWithLabel: true
          }
        },
        yAxis: {
          // name: this.name,
          nameLocation: 'top',
          nameTextStyle: {
            fontStyle: 'bold'
          },
          type: 'value'
        },
        series: [],
        color: this.get_theme_color_palette_list()
      }
    }
  },
  watch: {
    data_set(newValue){
      let seriesData = []
      if(this.chart_type === 'normal'){
        let dataSet = {
          type: 'bar',
          lineStyle: {
            width: 4
          },
          data: this.data_set
        }
        seriesData.push(dataSet)
      }else if(this.chart_type === 'multiple'){
        for(let x = 0; x < this.data_set.length; x++){
          let dataSet = {
            type: 'bar',
            lineStyle: {
              width: 4
            },
            data: this.data_set[x]
          }
          seriesData.push(dataSet)
        }
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
