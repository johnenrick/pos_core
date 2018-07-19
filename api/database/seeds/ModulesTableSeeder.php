<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB:: table('modules')->truncate();
      DB:: table('modules')->insert(array(
        // Cashier
        array('id' => 1, 'parent_id' => 0, 'description'=>'Cashier', 'icon' => 'fas fa-laptop', 'path' => 'cashier', 'rank' => 1),
        // Master List
        array('id' => 2, 'parent_id' => 0, 'description'=>'Master List', 'icon' => 'fas fa-clipboard-list', 'path' => '', 'rank' => 2),
          array('id' => 3, 'parent_id' => 2, 'description'=>'Product', 'icon' => 'fa fa-address-card-o', 'path' => '', 'rank' => 2),
            array('id' => 4, 'parent_id' => 3, 'description'=>'Product List', 'icon' => 'fas fa-box', 'path' => 'product_list', 'rank' => 2),
            array('id' => 5, 'parent_id' => 3, 'description'=>'Category', 'icon' => 'fas fa-th', 'path' => 'product_category', 'rank' => 2),
          array('id' => 6, 'parent_id' => 2, 'description'=>'Discount', 'icon' => '', 'path' => '', 'rank' => 2),
              array('id' => 7, 'parent_id' => 6, 'description'=>'Discount List', 'icon' => 'fa fa-address-card-o', 'path' => 'discount_list', 'rank' => 2),
          array('id' => 27, 'parent_id' => 0, 'description'=>'Bus', 'icon' => '', 'path' => '', 'rank' => 2),
            array('id' => 28, 'parent_id' => 27, 'description'=>'Bus List', 'icon' => 'fas fa-bus', 'path' => 'bus_list', 'rank' => 1),
            array('id' => 29, 'parent_id' => 27, 'description'=>'Bus Type', 'icon' => 'fas fa-th', 'path' => 'bus_type', 'rank' => 2),
            array('id' => 30, 'parent_id' => 27, 'description'=>'Route Management', 'icon' => 'fas fa-map-marker', 'path' => 'route_management', 'rank' => 3),
        // Trip
        array('id' => 31, 'parent_id' => 0, 'description'=>'Bus Trip', 'icon' => 'fa fa-road',  'path' => '', 'rank' => 3),
          array('id' => 32, 'parent_id' => 31, 'description'=>'Bus Trip', 'icon' => 'fa fa-road', 'path' => 'bus_trip', 'rank' => 1),
          array('id' => 33, 'parent_id' => 31, 'description'=>'Bus Trip Ticket', 'icon' => 'fa-ticket-alt', 'path' => 'bus_trip_ticket', 'rank' => 2),
        // Inventory
        array('id' => 8, 'parent_id' => 0, 'description'=>'Inventory', 'icon' => 'fa fa-archive',  'path' => 'counter', 'rank' => 4),
          array('id' => 9, 'parent_id' => 8, 'descri4ption'=>'Inventory', 'icon' => '', 'path' => '', 'rank' => 2),
            array('id' => 10, 'parent_id' => 9, 'description'=>'Product Inventory', 'icon' => '', 'path' => '', 'rank' => 2),
            array('id' => 11, 'parent_id' => 9, 'description'=>'Daily Production Count', 'icon' => '', 'path' => 'production_count', 'rank' => 2),
            array('id' => 12, 'parent_id' => 9, 'description'=>'Quantity Adjustment', 'icon' => '', 'path' => 'product_quantity_adjustment', 'rank' => 2),
          array('id' => 13, 'parent_id' => 8, 'description'=>'Manufacturing', 'icon' => '', 'path' => '', 'rank' => 2),
            array('id' => 14, 'parent_id' => 13, 'description'=>'Ingredient Supply', 'icon' => '', 'path' => 'ingredient_supply', 'rank' => 2),
            array('id' => 15, 'parent_id' => 13, 'description'=>'Formulation', 'icon' => '', 'path' => 'formulation', 'rank' => 2),
            array('id' => 16, 'parent_id' => 13, 'description'=>'Ingredient List', 'icon' => '', 'path' => 'ingredient_list', 'rank' => 2),
          array('id' => 17, 'parent_id' => 0, 'description'=>'Others', 'icon' => '', 'path' => '', 'rank' => 2),
            array('id' => 18, 'parent_id' => 17, 'description'=>'Quantity Adjustment', 'icon' => '', 'path' => 'quantity_adjustment_type', 'rank' => 2),
        // Transactions
        array('id' => 19, 'parent_id' => 0, 'description'=>'Transaction', 'icon' => 'fa fa-clipboard',  'path' => '', 'rank' => 5),
          array('id' => 20, 'parent_id' => 19, 'description'=>'Pending Transactions', 'icon' => '', 'path' => 'transaction_history', 'rank' => 2),
          array('id' => 21, 'parent_id' => 19, 'description'=>'Transaction History', 'icon' => '', 'path' => 'transaction_history', 'rank' => 2),
        // Reports
        array('id' => 22, 'parent_id' => 0, 'description'=>'Reports', 'icon' => 'fa fa-file-alt',  'path' => '', 'rank' => 6),
          array('id' => 23, 'parent_id' => 22, 'description'=>'X Reading', 'icon' => '', 'path' => 'x_reading', 'rank' => 1),
          array('id' => 24, 'parent_id' => 22, 'description'=>'Z Reading', 'icon' => '', 'path' => 'z_reading', 'rank' => 2),
          array('id' => 25, 'parent_id' => 22, 'description'=>'Daily Sales Report', 'icon' => '', 'path' => 'daily_sales_report', 'rank' => 3),
          array('id' => 26, 'parent_id' => 22, 'description'=>'Product Sales Summary', 'icon' => '', 'path' => 'product_sales_summary', 'rank' => 4),

          array('id' => 34, 'parent_id' => 22, 'description'=>'Bus Daily Sales Report', 'icon' => '', 'path' => 'bus_daily_sales_report', 'rank' => 5),
          array('id' => 35, 'parent_id' => 22, 'description'=>'Route Sales Summary', 'icon' => '', 'path' => 'route_sales_summary', 'rank' => 6),
          array('id' => 36, 'parent_id' => 22, 'description'=>'Bus Collection Summary', 'icon' => '', 'path' => 'bus_collection_summary', 'rank' => 7)
          // LAST ID 36
      ));
    }
}
