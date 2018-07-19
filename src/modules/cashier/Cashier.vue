<template>
  <div class="content-padding background-pattern">
    <div class="row pb-3 d-none" >
      <div class="col-md-4">
        <h4>ABACUS</h4>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <div class="btn-group float-right">
          <button type="button" class="btn btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> {{$auth.user().username}}
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a @click="profileSetting" class="dropdown-item" href="#">
              <i class="fa fa-user" aria-hidden="true"></i> Profile Settings
            </a>
            <div class="dropdown-divider"></div>
            <a @click="logOut" class="dropdown-item"><i class="fa fa-power-off" aria-hidden="true"></i> Log Out</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row no-gutters">
      <div class="col-6 d-md-none">
      </div>
      <div class="col-6 d-md-none">
        <button @click="isOrderListShown = !isOrderListShown" v-if="!isOrderListShown" class="btn btn-primary mb-2 btn-block"><i class="fas fa-arrow-left"></i> ORDER LIST</button>
        <button @click="isOrderListShown = !isOrderListShown" v-if="isOrderListShown" class="btn btn-primary mb-2 btn-block">PRODUCT MENU <i class="fas fa-arrow-right"></i></button>
      </div>
      <div class=" col-md-6 d-md-block " v-bind:class="!isOrderListShown ? 'd-none' : ''">
        <order-list ref="productOrdered" @order_removed="$refs.productOrdered.orderListUpdated()" :order_list="orderList" :order_height="orderListHeight"></order-list>
        <div class="row pt-2 no-gutters">
          <!--Show on XS hide on SM-->
          <!-- <div class="col-5 d-md-none pr-1">
          </div> -->
          <div class="col-12 mb-1 d-sm-none">
            <check-out @transaction_finished="resetOrder" :order_list="orderList" :alignment="'right'"></check-out>
          </div>
          <!--end on XS only-->
          <div class="col-12 col-sm-4 pr-sm-1">
            <button @click="modal($refs.moreOptionModal, 'show')" type="button" class="btn btn-dark btn-block" data-toggle="modal" ><i class="fas fa-cog"></i> Options</button>
          </div>
          <!--Hide on XS show on SM-->
          <div class="col-sm-8 mt-2 mt-sm-0 d-none d-sm-block">
            <check-out @transaction_finished="resetOrder" :order_list="orderList" :alignment="'right'"></check-out>
          </div>
        </div>
      </div>
      <div class="col-md-6 pl-md-2 d-md-block" v-bind:class="isOrderListShown ? 'd-none' : ''">
        <product-menu @addOrder="addOrder" :menu_height="productMenuHeight" ></product-menu>
      </div>
    </div>
    <div ref="moreOptionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">More Options</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body no-gutters">
            <div class="row no-gutters">
              <div v-bind:class="moreOptionClass">
                <button class="btn btn-outline-info btn-block btn-lg"><i class="fas fa-folder"></i> Park Txn</button>
              </div>
              <div v-bind:class="moreOptionClass">
                <button class="btn btn-outline-info btn-block btn-lg"><i class="fas fa-folder-open"></i> Open Parked</button>
              </div>
              <div v-bind:class="moreOptionClass">
                <button class="btn btn-outline-danger btn-block btn-lg"><i class="fas fa-percent"></i> Discount</button>
              </div>
            </div>
            <div class="row no-gutters">
              <div v-bind:class="moreOptionClass">
                <button class="btn btn-primary btn-block btn-lg"><i class="fas fa-money-bill-alt"></i> Cash on Hand</button>
              </div>
              <div v-bind:class="moreOptionClass">
                <button class="btn btn-success btn-block btn-lg"><i class="fas fa-book"></i> X-Reading</button>
              </div>
              <div v-bind:class="moreOptionClass">
                <button class="btn btn-outline-warning btn-block btn-lg"><i class="fas fa-print"></i> Reprint</button>
              </div>
            </div>
            <div class="row no-gutters">
              <div v-bind:class="moreOptionClass">
                <button @click="resetOrder" class="btn btn-secondary btn-block btn-lg"><i class="fas fa-sync-alt"></i> Reset</button>
              </div>
              <div v-bind:class="moreOptionClass">
                <return ></return>
              </div>
              <div v-bind:class="moreOptionClass">
                <void ></void>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Vue from 'vue'
import Vuex from 'vuex'
export default{
  name: 'cashiering',
  components: {
    'product-menu': require('./ProductMenu.vue'),
    'order-list': require('./OrderList.vue'),
    'check-out': require('./CheckOut.vue'),
    'return': require('./Return.vue'),
    'void': require('./Void.vue')
  },
  mounted(){
    this.calculateHeight()
    $(window).resize(() => {
      this.calculateHeight()
    })
  },
  data(){
    return {
      orderList: [
      ],
      isOrderListShown: true,
      productMenuHeight: 0,
      orderListHeight: 0,
      moreOptionClass: 'col-sm-4 col-md-4 mb-1 px-1'
    }
  },
  methods: {
    addOrder(productID, quantity, description, shortName, price){
      let orderIndex = this.searchOrderList(productID)
      if(orderIndex){
        Vue.set(this.orderList[orderIndex], 'quantity', this.orderList[orderIndex]['quantity'] += quantity * 1)
      }else{
        this.orderList.push({
          product_id: productID,
          quantity: quantity,
          description: description,
          short_name: shortName,
          price: price
        })
      }
      this.$refs.productOrdered.orderListUpdated()
    },
    searchOrderList(productID){
      for(let index in this.orderList){
        if(this.orderList[index]['product_id'] * 1 === productID * 1){
          return index
        }
      }
    },
    resetOrder(){
      this.orderList.splice(0, this.orderList.length)
      this.orderList = []
      this.$refs.productOrdered.orderListUpdated()
      this.modal(this.$refs.moreOptionModal, 'hide')
    },
    showProductMenu(){
    },
    calculateHeight(){
      let windowHeight = $(window).height()
      let windowWidth = $(window).width()
      let containerTopPadding = 15
      let navbar = 58
      let productMenu = 34
      let orderMenuSwitch = 46
      this.productMenuHeight = windowHeight - navbar - containerTopPadding - productMenu - (windowWidth < 768 ? 46 : 0)
      let columnHeaderFooter = 72
      let optionsHeight = 46
      this.orderListHeight = windowHeight - navbar - containerTopPadding - columnHeaderFooter - (windowWidth < 768 ? 46 + 81 : 46) - 12
    }
  }
}
</script>
<style>
.background-pattern{
  /*background-image: url("../../assets/img/grey_wash_wall.png");*/
  background-color: whitesmoke
}
</style>
