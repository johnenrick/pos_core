<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends APIModel
{
  public function bus_type(){
    return $this->belongsTo('App\BusType');
  }
}
