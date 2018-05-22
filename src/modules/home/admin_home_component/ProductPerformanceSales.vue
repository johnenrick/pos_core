<template>
  <div>

    <h4>Product and Service Performance (Sales)</h4>
    <div ref="productPerformanceChart" class="w-100" style="height:200px;"></div>
</div>
</template>
<script>
require('../../../assets/js/min/jquery.jqplot.min.js')
require('../../../assets/js/min/jqplot.barRenderer.min.js')
require('../../../assets/js/min/jqplot.categoryAxisRenderer.min.js')
import '../../../assets/style/jquery.jqplot.min.css'
export default {
  mounted() {
    setTimeout(() => {
      this.initGraph()
    }, 500)
  },
  data() {
    return {

    }
  },
  methods: {
    initGraph() {
      let products = [['Quick Clean 18sqm', 5000], ['Quick Clean 30sqm', 6000], ['Deep Clean 36sqm', 7000], ['Deep Clean 80sqm', 2500], ['Vacuum', 6300]]
      let chart = $(this.$refs.productPerformanceChart).jqplot([products], {
        animate: true,
        seriesDefaults: {
          renderer: $.jqplot.BarRenderer,
          rendererOptions: {
            varyBarColor: true
          }
        },
        axes: {
          xaxis: {
            renderer: $.jqplot.CategoryAxisRenderer
          }
        },
        grid: {
          background: 'white',
          shadow: false
        }
      })
    }
  }
}
</script>
<style scoped>
</style>
