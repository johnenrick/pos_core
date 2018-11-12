<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InspectorReport extends APIModel
{
  public function bus_trip( ){
    return $this->belongsTo('App\BusTrip')->with(['bus', 'route', 'conductor', 'driver']);
  }
  public function account( ){
    return $this->belongsTo('App\Account')->with('account_information');
  }
  public function system_passenger_count(){
    return $this->hasMany('App\BusTripTicket', 'bus_trip_id', 'bus_trip_id')->select([DB::raw('COUNT(*) as count'), 'bus_trip_id'])->groupBy('bus_trip_id');
  }
}
