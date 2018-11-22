<?php

use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB:: table('discounts')->truncate();
      DB:: table('discounts') -> insert(array(
        array("id" => "1","description" => "PWD", "type" => 1, "application" => 2, "restricted" => 0, "value" => 20),
        array("id" => "2", "description" => "Senior Citizen", "type" => 1, "application" => 2, "restricted" => 0, "value" => 30),
      ));
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
