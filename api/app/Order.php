<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends APIModel
{
  public function order_products(){
    return $this->hasMany('App\OrderProduct');
  }
}
