<template>
  <div class="row row-eq-heights">
    <div class="col-sm-6 col-lg-3 mb-3">
      <div class="card text-white bg-success mb-3 text-center h-100" >
        <div class="card-body">
          <i class="fas fa-bus static-left" style="font-size: 48px;"></i>
          <span class="float-right text-right"><p class="h2 summary-text">900.00M</p> <small >Active Trips</small></span>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
      <div class="card text-white bg-warning mb-3 text-center h-100" >
        <div class="card-body ">
          <i class="fas fa-clipboard-list static-left" style="font-size: 48px;"></i>
          <span class="float-right text-right"><p class="h2 summary-text">900.00M</p> <small >Collected</small></span>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
      <div class="card text-white bg-danger mb-3 text-center h-100" >
        <div class="card-body">
          <i class="fas fa-ban static-left" style="font-size: 48px;"></i>
          <span class="float-right text-right"><p class="h2 summary-text">900.00M</p> <small >Void Request</small></span>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
      <div class="card text-white bg-info mb-3 text-center h-100" >
        <div class="card-body">
          <i class="fas fa-male static-left" style="font-size: 48px;"></i>
          <span class="float-right text-right"><p class="h2 summary-text">900.00M</p> <small >Passengers</small></span>
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
<style>
 .static-left{
   position: absolute;
   left: 20px;
   top: 20px;
 }
 .summary-text{
   line-height: 0.7em;
 }
</style>
