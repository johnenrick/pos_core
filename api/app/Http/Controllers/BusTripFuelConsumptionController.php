<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusTripFuelConsumption as DBItem;

class BusTripFuelConsumptionController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->foreignTable = ['bus_trip'];
    $this->leftJoinChildTable = ['bus_trips.bus' => null];
    $this->aliased = [
      'total_reading' => '(bus_trip_fuel_consumptions.start_reading - bus_trip_fuel_consumptions.end_reading)'
    ];

    $this->select = ["bus_trip_fuel_consumptions.*"];
  }
}
