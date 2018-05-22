<template>
<chart :options="options" style="width:100%" :auto-resize="true"></chart>
</template>
<script>
import ECharts from 'vue-echarts/components/ECharts'
import 'echarts/lib/chart/line'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/polar'
export default {
  name: 'linearChart',
  components: {
    'chart': ECharts
  },
  props: {
    data_set: Array
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
          borderWidth: 3
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross'
          }
        },
        xAxis: {
          name: 'TOTAL SALE',
          nameLocation: 'center',
          nameTextStyle: {
            fontStyle: 'bold'
          },
          nameGap: 40,
          type: 'time'
        },
        yAxis: {
          name: 'DATE',
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
        series: [{
          data: this.data_set,
          type: 'line',
          lineStyle: {
            width: 4
          }
        }]
      }
    }
  }
}
</script>
<style>
.echarts {
  height: 3000px;
}
</style>
