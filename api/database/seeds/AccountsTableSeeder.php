<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $faker = Faker::create();
        $adminPassword = Hash::make('admin');
        $employeePassword = Hash::make('employee');
        DB:: table('accounts')->truncate();
        DB:: table('accounts')-> insert(array(
          array("id" => "1", "account_type_id" => 1, "username" => "Admin", "email" => "admin@gmail.com", "password" => $adminPassword, "pin" => 1234),
          array("id" => "2", "account_type_id" => 4, "username" => "Conductor", "email" => "conductor@gmail.com", "password" => Hash::make('conductor'), "pin" => 1234),
          array("id" => "3", "account_type_id" => 3, "username" => "Driver", "email" => "driver@gmail.com", "password" => Hash::make('driver'), "pin" => 1234),
          array("id" => "4", "account_type_id" => 5, "username" => "Cashier", "email" => "cashier@gmail.com", "password" => Hash::make('cashier'), "pin" => 1234),
          array("id" => "5", "account_type_id" => 6,  "username" => "Cook", "email" => "cook@gmail.com", "password" => Hash::make('cook'), "pin" => 1234),
          array("id" => "6", "account_type_id" => 7,  "username" => "Server", "email" => "server@gmail.com", "password" => Hash::make('server'), "pin" => 1234)
        ));
        // mock conductor data
        for($id = 7; $id <= 57; $id++){
          DB:: table('accounts') -> insert(
            array("id" => $id, "account_type_id" => 4, "username" => "Conductor$id", "email" => "conductor$id@gmail.com", "password" => Hash::make('conductor'), "pin" => 1234)
          );
        }
        // mock driver data
        for($id = 58; $id <= 108; $id++){
          DB:: table('accounts') -> insert(
            array("id" => $id, "account_type_id" => 3, "username" => "Driver", "email" => "driver@gmail.com", "password" => Hash::make('driver'), "pin" => 1234)
          );
        }
        // mock inspector data
        for($id = 109; $id <= 130; $id++){
          DB:: table('accounts') -> insert(
            array("id" => $id, "account_type_id" => 8, "username" => "Inspector".$faker->firstName, "email" => $faker->email, "password" => Hash::make('inspector'), "pin" => 1234)
          );
        }

        DB:: table('account_informations')->truncate();
        for($accountInformationID = 1; $accountInformationID <= $id; $accountInformationID++){
          DB:: table('account_informations') -> insert(array(
            array("id" => $accountInformationID, "account_id" => $accountInformationID, "first_name" => $faker->firstName, "middle_name" => $faker->lastName, "last_name" => $faker->lastName)
          ));
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
