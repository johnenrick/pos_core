<template>
  <div>
    <h2>Yearly Sales</h2>
    <div ref="chartdiv" class="w-100" style="height:250px;width:100%"></div>
  </div>
</template>
<script>
require('../../../assets/js/min/jquery.jqplot.min.js')
require('../../../assets/style/jquery.jqplot.min.css')
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
      let overAll = [[2010, 100000], [2011, 200000], [2012, 150000], [2013, 190000], [2014, 90000], [2015, 130000], [2016, 170000], [2017, 180000], [2018, 50000]]
      let service = [[2010, 60000], [2011, 100000], [2012, 50000], [2013, 140000], [2014, 30000], [2015, 30000], [2016, 100000], [2017, 80000], [2018, 30000]]
      let product = [[2010, 40000], [2011, 100000], [2012, 100000], [2013, 50000], [2014, 60000], [2015, 100000], [2016, 70000], [2017, 100000], [2018, 20000]]
      let chart = $(this.$refs.chartdiv).jqplot('chartdiv', [overAll, service, product], {
        // Turns on animatino for all series in this plot.
        animate: true,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,
        cursor: {
          show: true,
          zoom: true,
          looseZoom: true,
          showTooltip: false
        },
        axes: {

          xaxis: {
            padMin: 0,
            numberTicks: 10,
            drawMajorGridlines: true,
            drawMinorGridlines: true,
            drawMajorTickMarks: false,
            rendererOptions: {
              tickInset: 0.5,
              minorTicks: 1
            }
          },
          yaxis: {

            tickOptions: {
              formatString: "PhP %'d"
            }
          },
          y2axis: {
            tickOptions: {
              formatString: "PhP %'d"
            },
            rendererOptions: {
              // align the ticks on the y2 axis with the y axis.
              alignTicks: true,
              forceTickAt0: true
            }
          }
        },
        grid: {
          background: 'white',
          shadow: false
        },
        legend: {
          labels: ['Over All Sales', 'Service Sales', 'Product Sales'],
          show: true
        }
      })
    }
  }
}
</script>
<style scoped>
</style>
