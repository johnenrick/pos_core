<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusTripTicket extends APIModel
{
  public function bus_trip( ){
    return $this->belongsTo('App\BusTrip')->with(['bus', 'route', 'driver']);
  }
  public function conductor(){
    return $this->belongsTo('App\Account', 'conductor_account_id')->with('account_information');
  }
  public function start_route_stop(){
    return $this->belongsTo('App\RouteStop', 'start_route_stop_id');
  }
  public function end_route_stop(){
    return $this->belongsTo('App\RouteStop', 'end_route_stop_id');
  }
  public function void_bus_trip_tickets(){
    return $this->hasMany('App\VoidBusTripTicket')->where('is_approved', 0); // Get the pending only
  }
}
