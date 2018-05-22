<template>
<chart :options="options" style="width:100%" :auto-resize="true"></chart>
</template>
<script>
import ECharts from 'vue-echarts/components/ECharts'
import 'echarts/lib/chart/bar'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/polar'
export default {
  name: 'BarChart',
  components: {
    'chart': ECharts
  },
  props: {
    data_set: Array
  },
  data: function () {
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
          name: 'Quantity Sold',
          nameLocation: 'center',
          nameTextStyle: {
            fontStyle: 'bold'
          },
          nameGap: 40,
          type: 'value'
        },
        series: [{
          data: this.data_set,
          type: 'bar',
          lineStyle: {
            width: 4
          }
          // itemStyle: {
          //   color: [ '#c23531', '#2f4554', '#61a0a8', '#d48265', '#91c7ae', '#749f83', '#ca8622', '#bda29a', '#6e7074', '#546570', '#c4ccd3' ]
          // }
        }]
      }
    }
  }
}
</script>
<style>
.echarts {
  height: 300px;
}
</style>
