<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BusMockData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      DB:: table('buses')->truncate();
      for($id = 1; $id <= 20; $id++){
        DB:: table('buses') -> insert(
          array(
            "id" => $id,
            "bus_type_id" => rand(1, 2),
            "description" => "Bus $id",
            "plate_number" => strtoupper(substr(uniqid('', true), -3)) . '-' . strtoupper(substr(uniqid('', true), -4)),
            "passenger_capacity" => rand(10, 70),
            "weight_capacity" => rand(100, 200),
            "remarks" => ($faker->sentences(1))[0]
          )
        );
      }
    }
}
