<?php

use Illuminate\Database\Seeder;

class BusTripExpenseItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB:: table('bus_trip_expense_items')->truncate();
      DB:: table('bus_trip_expense_items') -> insert([
        ["id" => 1, "description" => "Others"],
        ["id" => 2, "description" => "Parking Fee"],
        ["id" => 3, "description" => "Allowance"]
      ]);
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
