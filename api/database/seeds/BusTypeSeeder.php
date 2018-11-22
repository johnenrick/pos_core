<?php

use Illuminate\Database\Seeder;

class BusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB:: table('bus_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB:: table('bus_types') -> insert([
          [
            "description" => "Ordinary",
            "base_price" => 20,
            "price_per_distance" => 5
          ],
          [
            "description" => "Air Condition",
            "base_price" => 40,
            "price_per_distance" => 10
          ]
        ]);

    }
}
