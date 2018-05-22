<?php
/* Add the undescore case of the controller, no need to specify crud operations*/
$apiResources = [
  'modules',
  'business_type',
  'company',
  'company_logo',
  'company_branch',
  'company_branch_employee',
  'position',
  'api_test_results',
  'account',
  'account_type',
  'account_information',
  'account_profile_picture',
  'product',
  'order',
  'order_product',
  'product_category',
  'discount',
  'ingredient',
  'ingredient_supply',
  'product_ingredient',
  'production_count',
  'quantity_adjustment_type',
  'product_quantity_adjustment'
];
api_resource($apiResources);
$customAPIResources = [
  'order_product/productSalesSummary',
  'order/dailySalesReport'
];
custom_api($customAPIResources)
?>