<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends APIModel
{
  protected $fillable = [
      'sale_price', 'quantity', 'product_id'
  ];
  public function product(){
    return $this->belongsTo('App\Product');
  }
}
