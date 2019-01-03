
export default{
  routes: [{
    path: '/mockup',
    name: 'mockup',
    component: resolve => require(['modules/test/Mockup.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  },
  {
    path: '/admin',
    name: 'admin',
    component: resolve => require(['modules/home/AdminHome.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 1,
      auth: true
    }
  },
  {
    path: '/product_list',
    name: 'productList',
    component: resolve => require(['modules/product/ProductList.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/inspector_report',
    name: 'inspectorReport',
    component: resolve => require(['modules/inspector/InspectorReport.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/user_management',
    name: 'userManagement',
    component: resolve => require(['modules/user/UserManagement.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/product_category',
    name: 'productCategory',
    component: resolve => require(['modules/product/ProductCategory.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_list',
    name: 'busList',
    component: resolve => require(['modules/bus/Bus.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_trip_expense_item',
    name: 'busTripExpenseItem',
    component: resolve => require(['modules/master_list/BusTripExpenseItem.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/void_request_reason',
    name: 'voidRequestReason',
    component: resolve => require(['modules/master_list/VoidRequestReason.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_type',
    name: 'busType',
    component: resolve => require(['modules/bus/BusType.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_daily_sales_report',
    name: 'busDailySalesReport',
    component: resolve => require(['modules/reports/BusDailySalesReport.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/route_management',
    name: 'routeManagement',
    component: resolve => require(['modules/bus/RouteManagement.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_collection_summary',
    name: 'busCollectionSummary',
    component: resolve => require(['modules/reports/BusCollectionSummary.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_trip_fuel_consumption',
    name: 'busTripFuelConsumption',
    component: resolve => require(['modules/reports/BusTripFuelConsumption.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_sales_history',
    name: 'busSalesHistory',
    component: resolve => require(['modules/reports/BusSalesHistory.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_trip',
    name: 'BusTrip',
    component: resolve => require(['modules/bus_trip/BusTrip.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/bus_trip_ticket',
    name: 'BusTripTicket',
    component: resolve => require(['modules/bus_trip/BusTripTicket.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/route_sales_summary',
    name: 'RouteSalesSummary',
    component: resolve => require(['modules/reports/RouteSalesSummary.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/discount_list',
    name: 'discountList',
    component: resolve => require(['modules/discount/DiscountList.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/ingredient_list',
    name: 'ingredientList',
    component: resolve => require(['modules/manufacturing/IngredientList.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/ingredient_supply',
    name: 'ingredientSupply',
    component: resolve => require(['modules/manufacturing/IngredientSupply.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/production_count',
    name: 'ProductionCount',
    component: resolve => require(['modules/inventory/ProductionCount.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/quantity_adjustment_type',
    name: 'QuantityAdjustmentType',
    component: resolve => require(['modules/inventory/QuantityAdjustmentType.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/product_quantity_adjustment',
    name: 'ProductQuantityAdjustment',
    component: resolve => require(['modules/inventory/ProductQuantityAdjustment.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/formulation',
    name: 'formulation',
    component: resolve => require(['modules/manufacturing/Formulation.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/x_reading',
    name: 'xReading',
    component: resolve => require(['modules/basic_report/XReading.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/z_reading',
    name: 'zReading',
    component: resolve => require(['modules/basic_report/ZReading.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/cashier',
    name: 'cashier',
    component: resolve => require(['modules/cashier/Cashier.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 3,
      auth: true
    }
  },
  {
    path: '/product_sales_summary',
    name: 'ProductSalesSummary',
    component: resolve => require(['modules/reports/ProductSalesSummary.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/daily_sales_report',
    name: 'DailySalesReport',
    component: resolve => require(['modules/reports/DailySalesReport.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2,
      auth: true
    }
  },
  {
    path: '/transaction_history',
    name: 'TransactionHistory',
    component: resolve => require(['modules/transaction/TransactionHistory.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/payment',
    name: 'paymentPortal',
    component: resolve => require(['modules/payment_portal/PaymentPortal.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  },
  {
    path: '/server',
    name: 'server',
    component: resolve => require(['modules/server/Server.vue'], resolve),
    meta: {
      module_id: 4
    }
  },
  {
    path: '/loadingScreen',
    name: 'loadingScreen',
    component: resolve => require(['modules/home/LoadingScreen.vue'], resolve),
    meta: {
      module_id: 4
    }
  },
  {
    path: '/void_bus_trip_ticket',
    component: resolve => require(['modules/bus_trip/VoidBusTripTicket.vue'], resolve),
    meta: {
      module_id: 4
    }
  },
  {
    path: '/profile_setting',
    component: resolve => require(['modules/profile/ProfileSetting.vue'], resolve),
    meta: {
      module_id: 4
    }
  },
  {
    path: '/api_test',
    component: resolve => require(['modules/test/APITest.vue'], resolve),
    meta: {
      module_id: 4
    }
  }]
}
