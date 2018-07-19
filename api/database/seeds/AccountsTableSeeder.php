<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPassword = Hash::make('admin');
        $employeePassword = Hash::make('employee');
        DB:: table('accounts') -> insert(array(
          array("id" => "1", "account_type_id" => 1, "username" => "Admin", "email" => "Admin@gocentralph.com", "password" => $adminPassword),
          array("id" => "2", "account_type_id" => 2, "username" => "Conductor", "email" => "Employee@gocentralph.com", "password" => $employeePassword),
          array("id" => "3", "account_type_id" => 2, "username" => "Driver", "email" => "Employee@gocentralph.com", "password" => $employeePassword),
          array("id" => "4", "account_type_id" => 2, "username" => "Cashier", "email" => "Employee@gocentralph.com", "password" => $employeePassword),
          array("id" => "5", "account_type_id" => 2,  "username" => "Cook", "email" => "Employee@gocentralph.com", "password" => $employeePassword),
          array("id" => "6", "account_type_id" => 2,  "username" => "Server", "email" => "Employee@gocentralph.com", "password" => $employeePassword),
        ));
    }
}
