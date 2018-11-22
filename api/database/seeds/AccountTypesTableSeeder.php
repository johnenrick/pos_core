<?php

use Illuminate\Database\Seeder;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB:: table('account_types')->truncate();
        DB:: table('account_types') -> insert(array(
          array("id" => "1","description" => "Admin"),
          array("id" => "2","description" => "Employee"),
          array("id" => "3","description" => "Driver"),
          array("id" => "4","description" => "Conductor"),
          array("id" => "5","description" => "Cashier"),
          array("id" => "6","description" => "Cook"),
          array("id" => "7","description" => "Server"),
          array("id" => "8","description" => "Inspector")
        ));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
