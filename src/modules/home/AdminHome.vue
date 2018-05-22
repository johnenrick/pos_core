<template>
  <div>
    <h1>Admin Dashboard</h1>
    <div class="row">
      <div class="col-12 col-xl-4">
        <summary-report></summary-report>
      </div>
      <div class="col-12 col-xl-8 mb-3">
        <div class="card border-primary">
          <div class="card-header bg-primary text-white font-weight-bold">Product and Service Performance</div>
          <div class="card-body">
            <product-performance-quantity></product-performance-quantity>
            <product-performance-sales></product-performance-sales>
          </div>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="card border-info">
          <div class="card-header bg-info text-white  font-weight-bold">Yearly Sales</div>
          <div class="card-body">
            <yearly-sales></yearly-sales>
          </div>
        </div>
      </div>
    </div>
</div>
</template>
<script>
export default {
  components: {
    'summary-report': require('./admin_home_component/Summary.vue'),
    'yearly-sales': require('./admin_home_component/YearlySales.vue'),
    'product-performance-quantity': require('./admin_home_component/ProductPerformanceQuantity.vue'),
    'product-performance-sales': require('./admin_home_component/ProductPerformanceSales.vue')
  },
  mounted() {

    this.initDummy()
  },
  data() {
    return {

    }
  },
  methods: {
    initDummy() {

    }
  }
}
</script>
<style scoped>
.table-large td {
  padding: 5px
}
</style>
