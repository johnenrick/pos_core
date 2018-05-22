<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionCount extends APIModel
{
  public function  product(){
    return $this->belongsTo('App\Product','product_id');
  }
}
