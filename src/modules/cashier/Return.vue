<template>
  <div>
    <button @click="openReturnModal" class="btn btn-warning btn-block text-white font-weight-bold btn-block btn-lg" >Return <small class="font-italic font-weight-bold">(Alt+R)</small></button>
    <div class="modal fade" id="checkOutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default{
  props: {
    order_list: Array
  },
  data(){
    return {
    }
  },
  methods: {
    openReturnModal(){
    }
  }
}
</script>
<style>

</style>
