<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouteStop extends APIModel
{
    protected $fillable = ['id', 'order_number', 'distance', 'name'];
    public function route(){
      return $this->hasMany('App\Route');
    }
}
