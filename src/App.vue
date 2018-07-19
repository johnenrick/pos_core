<template>
  <div ref="body" class="fixed-nav " id="body">
      <nav id="mainNav" class="navbar navbar-expand-lg navbar-dark bg-brand-dark-1 fixed-top sidebar-image" >
        <a class="navbar-brand font-weight-bold" href="#" @click="logoClicked"><img src="./assets/img/navbarlogo.png" height="30" alt=""> &nbsp; &nbsp;POINT OF SALE</a>
        <button v-if="$auth.user().account_type_id" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul v-if="$auth.user().account_type_id === 1" class="navbar-nav">
            <li class="nav-item bg-primary text-center" data-placement="right" title="Cashier"  >
              <router-link class="nav-link" to="cashier" active-class="active-link"><i class="fas fa-laptop"></i> Cashier</router-link>
            </li>
          </ul>
          <ul v-if="$auth.user().account_type_id === 1" class="navbar-nav navbar-sidenav ">
            <template v-for="menu in sideBarMenu" class="nav-item">
              <side-menu-list :name="menu['name']" :type="menu['type']"  :icon="menu['icon']" :to="menu['to']" :sub_menu="menu['sub_menu']"></side-menu-list>
            </template>
          </ul>
          <ul v-if="$auth.user().account_type_id  >= 1" class="navbar-nav sidenav-toggler">
            <li class="nav-item">
              <a @click="toggleMenu" ref="#" class="nav-link text-center" id="sidenavToggler" style="background-color: #1c2427">
                <i class="fa fa-fw fa-angle-left"></i>
              </a>
            </li>
          </ul>
          <ul v-if="$auth.user().id" class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Hi <span class="text-uppercase">{{$auth.user().username}}!</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" >
                <a @click="profileSetting" class="dropdown-item" href="#">

                </a>
                <router-link class="dropdown-item" to="profile_setting" ><i class="fa fa-user" aria-hidden="true"></i> Profile Settings</router-link>
                <div class="dropdown-divider"></div>
                <a @click="logOut" class="dropdown-item"><i class="fa fa-power-off" aria-hidden="true"></i> Log Out</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
      <div class=""  >
        <!-- v-bind:class="$route.meta.module_id === 3 ? 'h-100 system_background offset_navbar' : 'pt-3'" -->

          <!-- Breadcrumbs-->
          <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol> -->

            <template v-if="$auth.ready()">
              <div class="content-wrapper" style="padding-top:0px">
                <transition name="fade">
                  <router-view ></router-view>
                </transition>
              </div>
            </template>
            <template v-else>
              <loading-indicator :is_loading="true" ></loading-indicator>
            </template>


        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        <!-- <div id="footer" class="sticky-footer">
          <div class="container">
            <div class="text-center">
              <small>Copyright © Your Website 2018</small>
            </div>
          </div>
        </div> -->
        <!-- <a class="scroll-to-top rounded" href="#body">
          <i class="fa fa-angle-up"></i>
        </a> -->
      </div>

  </div>
</template>

<script>
  import ROUTER from './router'
  export default {
    components: {
      'side-menu-list': require('components/frame/SideMenuList.vue')
    },
    beforeCreate(){

    },
    mounted(){
      // console.log('account_type', this.$auth.user().account_type_id)
      $('#loadingScreen').hide()
      $(document).ready(function(){
        $('body').on('click', '.nav-link-collapse.collapsed', function(o){
          $('#body').removeClass('sidenav-toggled')
        })
      })
    },
    data(){
      return {
        currentRoute: ROUTER.currentRoute,
        userFetched: false,
        sideBarMenu: [{
          type: 'multi_level',
          name: 'Master List',
          icon: 'fa fa-clipboard-list',
          sub_menu: [{
            type: 'divider',
            name: 'User'
          }, {
            to: 'user_management',
            icon: 'fas fa-users'
          }, {
            type: 'divider',
            name: 'Bus'
          }, {
            to: 'bus_list',
            icon: 'fas fa-bus'
          }, {
            to: 'bus_type',
            icon: 'fas fa-th'
          }, {
            to: 'route_management',
            icon: 'fas fa-map-marker'
          }, {
          //   type: 'divider',
          //   name: 'Product'
          // }, {
          //   icon: 'fas fa-box',
          //   to: 'product_list'
          // }, {
          //   icon: 'fas fa-th',
          //   to: 'product_category'
          // }, {
            type: 'divider',
            name: 'Discount'
          }, {
            to: 'discount_list',
            icon: 'fas fa-percent'
          }]
        }, {
          type: 'multi_level',
          name: 'Trip',
          icon: 'fa-road',
          sub_menu: [{
            to: 'bus_trip',
            icon: 'fas fa-road'
          }, {
            to: 'bus_trip_ticket',
            icon: 'fas fa-ticket-alt'
          }]
        }, {
        //   type: 'multi_level',
        //   name: 'Inventory',
        //   icon: 'fa fa-archive',
        //   sub_menu: [{
        //     type: 'divider',
        //     name: 'Inventory'
        //   }, {
        //     to: 'product_list',
        //     icon: 'fas fa-dot-circle',
        //     name: 'Product Inventory'
        //   }, {
        //     to: 'production_count',
        //     name: 'Daily Production Count'
        //   }, {
        //     to: 'product_quantity_adjustment'
        //   }, {
        //     type: 'divider',
        //     name: 'Manufacturing'
        //   }, {
        //     to: 'ingredient_supply'
        //   }, {
        //     to: 'formulation'
        //   }, {
        //     to: 'ingredient_list'
        //   }, {
        //     type: 'divider',
        //     name: 'Others'
        //   }, {
        //     to: 'quantity_adjustment_type'
        //   }]
        // },{
          type: 'multi_level',
          name: 'Transactions',
          icon: 'fa fa-clipboard',
          sub_menu: [{
          //   to: 'transaction_history',
          //   name: 'Pending Transactions'
          // }, {
          //   to: 'transaction_history'
          // }, {
            to: 'void_bus_trip_ticket',
            name: 'Void Bus Trip Ticket'
          }]
        }, {
          type: 'multi_level',
          name: 'Reports',
          icon: 'fa fa-file-alt',
          sub_menu: [{
          //   type: 'divider',
          //   name: 'Basic Report'
          // }, {
          //   to: 'x_reading',
          //   name: 'X - Reading',
          //   icon: 'fas fa-clipboard-list'
          // }, {
          //   to: 'z_reading',
          //   name: 'Z - Reading',
          //   icon: 'fas fa-clipboard-list'
          // }, {
            type: 'divider',
            name: 'Other Reports'
          }, {
          //   to: 'daily_sales_report',
          //   icon: 'fas fa-chart-line'
          // }, {
            to: 'bus_daily_sales_report',
            name: 'Daily Sales Report',
            icon: 'fas fa-chart-line'
          }, {
            to: 'route_sales_summary',
            icon: 'fas fa-chart-bar'
          }, {
            to: 'bus_collection_summary',
            icon: 'fas fa-chart-line'
          }]
        }]
      }
    },
    methods: {
      toggleMenu(){
        $('#body').toggleClass('sidenav-toggled')
        $(this.$refs.body).find('.navbar-sidenav .nav-link-collapse').addClass('collapsed')
        $(this.$refs.body).find('.navbar-sidenav .sidenav-second-level, .navbar-sidenav .sidenav-third-level').removeClass('show')

      }

    }
  }
</script>

<style scoped>
.nav-item .nav-link{
  /*color: white!important*/
}
/*.nav-item.active, .nav-item:hover{
  background-color: #0062cc;
}
.nav-item.bg-success.active, .nav-item.bg-success:hover{
  background-color: #1e7e34!important;

}*/
/*.offset_navbar{
  margin-top: -56px;
  padding-top: 65px
}*/
/* Enter and leave animations can use different */
/* durations and timing functions.              */



.fade-enter-active, .fade-leave-active {
  transition: opacity .1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
