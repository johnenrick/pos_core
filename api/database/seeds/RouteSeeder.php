<?php

use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB:: table('routes')->truncate();
      DB:: table('route_stops')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');
      $routes  = [
        [
          "id" => 1,
          "description" => "NBT to Hagnaya"
        ]
      ];
      $routeStops = [
        [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Mandaue",
          "distance" => 8
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Consolacion",
          "distance" => 13
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Bag-ong Dan",
          "distance" => 15
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Yate",
          "distance" => 18
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Lilo-an",
          "distance" => 20
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Cotcot",
          "distance" => 22
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Compostela",
          "distance" => 26
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Maslong",
          "distance" => 28
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Sabang",
          "distance" => 30
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Danao",
          "distance" => 33
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Ginsay",
          "distance" => 35
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Camen",
          "distance" => 42
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Luyang",
          "distance" => 43
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Buyo",
          "distance" => 44
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Binangkalan",
          "distance" =>
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Panalipan",
          "distance" =>
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Tinibgan",
          "distance" =>
        ], [
          "order_number" => ,
          "route_id" => 1,
          "name" => "Catmon Daan",
          "distance" =>
        ]
      ];
      DB:: table('routes') -> insert($routes);
      DB:: table('route_routes') -> insert($routeStops);
    }
}
