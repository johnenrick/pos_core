<template>
  <div>
    <div class="card border-success mb-3">
      <div class="card-header text-white bg-success  font-weight-bold">
        Summary
      </div>
      <div class="card-body ">

        <div class="form-group row border border-success">
          <label class="col-sm-6 col-form-label font-weight-bold">Pending Transaction</label>
          <div class="col-sm-6">
            <label class="col-form-label float-right">20 Transactions</label>
          </div>
        </div>
        <div class="form-group row border border-success">
          <label class="col-sm-6 col-form-label font-weight-bold">Total Transactions</label>
          <div class="col-sm-6">
            <label class="col-form-label float-right">50 Transactions</label>
          </div>
        </div>
        <div class="form-group row border border-success">
          <label class="col-sm-6 col-form-label font-weight-bold">Ave. Transaction Per Day</label>
          <div class="col-sm-6">
            <label class="col-form-label float-right">20 Transactions</label>
          </div>
        </div>
        <div class="form-group row border border-success">
          <label class="col-sm-6 col-form-label font-weight-bold">Average Daily Sales</label>
          <div class="col-sm-6">
            <label class="col-form-label float-right">20 Transactions</label>
          </div>
        </div>
        <div class="form-group row border border-success">
          <label class="col-sm-6 col-form-label font-weight-bold">Ave. Transaction Per Day</label>
          <div class="col-sm-6">
            <label class="col-form-label float-right">PhP 30,000.00</label>
          </div>
        </div>
        <div class="form-group row border border-success">
          <label class="col-sm-6 col-form-label font-weight-bold">Current Year Sales</label>
          <div class="col-sm-6">
            <label class="col-form-label float-right">PhP 300,000.00</label>
          </div>
        </div>
        <div class="form-group row border border-success">
          <label class="col-sm-6 col-form-label font-weight-bold">Top Product</label>
          <div class="col-sm-6">
            <label class="col-form-label float-right">Vacuum Cleaner</label>
          </div>
        </div>
        <div class="form-group row border border-success">
          <label class="col-sm-6 col-form-label font-weight-bold">Top Service</label>
          <div class="col-sm-6">
            <label class="col-form-label float-right">Deep Clean 36sqm</label>
          </div>
        </div>




      </div>
    </div>
  </div>
</template>
<script>
export default{
  mounted(){
  },
  data(){
    return {
      lowProductQuantityList: []
    }
  }

}
</script>
