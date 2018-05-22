
export default{
  routes: [{
    path: '/auth',
    name: 'auth',
    component: resolve => require(['modules/test/Auth.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  },
  {
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
      module_id: 1
    }
  },
  {
    path: '/product_list',
    name: 'productList',
    component: resolve => require(['modules/product/ProductList.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/product_category',
    name: 'productCategory',
    component: resolve => require(['modules/product/ProductCategory.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/discount_list',
    name: 'discountList',
    component: resolve => require(['modules/discount/DiscountList.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/ingredient_list',
    name: 'ingredientList',
    component: resolve => require(['modules/manufacturing/IngredientList.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/ingredient_supply',
    name: 'ingredientSupply',
    component: resolve => require(['modules/manufacturing/IngredientSupply.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/production_count',
    name: 'ProductionCount',
    component: resolve => require(['modules/inventory/ProductionCount.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/quantity_adjustment_type',
    name: 'QuantityAdjustmentType',
    component: resolve => require(['modules/inventory/QuantityAdjustmentType.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/product_quantity_adjustment',
    name: 'ProductQuantityAdjustment',
    component: resolve => require(['modules/inventory/ProductQuantityAdjustment.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/formulation',
    name: 'formulation',
    component: resolve => require(['modules/manufacturing/Formulation.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/x_reading',
    name: 'xReading',
    component: resolve => require(['modules/basic_report/XReading.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/z_reading',
    name: 'zReading',
    component: resolve => require(['modules/basic_report/ZReading.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/cashier',
    name: 'cashier',
    component: resolve => require(['modules/cashier/Cashier.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 3
    }
  },
  {
    path: '/product_sales_summary',
    name: 'ProductSalesSummary',
    component: resolve => require(['modules/reports/ProductSalesSummary.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
    }
  },
  {
    path: '/daily_sales_report',
    name: 'DailySalesReport',
    component: resolve => require(['modules/reports/DailySalesReport.vue'], resolve),
    meta: {
      tokenRequired: true,
      module_id: 2
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
  }]
}
