<?php

use Illuminate\Database\Seeder;

class AccountTypeModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB:: table('account_type_modules')->truncate();
      DB:: table('account_type_modules')->insert(array(
        // Admin
        array('module_id' => '1', 'account_type_id' => '1'),
        array('module_id' => '2', 'account_type_id' => '1'),
        array('module_id' => '31', 'account_type_id' => '1'),
        array('module_id' => '8', 'account_type_id' => '1'),
        array('module_id' => '19', 'account_type_id' => '1'),
        array('module_id' => '22', 'account_type_id' => '1')

        // Cashier
        // Server
      ));
    }
}
