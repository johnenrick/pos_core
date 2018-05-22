<template>
  <div>
    <button @click="openVoidModal" class="btn btn-danger btn-block font-weight-bold btn-block btn-lg">Void <small class="font-italic font-weight-bold">(Alt+V)</small></button>
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
  name: 'void',
  props: {
    order_list: Array
  },
  data(){
    return {
    }
  },
  methods: {
    openVoidModal(){
    }
  }
}
</script>
<style>

</style>
