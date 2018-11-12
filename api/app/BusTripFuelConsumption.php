<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusTripFuelConsumption extends APIModel
{
  public function bus_trip(){
    return $this->belongsTo('App\BusTrip')->with(['bus', 'route_only']);
  }
}
