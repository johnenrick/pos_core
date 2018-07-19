<template>
  <div class="shadow">
    <div class="pb-2 bg-white ">
      <div class="row bg-primary no-gutters py-1 text-white">
        <div class="col-6 pl-2 text-center font-weight-bold">Description</div>
        <div class="col-2 pl-2 text-center font-weight-bold">QTY</div>
        <div class="col-4 pl-2 text-center font-weight-bold">Sub Total</div>
      </div>
      <div style="overflow-y: scroll" v-bind:style="{height: order_height + 'px'}">
        <div v-for="(order, index) in order_list" @click="openOrderDetail(index)" class="row border-bottom no-gutters ">
          <div class="col-6 pl-2">
            <span class="">{{order['description']}}</span><br>
            <small class="font-italic">(PhP {{order['price'] | displayNumber}})</small>
          </div>
          <div class="col-2 pr-2 text-right">{{order['quantity']}}</div>
          <div class="col-4 pr-2 text-right">{{(order['quantity'] * order['price']) | displayNumber}}</div>
        </div>
      </div>
      <div class="row no-gutters py-1 ">
        <div class="col-6 pl-2 font-weight-bold"></div>
        <div class="col-2 pr-2 font-weight-bold">Total:</div>
        <div class="col-4 pr-2 text-right font-weight-bold">{{totalPrice | displayNumber}}</div>
      </div>
    </div>
    <div class="modal fade" ref="orderDetail" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <label class="col-3 col-form-label">Description: </label>
                  <div class="col-9">
                    <input type="text" readonly class="form-control-plaintext text-uppercase" v-bind:value="selectedOrder['description']">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="row">
                  <label class="col-3 col-form-label">Price: </label>
                  <div class="col-9">
                    <input type="text" readonly class="form-control-plaintext text-uppercase text-right" v-bind:value="selectedOrder['price'] | displayNumber">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class=" row">
                  <label class="col-3 col-form-label">Quantity: </label>
                  <div class="col-9">
                    <input type="number" class="form-control text-right" v-model="orderDetailQuantity">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-3 col-form-label">Quantity: </label>
                  <div class="col-9">
                    <input type="text" readonly class="form-control-plaintext text-uppercase text-right" v-bind:value="selectedOrder['price'] * orderDetailQuantity | displayNumber">
                  </div>
                </div>
              </div>
            </div>
            <button @click="removeOrder" type="button" class="btn btn-danger float-right" ><i class="fas fa-trash"></i> Remove Order</button>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button @click="saveChanges" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default{
  props: {
    order_list: Array,
    order_height: Number
  },
  data(){
    return {
      totalPrice: 0,
      selectedOrder: {},
      selectOrderIndex: null,
      orderDetailQuantity: 0
    }
  },
  methods: {
    orderListUpdated(){
      this.totalPrice = 0
      for(let x in this.order_list){
        this.totalPrice += (this.order_list[x]['quantity'] * this.order_list[x]['price'])
      }
    },
    openOrderDetail(index){
      this.selectedOrder = this.order_list[index]
      this.selectOrderIndex = index
      this.orderDetailQuantity = this.selectedOrder['quantity']
      $(this.$refs.orderDetail).modal('show')
    },
    saveChanges(){
      this.order_list[this.selectOrderIndex]['quantity'] = this.orderDetailQuantity * 1
      this.orderListUpdated()
      $(this.$refs.orderDetail).modal('hide')
    },
    removeOrder(){
      this.order_list.splice(this.selectOrderIndex, 1)
      this.$emit('order_removed', this.selectOrderIndex)
      $(this.$refs.orderDetail).modal('hide')
    }
  },
  watch: {
  }
}
</script>
<style>

</style>
