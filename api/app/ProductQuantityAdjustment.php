<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductQuantityAdjustment extends APIModel
{
  public function  product(){
    return $this->belongsTo('App\Product','product_id');
  }
  public function  quantity_adjustment_type(){
    return $this->belongsTo('App\QuantityAdjustmentType','quantity_adjustment_type_id');
  }
}
