<template>
  <div>
    <button @click="openCheckOutModal" v-bind:disabled="order_list.length ? false : true" class="btn btn-success btn-block font-weight-bold text-uppercase " v-bind:class="(alignment === 'right' ? 'float-right' : '' )">Check Out <i class="fas fa-arrow-right"></i></button>
    <div ref="checkOutModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Check Out</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <template v-if="!isSuccess">
            <div class="modal-body">
              <div class="row" v-if="errorMessage">
                <div class="col-12">
                  <div class="alert alert-danger" role="alert" v-html="errorMessage">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <label class="col-7 col-form-label font-weight-bold text-uppercase">Guest </label>
                    <div class="col-5">
                      <button class="btn btn-success float-right"><i class="fas fa-user"></i> Customer</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row">
                    <label class="col-4 col-form-label">Total Price: </label>
                    <div class="col-8">
                      <input type="text" readonly class="form-control-plaintext text-uppercase text-right" v-bind:value="totalPrice | displayNumber">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row">
                    <label class="col-4 col-form-label">VAT: </label>
                    <div class="col-8">
                      <input type="text" readonly class="form-control-plaintext text-uppercase text-right" v-bind:value="(totalPrice * 0.12) | displayNumber">
                    </div>
                  </div>
                </div>
                <div class="col-md-12 text-right">
                  <div class="form-check">
                    <label class="form-check-label font-weight-bold" ><input type="checkbox" class="form-check-input" v-model="requestOnlinePayment"> Request an Online Payment</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row">
                    <label class="col-4 col-form-label">Cash Tendered: </label>
                    <div class="col-8">
                      <input v-bind:disabled="requestOnlinePayment" type="text" class="form-control text-right" v-model="cashTendered">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row" v-bind:class="paymentChange > 0 ? 'font-weight-bold' : ''">
                    <label class="col-4 col-form-label" >Change: </label>
                    <div class="col-8">
                      <input type="text" readonly class="form-control-plaintext text-right" v-bind:value="paymentChange | displayNumber">
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="modal-footer">
              <button @click="finishTransaction" v-bind:disabled="!requestOnlinePayment && (paymentChange < 0 || isRequesting < 0) ? true : false" type="button" class="btn btn-success text-uppercase font-weight-bold"><i class="fas fa-check"></i> {{isRequesting ? 'Please wait...': 'Finish Transaction'}}</button>
            </div>
          </template>
          <template v-else>
            <div class="modal-body">
              <div class="alert alert-success text-center font-weight-bold">
                <i class="fas fa-check"></i> Transaction has been sucessful! Transaction Code 123-2938-23 has been sent!
              </div>
            </div>
            <div class="modal-footer">
              <button @click="closeCheckOut" class="btn btn-outline-success">Close</button>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default{
  props: {
    alignment: String,
    order_list: Array
  },
  data(){
    return {
      totalPrice: 0,
      cashTendered: null,
      isRequesting: false,
      isSuccess: false,
      errorMessage: null,
      requestOnlinePayment: false
    }
  },
  watch: {
    requestOnlinePayment: (newData) => {
      if(newData){
        this.cashTendered = 0
      }
    }
  },
  methods: {
    finishTransaction(){
      this.errorMessage = null
      this.isRequesting = true
      let order = {
        total_price: this.totalPrice,
        cash_tendered: !this.requestOnlinePayment ? this.cashTendered - this.paymentChange : 0,
        value_added_tax: this.totalPrice * 0.12,
        order_products: [],
        status: this.requestOnlinePayment ? 2 : 1
      }
      for(let x in this.order_list){
        order.order_products.push({
          product_id: this.order_list[x]['product_id'],
          sale_price: this.order_list[x]['price'],
          quantity: this.order_list[x]['quantity']
        })
      }
      this.APIRequest('order/create', order, (response) => {
        if(!response['error'].length){
          this.isSuccess = true
          this.cashTendered = null
          this.requestOnlinePayment = false
          this.$emit('transaction_finished')
        }else{
          this.errorMessage = ''
          for(let x = 0; x < response['error'].length; x++){
            if(response['error'][x]['status'] * 1 === 100){
              for(let y in response['error'][x]['message']){
                this.errorMessage += response['error'][x]['message'][y] + '<br>'
              }
            }
          }
        }
        this.isRequesting = false
      }, () => {
        this.isRequesting = false
      })

    },
    openCheckOutModal(){
      this.calculateTotalPrice()
      this.isSuccess = false
      $(this.$refs.checkOutModal).modal('show')
    },
    calculateTotalPrice(){
      this.totalPrice = 0
      for(let x in this.order_list){
        this.totalPrice += (this.order_list[x]['quantity'] * this.order_list[x]['price'])
      }
    },
    closeCheckOut(){
      $(this.$refs.checkOutModal).modal('hide')
    }
  },
  computed: {
    paymentChange: function() {
      return this.cashTendered - this.totalPrice
    }
  }
}
</script>
<style>

</style>
