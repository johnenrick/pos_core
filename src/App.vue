<template>

  <div class="h-100 system-background">

    <div v-if="!tokenData.verifyingToken" class="h-100">
      <nav id="mainNavigation"  class="navbar navbar-expand-md navbar-dark bg-dark" >
          <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fas fa-bars text-white"></i>
            </button>
            <a class="navbar-brand font-weight-bold" href="#" @click="logoClicked"><img src="./assets/img/navbarlogo.png" height="30" alt=""> LitePOS</a>
          </div>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul v-if="user.type === 1" class="navbar-nav mr-auto">
              <li class="nav-item bg-success  pl-2" v-bind:class="isActiveNav('/cashier')">
                <router-link class="nav-link" to="cashier"><i class="fas fa-laptop"></i> Cashier</router-link>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white pl-2" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-clipboard-list" aria-hidden="true"></i> Master List
                </a>
                <div class="dropdown-menu" >
                  <h6 class="dropdown-header">Product</h6>
                  <router-link class="dropdown-item" to="product_list"><i class="fas fa-box"></i> Product List</router-link>
                  <router-link class="dropdown-item" to="product_category"><i class="fas fa-th"></i> Category</router-link>
                  <h6 class="dropdown-header">Discount</h6>
                  <router-link class="dropdown-item" to="discount_list"><i class="fas fa-percent"></i> Discount List</router-link>
                </div>
              </li>
              <li class="nav-item dropdown" >
                <a class="nav-link dropdown-toggle text-white pl-2" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-archive" aria-hidden="true"></i> Inventory
                </a>
                <div class="dropdown-menu" >
                  <h6 class="dropdown-header">Inventory</h6>
                  <router-link class="dropdown-item" to="product_list"><i class="fas fa-dot-circle"></i> Product Inventory</router-link>
                  <router-link class="dropdown-item" to="production_count"><i class="fas fa-dot-circle"></i> Daily Production Count</router-link>
                  <router-link class="dropdown-item" to="product_quantity_adjustment"><i class="fas fa-dot-circle"></i> Quantity Adjustment</router-link>
                  <h6 class="dropdown-header">Manufacturing</h6>
                  <router-link class="dropdown-item" to="ingredient_supply"><i class="fas fa-dot-circle"></i> Ingredient Supply</router-link>
                  <router-link class="dropdown-item" to="formulation"><i class="fas fa-dot-circle"></i> Formulation</router-link>
                  <router-link class="dropdown-item" to="ingredient_list"><i class="fas fa-dot-circle"></i> Ingredient List</router-link>
                  <h6 class="dropdown-header">Others</h6>
                  <router-link class="dropdown-item" to="quantity_adjustment_type"><i class="fas fa-dot-circle"></i> Quantity Adjustment Type</router-link>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white pl-2" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-clipboard" aria-hidden="true"></i> Transactions
                </a>
                <div class="dropdown-menu">
                  <router-link class="dropdown-item" to="transaction_history"><i class="fas fa-shopping-cart"></i> Pending Transactions</router-link>
                  <router-link class="dropdown-item" to="transaction_history"><i class="fas fa-history"></i> Transaction History</router-link>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white pl-2" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-file-alt" aria-hidden="true"></i> Reports
                </a>
                <div class="dropdown-menu" >
                  <h6 v-if="false" class="dropdown-header">Basic Report</h6>
                  <router-link v-if="false" class="dropdown-item" to="x_reading"><i class="fas fa-clipboard-list"></i> X - Reading</router-link>
                  <router-link v-if="false" class="dropdown-item" to="z_reading"><i class="fas fa-clipboard-list"></i> Z - Reading</router-link>
                  <h6 v-if="false" class="dropdown-header">Other Reports</h6>
                  <router-link class="dropdown-item" to="daily_sales_report"><i class="fas fa-chart-line"></i> Daily Sales Report</router-link>
                  <router-link class="dropdown-item" to="product_sales_summary"><i class="fas fa-chart-line"></i> Product Sales Summary</router-link>
                </div>
              </li>
            </ul>
            <ul v-if="user.type === 2" class="navbar-nav mr-auto">
              <li class="nav-item active">
              </li>
            </ul>
            <ul v-if="user.userID" class="nav navbar-nav navbar-right">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Hi <span class="text-uppercase">{{user.username}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" >
                  <a @click="profileSetting" class="dropdown-item" href="#">
                    <i class="fa fa-user" aria-hidden="true"></i> Profile Settings
                  </a>
                  <div class="dropdown-divider"></div>
                  <a @click="logOut" class="dropdown-item"><i class="fa fa-power-off" aria-hidden="true"></i> Log Out</a>
                </div>
              </li>
            </ul>
          </div>
      </nav>
      <div class="container-fluid " v-bind:class="$route.meta.module_id === 3 ? 'h-100 system_background offset_navbar' : 'pt-3'">
        <transition name="slide-fade">
          <router-view ></router-view>
        </transition>
      </div>
    </div>
    <div v-else>
      Loading please wait. {{tokenData.verifyingToken}}
    </div>
  </div>
</template>

<script>
  import ROUTER from './router'
  import AUTH from './services/auth'
  export default {
    mounted(){
    },
    data(){
      return {
        user: AUTH.user,
        tokenData: AUTH.tokenData,
        currentRoute: ROUTER.currentRoute
      }
    },
    methods: {
      isActiveNav(path){
        return this.$route.path === path ? 'active' : ''
      }
    }
  }
</script>

<style scoped>
.nav-item .nav-link{
  color: white!important
}
.nav-item.active, .nav-item:hover{
  background-color: #0062cc;
}
.nav-item.bg-success.active, .nav-item.bg-success:hover{
  background-color: #1e7e34!important;

}
.offset_navbar{
  margin-top: -56px;
  padding-top: 65px
}
.system_background{
  background-image: url("./assets/img/purty_wood.png");
  background-repeat: repeat;
}
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all .6s;
}
.slide-fade-leave-active {
  transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active for <2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
