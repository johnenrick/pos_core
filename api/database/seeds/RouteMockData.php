<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RouteMockData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB:: table('routes')->truncate();
      DB:: table('route_stops')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');
      for($id = 1; $id <= 10; $id++){
        DB:: table('routes') -> insert(
          array(
            "id" => $id,
            "description" => $faker->state . ' to ' . $faker->city . ' via ' . $faker->state
          )
        );
        for($routeStopCount = 1; $routeStopCount < rand(10, 200); $routeStopCount++){
          DB:: table('route_stops') -> insert(
            array(
              "route_id" => $id,
              "order_number" => $routeStopCount,
              "name" => $faker->streetAddress,
              "distance" => rand(1, 10)
            )
          );
        }
      }
    }
}
