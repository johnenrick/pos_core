<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends APIModel
{

  public function route_stops(){
    return $this->hasMany('App\RouteStop')->orderBy('order_number');
  }
}
